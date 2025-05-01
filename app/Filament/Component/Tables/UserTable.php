<?php
namespace App\Filament\Component\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class UserTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('email')
                ->searchable(),
            TextColumn::make('email_verified_at')
                ->dateTime()
                ->sortable(),
            TextColumn::make('phone_number')
                ->searchable(),
            TextColumn::make('type')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'admin' => 'gray',
                    'seller' => 'success',
                    'buyer' => 'danger',
                }),
            ImageColumn::make('profile_picture')->circular(),
            TextColumn::make('ewallet_balance')
                ->numeric()
                ->money('IDR')
                ->sortable(),
            IconColumn::make('activation')
                ->boolean(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('deleted_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
