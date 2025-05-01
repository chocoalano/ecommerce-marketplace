<?php
namespace App\Filament\Component\Forms;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
class CartForm
{
    public static function form(): array
    {
        return [
            Select::make('buyer_id')
                ->label('Buyer')
                ->relationship('buyer', 'name')
                ->required(),
            Select::make('product')
                ->label('Product')
                ->relationship('products', 'name')
                ->required(),
            TextInput::make('total_price')->numeric()->prefix('Rp.')->required()
        ];
    }
}
