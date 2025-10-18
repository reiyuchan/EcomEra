<?php

namespace App\Filament\Resources\FixedValueCouponResource\Pages;

use App\Filament\Resources\FixedValueCouponResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFixedValueCoupons extends ListRecords
{
    protected static string $resource = FixedValueCouponResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
