<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PaymentResource\Pages;
use App\Filament\Admin\Resources\PaymentResource\RelationManagers;
use App\Filament\Component\Forms\PaymentForm;
use App\Filament\Component\Tables\PaymentTable;
use App\Models\Payment;
use App\Repositories\Interfaces\PaymentInterface;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'hugeicons-payment-success-02';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(PaymentForm::form());
    }

    public static function table(Table $table): Table
    {
        $proses = App::make(PaymentInterface::class);
        return $table
            ->query(fn() => $proses->filament_table())
            ->columns(PaymentTable::table())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('payment_method')->options(Payment::PAYMENT_METHOD),
                SelectFilter::make('payment_status')->options(Payment::PAYMENT_STATUS),
                Filter::make('payment_date')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('payment_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('payment_date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data) use ($proses): Model {
                        return $proses->update($record->id, $data);
                    })
                ,
                Tables\Actions\DeleteAction::make()
                    ->using(function ($record) use ($proses) {
                        return $proses->delete($record->id);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePayments::route('/'),
        ];
    }
}
