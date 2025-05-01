<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use App\Repositories\Interfaces\OrderPatternInterface;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ManageOrders extends ManageRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        $proses = App::make(OrderPatternInterface::class);
        return [
            Actions\CreateAction::make()
                ->slideOver()
                ->modalWidth('7xl')
                ->using(function (array $data) use ($proses): Model {
                    return $proses->create($data);
                }),
        ];
    }
}
