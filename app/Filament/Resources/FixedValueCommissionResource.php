<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FixedValueCommissionResource\Pages;
use App\Filament\Resources\FixedValueCommissionResource\RelationManagers;
use App\Models\Commissions\FixedValueCommission;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FixedValueCommissionResource extends Resource
{
    protected static ?string $model = FixedValueCommission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationParentItem = 'Commissions';

    protected static ?string $navigationGroup = 'Shop Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->rules('gte:0'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('value')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFixedValueCommissions::route('/'),
            'create' => Pages\CreateFixedValueCommission::route('/create'),
            'edit' => Pages\EditFixedValueCommission::route('/{record}/edit'),
        ];
    }
}
