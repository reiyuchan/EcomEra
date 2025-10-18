<?php

namespace App\Filament\Resources\PercentOffCouponResource\Pages;

use App\Filament\Resources\PercentOffCouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPercentOffCoupons extends ListRecords
{
    protected static string $resource = PercentOffCouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
