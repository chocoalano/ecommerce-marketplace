<?php
namespace App\Filament\Component\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Foundation\Auth\User;
use Mokhosh\FilamentRating\Columns\RatingColumn;

class ProductTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            // TextColumn::make('id')->searchable(),
            TextColumn::make('seller.id')->searchable()
                ->formatStateUsing(fn(string $state): string => User::find($state)->name),
            TextColumn::make('category.name')
                ->searchable(),
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('price')
                ->money('IDR')
                ->sortable(),
            TextColumn::make('stock')
                ->numeric()
                ->sortable(),
            ImageColumn::make('primary_image'),
            RatingColumn::make('rating')
                ->sortable(),
            TextColumn::make('status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'active' => 'success', 'inactive' => 'danger'
                }),
            TextColumn::make('slug')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
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
