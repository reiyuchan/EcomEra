<?php

namespace App\Filament\Resources\FixedValueCommissionResource\Pages;

use App\Filament\Resources\FixedValueCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFixedValueCommissions extends ListRecords
{
    protected static string $resource = FixedValueCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
