<?php
namespace App\Filament\Component\Tables;

use Filament\Tables\Columns\TextColumn;

class ProductCategoryTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('slug')
                ->searchable(),
            TextColumn::make('status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'active' => 'success',
                    'inactive' => 'danger',
                })
                ->searchable(),
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
