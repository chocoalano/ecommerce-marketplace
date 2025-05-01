<?php
namespace App\Filament\Component\Tables;

use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;

class OrderTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            TextColumn::make('buyer.name')
                ->searchable()
                ->sortable(),
            TextColumn::make('payment.amount_paid')
                ->money('IDR')
                ->sortable(),
            TextColumn::make('total_price')
                ->money('IDR')
                ->sortable(),
            SelectColumn::make('status')
                ->options([
                    'pending' => 'pending',
                    'paid' => 'paid',
                    'shipped' => 'shipped',
                    'completed' => 'completed',
                    'cancelled' => 'cancelled',
                ]),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
        ];
    }
}
