<?php

namespace App\Filament\Admin\Resources\ShippingResource\Pages;

use App\Filament\Admin\Resources\ShippingResource;
use App\Repositories\Interfaces\ShippingInterface;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ManageShippings extends ManageRecords
{
    protected static string $resource = ShippingResource::class;

    protected function getHeaderActions(): array
    {
        $proses = App::make(ShippingInterface::class);
        return [
            Actions\CreateAction::make()
                ->using(function (array $data) use ($proses): Model {
                    return $proses->create($data);
                }),
        ];
    }
}
