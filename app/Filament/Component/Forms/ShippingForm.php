<?php
namespace App\Filament\Component\Forms;

use App\Models\Shipping;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;

class ShippingForm
{
    public static function form(): array
    {
        return [
            TextInput::make('order_id')
                ->required()
                ->numeric(),
            ToggleButtons::make('shipping_status')
                ->options(Shipping::STATUS)
                ->inline()
                ->grouped(),
            DateTimePicker::make('shipping_date')
                ->requiredIfAccepted('shipping_status'),
            TextInput::make('tracking_number')
                ->requiredIfAccepted('shipping_status')
                ->maxLength(100),
            Textarea::make('shipping_address')
                ->requiredIfAccepted('shipping_status')
                ->columnSpanFull(),
        ];
    }
}
