<?php
namespace App\Filament\Component\Forms;

use App\Models\Payment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;

class PaymentForm
{
    public static function form(): array
    {
        return [
            ToggleButtons::make('payment_method')
                ->options(Payment::PAYMENT_METHOD)
                ->inline()
                ->disabled(auth()->user()->type === 'seller' ? true : false),
            Radio::make('payment_status')
                ->inline(false)
                ->options(Payment::PAYMENT_STATUS)
                ->disabled(auth()->user()->type === 'seller' ? true : false)
                ->requiredIfAccepted('payment_method'),
            DateTimePicker::make('payment_date')
                ->disabled(auth()->user()->type === 'seller' ? true : false)
                ->requiredIfAccepted('payment_method'),
            TextInput::make('amount_paid')
                ->disabled(auth()->user()->type === 'seller' ? true : false)
                ->requiredIfAccepted('payment_method')
                ->numeric(),
        ];
    }
}
