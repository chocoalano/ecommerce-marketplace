<?php

namespace App\Filament\Admin\Resources\PaymentResource\Pages;

use App\Filament\Admin\Resources\PaymentResource;
use App\Repositories\Interfaces\PaymentInterface;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ManagePayments extends ManageRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        $proses = App::make(PaymentInterface::class);
        return [
            Actions\CreateAction::make()
                ->using(function (array $data) use ($proses): Model {
                    return $proses->create($data);
                }),
        ];
    }
}
