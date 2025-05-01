<?php
namespace App\Filament\Component\Tables;

use Filament\Tables\Columns\TextColumn;

class ShippingTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            TextColumn::make('tracking_number')->searchable(),
            TextColumn::make('shipping_status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'pending' => 'gray', 'shipped' => 'info', 'delivered' => 'success', 'failed' => 'danger'
                }),
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
