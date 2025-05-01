<?php
namespace App\Filament\Component\Forms;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
class SellerForm
{
    public static function form(): array
    {
        return [
            TextInput::make('phone_number')->unique('users')->numeric()->tel()->required(),
            TextInput::make('store_name')->unique('sellers')->required(),
            FileUpload::make('logo')->directory('logo-store')->required(),
            Textarea::make('description')->required(),
            Textarea::make('store_address')->required(),
        ];
    }
}
