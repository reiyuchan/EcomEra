<?php

namespace App\Filament\Resources\PercentOffCommissionResource\Pages;

use App\Filament\Resources\PercentOffCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPercentOffCommission extends EditRecord
{
    protected static string $resource = PercentOffCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
