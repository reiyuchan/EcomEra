<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendingProductResource\Pages;
use App\Models\PendingProduct;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PendingProductResource extends Resource
{
    protected static ?string $model = PendingProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Shop Management';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description', 'price'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->required(),
                Select::make('currency')
                    ->required()
                    ->options([
                        'usd' => 'USD',
                        'egp' => 'EGP',
                        'eur' => 'EUR',
                        'gbp' => 'GBP',
                    ])
                    ->default('EGP')
                    ->live(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->rules(['gt:0'])
                    ->prefix(fn(Get $get) => match ($get('currency')) {
                        'usd' => '$',
                        'gbp' => '£',
                        default => null,
                    })
                    ->suffix(fn(Get $get) => match ($get('currency')) {
                        'eur' => '€',
                        'egp' => '£',
                        default => null,
                    })
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->default(0),
                TextInput::make('quantity')
                    ->required()
                    ->integer()
                    ->rules(['gt:0'])
                    ->default(0),
                Select::make('user_id')
                    ->required()
                    ->label('User')
                    ->relationship('user', 'email', modifyQueryUsing: fn(Builder $query) => $query->whereHas('roles', function ($q) {
                        return $q->where('name', 'designer');
                    }))
                    ->searchable()
                    ->preload(),
                Select::make('category_id')
                    ->required()
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->searchable()
                    ->preload(),
                FileUpload::make('images')
                    ->required()
                    ->multiple()
                    ->moveFiles()
                    ->directory('products')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('approved')->badge()->color(fn(int $state): string => match ($state) {
                    false => 'warning',
                    true => 'success',
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('approve')
                    ->icon('heroicon-o-check-circle')
                    ->size('md')
                    ->action(function (PendingProduct $product, array $data) {
                        Product::create($data);
                        $product->update([
                            'approved' => true,
                        ]);
                    }),

                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPendingProducts::route('/'),
            'create' => Pages\CreatePendingProduct::route('/create'),
            'edit' => Pages\EditPendingProduct::route('/{record}/edit'),
        ];
    }
}
