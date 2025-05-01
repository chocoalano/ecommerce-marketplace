<?php

namespace App\Filament\Seller\Resources;

use App\Filament\Seller\Resources\OrderResource\Pages;
use App\Filament\Seller\Resources\OrderResource\RelationManagers;
use App\Filament\Component\Forms\OrderForm;
use App\Filament\Component\Tables\OrderTable;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Repositories\Interfaces\OrderPatternInterface;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                Tables\Actions\Action::make('shipping')
                    ->slideOver()
                    ->modalWidth('7xl')
                    ->fillForm(fn(Order $record): array => [
                        'shippings' => $record->item->map(fn($item) => [
                            'order_item_id' => $item->id,
                            'product_id' => $item->product_id,
                            'tracking_number' => $item->shipping?->tracking_number ?? null,
                            'shipping_status' => $record->status,
                            'notes' => $item->shipping?->notes ?? null,
                        ])->toArray()
                    ])
                    ->form([
                        Repeater::make('shippings')
                            ->schema([
                                TextInput::make('order_item_id')->hidden(),
                                Select::make('product_id')
                                    ->label('Produk')
                                    ->options(Product::query()->pluck('name', 'id')->toArray())
                                    ->required(),
                                TextInput::make('tracking_number')->label('No Resi')->required(),
                                Select::make('shipping_status')
                                    ->label('Status Pengiriman')
                                    ->options([
                                        'pending' => 'Pending',
                                        'shipped' => 'Dikirim',
                                        'delivered' => 'Diterima',
                                        'canceled' => 'Dibatalkan',
                                    ])
                                    ->required(),
                                TextInput::make('notes')->label('Catatan')->nullable(),
                            ])
                            ->columns(4),
                    ])
                    ->action(function (array $data) {
                        foreach ($data['shippings'] as $k) {
                            Shipping::updateOrCreate([
                                'order_item_id' => $k['order_item_id'],
                            ], [
                                'order_item_id' => $k['order_item_id'],
                                'tracking_number' => $k['tracking_number'],
                                'shipping_status' => $k['shipping_status'],
                                'notes' => $k['notes'],
                            ]);
                        }
                    }),
                Tables\Actions\EditAction::make()
                    ->slideOver()
                    ->modalWidth('7xl')
                    ->mutateRecordDataUsing(function (array $data) use ($proses): array {
                        $filled = $proses->find($data['id']);
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
                        $merged = array_merge($data, $filled['payment'] ?? [], $filled['shipping'] ?? []);
                        return $merged;
                    })
                    ->using(function (Model $record, array $data) use ($proses): Model {
                        $filled = $proses->find($record->id);
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
                        $merged = array_merge($data, $filled['payment'] ?? []);
                        return $proses->update($record->id, $merged);
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
