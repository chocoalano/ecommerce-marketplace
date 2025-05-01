<?php

namespace App\Filament\Admin\Resources\EwalletTransactionResource\Pages;

use App\Filament\Admin\Resources\EwalletTransactionResource;
use App\Repositories\Interfaces\EwaletTransactionInterface;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ManageEwalletTransactions extends ManageRecords
{
    protected static string $resource = EwalletTransactionResource::class;

    protected function getHeaderActions(): array
    {
        $proses = App::make(EwaletTransactionInterface::class);
        return [
            Actions\CreateAction::make()
            ->using(function (array $data) use ($proses): Model {
                return $proses->create($data);
            }),
        ];
    }
}
