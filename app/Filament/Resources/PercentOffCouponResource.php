<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PercentOffCouponResource\Pages;
use App\Filament\Resources\PercentOffCouponResource\RelationManagers;
use App\Models\Coupons\PercentOffCoupon;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PercentOffCouponResource extends Resource
{
    protected static ?string $model = PercentOffCoupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationParentItem = 'Coupons';

    protected static ?string $navigationGroup = 'Shop Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('percent_off')
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
                TextColumn::make('percent_off')->sortable(),
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
            'index' => Pages\ListPercentOffCoupons::route('/'),
            'create' => Pages\CreatePercentOffCoupon::route('/create'),
            'edit' => Pages\EditPercentOffCoupon::route('/{record}/edit'),
        ];
    }
}
