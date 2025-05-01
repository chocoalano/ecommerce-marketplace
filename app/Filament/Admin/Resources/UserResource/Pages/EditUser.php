<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use App\Repositories\Interfaces\UserInterface;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class EditUser extends EditRecord
{

    protected static string $resource = UserResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $proses = App::make(abstract: UserInterface::class);
        $fill = $proses->find($data['id']);
        if ($fill->seller) {
            $data = array_merge($data, $fill->seller->toArray());
        }
        return $data;
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $proses = App::make(abstract: UserInterface::class);
        return $proses->update($record->id, $data);
    }
}
