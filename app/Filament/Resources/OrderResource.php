<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Shop Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('confirmation_number')
                    ->required()
                    ->maxLength(255),
                TextInput::make('billing_email')
                    ->required()
                    ->email(),
                TextInput::make('billing_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('billing_name_on_card')
                    ->required()
                    ->maxLength(255),
                TextInput::make('billing_address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('billing_city')
                    ->required()
                    ->maxLength(255),
                TextInput::make('billing_state')
                    ->required()
                    ->maxLength(255),
                TextInput::make('billing_zip_code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('billing_discount_code')
                    ->maxLength(255),
                TextInput::make('billing_discount')
                    ->required()
                    ->numeric()
                    ->rules('gte:0')
                    ->default(0),
                TextInput::make('billing_subtotal')
                    ->required()
                    ->numeric()
                    ->rules('gte:0'),
                TextInput::make('billing_total')
                    ->required()
                    ->numeric()
                    ->rules('gte:0'),
                Select::make('user_id')
                    ->required()
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload(),
                Checkbox::make('shipped')
                    ->hidden(fn(Forms\Get $get) => $get('cancelled'))
                    ->live(),
                Checkbox::make('cancelled')
                    ->hidden(fn(Forms\Get $get) => $get('shipped'))
                    ->live(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('confirmation_number')->badge()->sortable(),
                TextColumn::make('billing_email')->badge()->sortable(),
                TextColumn::make('billing_address')->sortable(),
                TextColumn::make('billing_city')->sortable(),
                TextColumn::make('billing_state')->sortable(),
                TextColumn::make('billing_zip_code')->sortable(),
                TextColumn::make('billing_discount_code')->sortable(),
                TextColumn::make('billing_discount')->badge()->sortable(),
                TextColumn::make('billing_subtotal')->badge()->sortable(),
                TextColumn::make('billing_total')->badge()->sortable(),
                TextColumn::make('shipped')->badge()->color(fn(string $state): string => match ($state) {
                    'Shipped' => 'success',
                    'Pending' => 'warning',
                })
                    ->getStateUsing(function (Order $order) {
                        return $order->shipped ? 'Shipped' : 'Pending';
                    })->sortable(),
                TextColumn::make('cancelled')->badge()->color(fn(string $state): string => match ($state) {
                    'Cancelled' => 'danger',
                    'Pending' => 'warning',
                    'Processed' => 'success',
                })
                    ->getStateUsing(function (Order $order) {
                        if ($order->shipped) {
                            return 'Processed';
                        }
                        return $order->cancelled ? 'Cancelled' : 'Pending';
                    })->sortable(),
                TextColumn::make('user.email')->badge()
                    ->label('User')->sortable(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
