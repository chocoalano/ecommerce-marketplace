<?php
namespace App\Filament\Component\Forms;

use App\Models\EwalletTransaction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Support\Carbon;
class EwalletTransactionForm
{
    public static function form(): array
    {
        return [
            Select::make('user_id')
                ->relationship('user', 'name')
                ->createOptionForm(UserForm::form())
                ->editOptionForm(UserForm::form())
                ->searchable()
                ->default(fn(): int => auth()->user()->type === 'seller' ? auth()->id() : null)
                ->visible(fn(): bool => auth()->user()->type === 'admin' ? true : false)
                ->required(),
            ToggleButtons::make('transaction_type')
                ->options(EwalletTransaction::TYPE)
                ->inline()
                ->grouped()
                ->required(),
            TextInput::make('amount')
                ->required()
                ->numeric(),
            TextInput::make('balance')
                ->required()
                ->numeric(),
            DateTimePicker::make('transaction_at')
                ->default(auth()->user()->type === 'seller' ? Carbon::now()->format('Y-m-d H:i:s') : null)
                ->visible(fn(): bool => auth()->user()->type === 'admin' ? true : false),
        ];
    }
}
