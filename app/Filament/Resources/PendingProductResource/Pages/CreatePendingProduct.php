<?php

namespace App\Filament\Resources\PendingProductResource\Pages;

use App\Filament\Resources\PendingProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePendingProduct extends CreateRecord
{
    protected static string $resource = PendingProductResource::class;
}
