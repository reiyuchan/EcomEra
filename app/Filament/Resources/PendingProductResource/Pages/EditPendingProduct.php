<?php

namespace App\Filament\Resources\PendingProductResource\Pages;

use App\Filament\Resources\PendingProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPendingProduct extends EditRecord
{
    protected static string $resource = PendingProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if (!$this->record->approved) {
            Notification::make()
                ->warning()
                ->title('This product is not approved')
                ->body('Please tick the checkbox after reviewing data to approve product to be saved as a product')
                ->persistent()
                ->send();
            return;
        }

        Product::create([
            'name' => $this->record->name,
            'slug' => $this->record->slug,
            'details' => $this->record->details,
            'description' => $this->record->description,
            'price' => $this->record->price,
            'discounted_price' => $this->record->discounted_price,
            'quantity' => $this->record->quantity,
            'product_code' => $this->record->product_code,
            'images' => $this->record->images,
            'user_id' => $this->record->user_id,
        ])->categories()->attach($this->data['category_id']);

        Notification::make()
            ->success()
            ->title('Product approved')
            ->body('This product has been approved and saved as a product')
            ->send();
    }
}
