<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ShippingResource\Pages;
use App\Filament\Admin\Resources\ShippingResource\RelationManagers;
use App\Filament\Component\Forms\ShippingForm;
use App\Filament\Component\Tables\ShippingTable;
use App\Models\Shipping;
use App\Repositories\Interfaces\ShippingInterface;
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

class ShippingResource extends Resource
{
    protected static ?string $model = Shipping::class;

    protected static ?string $navigationIcon = 'fas-shipping-fast';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(ShippingForm::form());
    }

    public static function table(Table $table): Table
    {
        $proses = App::make(ShippingInterface::class);
        return $table
            ->query($proses->filament_table())
            ->columns(ShippingTable::table())
            ->filters([
                SelectFilter::make('shipping_status')->options(Shipping::STATUS),
                Filter::make('shipping_date')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('shipping_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('shipping_date', '<=', $date),
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
            'index' => Pages\ManageShippings::route('/'),
        ];
    }
}
