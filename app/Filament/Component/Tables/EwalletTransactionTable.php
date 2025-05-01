<?php
namespace App\Filament\Component\Tables;

use Filament\Tables\Columns\TextColumn;

class EwalletTransactionTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            TextColumn::make('user.name')
                ->searchable(),
            TextColumn::make('transaction_type')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'credit' => 'success',
                    'debit' => 'info',
                }),
            TextColumn::make('amount')
                ->money('IDR')
                ->sortable(),
            TextColumn::make('balance')
                ->money('IDR')
                ->sortable(),
            TextColumn::make('transaction_at')
                ->dateTime()
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
