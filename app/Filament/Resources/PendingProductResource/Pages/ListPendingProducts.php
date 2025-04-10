<?php

namespace App\Filament\Resources\PendingProductResource\Pages;

use App\Filament\Resources\PendingProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendingProducts extends ListRecords {
    protected static string $resource = PendingProductResource::class;

    protected function getHeaderActions(): array {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
