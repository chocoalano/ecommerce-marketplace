<?php
namespace App\Filament\Component\Forms;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Illuminate\Support\Carbon;

class UserForm
{
    public static function form():array
    {
        return [
            Section::make([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at')
                ->default(Carbon::now()->format('Y-m-d H:i:s')),
                TextInput::make('password')
                    ->password()
                    ->confirmed()
                    ->required(),
                TextInput::make('password_confirmation')
                    ->password()
                    ->required(),
                TextInput::make('phone_number')
                    ->tel()
                    ->maxLength(20),
                ToggleButtons::make('type')
                    ->options(User::TYPE)
                    ->inline()
                    ->grouped()
                    ->live()
                    ->required(),
                FileUpload::make('profile_picture')
                    ->directory('user-profile')
                    ->avatar()
                    ->required(),
                TextInput::make('ewallet_balance')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Toggle::make('activation')
                    ->required(),
            ])->columns(2),
            Section::make('Seller')
                ->hidden(fn(Get $get): bool => !$get('type') || $get('type') !== 'seller')
                ->schema(SellerForm::form())->columns(2)
        ];
    }
}
