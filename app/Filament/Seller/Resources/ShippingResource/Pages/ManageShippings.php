<?php

namespace App\Filament\Seller\Resources\ShippingResource\Pages;

use App\Filament\Seller\Resources\ShippingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageShippings extends ManageRecords
{
    protected static string $resource = ShippingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
