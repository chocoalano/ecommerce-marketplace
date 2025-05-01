<?php

namespace App\Filament\Component\Forms;

use App\Models\Order;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Shipping;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Carbon;

class OrderForm
{
    public static function form(): array
    {
        return [
            // Step 1: Order Details
            Section::make('Order Information')
                ->schema([
                    Select::make('buyer_id')
                        ->label('Buyer')
                        ->relationship('buyer', 'email')
                        ->disabled(auth()->user()->type === 'seller' ? true : false)
                        ->searchable()
                        ->required(),

                    Select::make('payment_id')
                        ->label('Payment')
                        ->relationship('payment', 'amount_paid')
                        ->disabled(auth()->user()->type === 'seller' ? true : false)
                        ->required(),

                    TextInput::make('total_price')
                        ->label('Total Price')
                        ->numeric()
                        ->disabled(auth()->user()->type === 'seller' ? true : false)
                        ->required(),

                    ToggleButtons::make('status')
                        ->label('Order Status')
                        ->options(Order::STATUS)
                        ->inline()
                        ->disabled(auth()->user()->type === 'seller' ? true : false)
                        ->required(),
                ])->columns(2),

            Section::make('Payment Details')
                ->schema(PaymentForm::form())
                ->columns(2),

            Section::make('Shipping Details')
                ->schema([
                    ToggleButtons::make('shipping_status')
                        ->label('Shipping Status')
                        ->options(Shipping::STATUS)
                        ->inline()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (string $state, Set $set) {
                            $cek = Shipping::latest()->first();
                            $set('shipping_date', Carbon::now()->format('Y-m-d H:i:s'));
                            $set('tracking_number', (int) $cek->tracking_number + 1);
                            return $state;
                        })
                        ->required(),

                    DateTimePicker::make('shipping_date')
                        ->label('Shipping Date')
                        ->requiredIfAccepted('shipping_status'),

                    TextInput::make('tracking_number')
                        ->label('Tracking Number')
                        ->maxLength(100)
                        ->requiredIfAccepted('shipping_status'),

                    Textarea::make('shipping_address')
                        ->label('Shipping Address')
                        ->requiredIfAccepted('shipping_status')
                        ->columnSpanFull(),
                ])->columns(3),

            Repeater::make('items')
                ->disabled(fn(): bool => auth()->user()->type === 'seller')
                ->schema([
                    Select::make('seller_id')
                        ->label('Seller')
                        ->options(
                            Seller::query()
                                ->with('user')
                                ->get()
                                ->filter(fn($seller) => $seller->user && $seller->user->name) // Filter null users or names
                                ->pluck('user.name', 'id')
                        )
                        ->searchable()
                        ->reactive(),

                    Select::make('product_id')
                        ->label('Product')
                        ->hidden(fn(Get $get): bool => $get('seller_id') === null)
                        ->options(function (Get $get): array {
                            $sellerId = $get('seller_id');
                            if ($sellerId) {
                                return Product::query()
                                    ->where('seller_id', $sellerId)
                                    ->get()
                                    ->filter(fn($product) => $product->name) // Filter null names
                                    ->pluck('name', 'id')
                                    ->toArray();
                            }
                            return [];
                        })
                        ->disabled(auth()->user()->type === 'seller')
                        ->reactive()
                        ->required(),

                    TextInput::make('qty')
                        ->label('Quantity')
                        ->numeric()
                        ->reactive()
                        ->afterStateUpdated(function ($state, Get $get, Set $set) {
                            $product = Product::find($get('product_id'));
                            if ($product) {
                                $set('item_price', $product->price);
                                $set('item_total_price', $product->price * $state);
                            }
                        })
                        ->required(),

                    TextInput::make('item_price')
                        ->label('Item Price')
                        ->numeric()
                        ->readOnly()
                        ->required(),
                    TextInput::make('item_total_price')
                        ->label('Total Price')
                        ->numeric()
                        ->readOnly()
                        ->required(),
                ])
                ->columns(5)
                ->columnSpanFull(),
        ];
    }
}
