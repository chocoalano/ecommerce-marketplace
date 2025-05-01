<?php

namespace App\Filament\Seller\Resources\ProductResource\Pages;

use App\Filament\Seller\Resources\ProductResource;
use App\Models\Seller;
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
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $seller = Seller::firstOrCreate(
                        ['user_id' => auth()->id()],
                        [
                            'store_name' => auth()->user()->name,
                            'description' => '',
                            'logo' => '',
                            'store_address' => '',
                            'rating' => 0.00,
                            'store_status' => 'active',
                        ]
                    );
                    $data['seller_id'] = $seller?->id;
                    $data['rating'] = 0.00;
                    return $data;
                })
                ->using(function (array $data, string $model): Model {
                    $proses = App::make(ProductPatternInterface::class);
                    return $proses->create($data);
                }),
        ];
    }
}
