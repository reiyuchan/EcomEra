<?php

namespace App\Filament\Resources\PendingProductResource\Pages;

use App\Filament\Resources\PendingProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreatePendingProduct extends CreateRecord
{
    protected static string $resource = PendingProductResource::class;

    protected function afterCreate(): void
    {
        $this->record->product_code = Str::upper(Str::random(4)) . $this->record->categories()->find($this->data['category_id'])->id;

        $value = $this->record->name . " " . Str::random(4) . $this->record->id;

        $slug = Str::slug($value);

        $this->record->slug = $slug;
        $this->record->save();
    }
}
