<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EwalletTransactionResource\Pages;
use App\Filament\Admin\Resources\EwalletTransactionResource\RelationManagers;
use App\Filament\Component\Forms\EwalletTransactionForm;
use App\Filament\Component\Tables\EwalletTransactionTable;
use App\Models\EwalletTransaction;
use App\Repositories\Interfaces\EwaletTransactionInterface;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class EwalletTransactionResource extends Resource
{
    protected static ?string $model = EwalletTransaction::class;

    protected static ?string $navigationIcon = 'zondicon-wallet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(EwalletTransactionForm::form());
    }

    public static function table(Table $table): Table
    {
        $proses = App::make(EwaletTransactionInterface::class);
        return $table
            ->query(fn() => $proses->filament_table())
            ->columns(EwalletTransactionTable::table())
            ->filters([
                SelectFilter::make('transaction_type')->options(EwalletTransaction::TYPE),
                Filter::make('transaction_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('transaction_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('transaction_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data) use ($proses): Model {
                        return $proses->update($record->id, $data);
                    }),
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
            'index' => Pages\ManageEwalletTransactions::route('/'),
        ];
    }
}
