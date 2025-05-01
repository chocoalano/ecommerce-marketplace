<?php
namespace App\Filament\Component\Tables;

use Filament\Tables\Columns\TextColumn;

class CartTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            TextColumn::make('buyer.name')
                ->numeric()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
