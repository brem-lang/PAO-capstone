<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        // Clone the old record
        $oldRecord = $record->replicate();
        unset($oldRecord['deleted_at']);

        $record->replicatedData()->create($oldRecord->toArray());
        // Update the current record
        $record->update($data);

        return $record;
    }
}
