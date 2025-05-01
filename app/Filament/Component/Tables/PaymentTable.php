<?php
namespace App\Filament\Component\Tables;

use App\Models\Payment;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;

class PaymentTable
{
    public static function table(): array
    {
        return [
            TextColumn::make('No.')
                ->rowIndex(),
            SelectColumn::make('payment_method')
                ->options(Payment::PAYMENT_METHOD),
            TextColumn::make('payment_status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'pending' => 'gray', 'success' => 'success', 'failed' => 'danger'
                }),
            TextColumn::make('payment_date')
                ->dateTime()
                ->sortable(),
            TextColumn::make('amount_paid')
                ->money('IDR')
                ->sortable(),
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
