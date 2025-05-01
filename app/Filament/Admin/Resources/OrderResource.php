<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Filament\Component\Forms\OrderForm;
use App\Filament\Component\Tables\OrderTable;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Interfaces\OrderPatternInterface;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'mdi-order-bool-ascending-variant';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(OrderForm::form());
    }

    public static function table(Table $table): Table
    {
        $proses = App::make(OrderPatternInterface::class);
        return $table
            ->query(fn() => $proses->filament_table())
            ->columns(OrderTable::table())
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('status')->options(Order::STATUS),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until')->default(now()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('7xl')
                    ->mutateRecordDataUsing(function (array $data) use ($proses): array {
                        $filled = $proses->find($data['id']);
                        $data = [...$filled['payment'] ?? [], ...$filled['shipping'] ?? []];
                        $item = [];
                        if (count($filled['item']) > 0) {
                            foreach ($filled['item'] as $k) {
                                $product = Product::find($k['product_id']);

                                array_push($item, [
                                    'seller_id' => $product->seller_id,
                                    'product_id' => $product->id,
                                    'qty' => $k['qty'],
                                    'item_price' => $k['item_price'],
                                    'item_total_price' => $k['total_price'],
                                ]);
                            }
                        }
                        $data['items'] = $item;
                        return $data;
                    })
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
            'index' => Pages\ManageOrders::route('/'),
        ];
    }
}
