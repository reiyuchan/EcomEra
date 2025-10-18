<?php

namespace App\Filament\Resources\FixedValueCommissionResource\Pages;

use App\Filament\Resources\FixedValueCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFixedValueCommission extends EditRecord
{
    protected static string $resource = FixedValueCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
