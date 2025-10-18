<?php

namespace App\Filament\Resources\PercentOffCommissionResource\Pages;

use App\Filament\Resources\PercentOffCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPercentOffCommissions extends ListRecords
{
    protected static string $resource = PercentOffCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
