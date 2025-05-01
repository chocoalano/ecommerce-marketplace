<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use App\Repositories\Interfaces\ProductPatternInterface;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ManageProducts extends ManageRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        $proses = App::make(ProductPatternInterface::class);
        return [
            Actions\CreateAction::make()
                ->using(function (array $data) use ($proses): Model {
                    return $proses->create($data);
                }),
        ];
    }
}
