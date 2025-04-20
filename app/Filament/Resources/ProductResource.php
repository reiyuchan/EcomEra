<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use function GuzzleHttp\default_ca_bundle;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

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
                TextInput::make('slug')
                    ->required()
                    ->hidden()
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
                    ->default('egp')
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
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
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
                TextColumn::make('price'),
                TextColumn::make('quantity'),
                TextColumn::make('category.name')->badge(),
                ImageColumn::make('images'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
