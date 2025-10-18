<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommissionResource\Pages;
use App\Filament\Resources\CommissionResource\RelationManagers;
use App\Models\Commissions\Commission;
use App\Models\Commissions\FixedValueCommission;
use App\Models\Commissions\PercentOffCommission;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CommissionResource extends Resource
{
    protected static ?string $model = Commission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Shop Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->rules('gt:0'),
                Fieldset::make('Commission')
                    ->schema([
                        Select::make('commission_type_select')
                            ->label('Commission Type')
                            ->options([
                                'value' => 'Value',
                                'percent_off' => 'Percent Off'
                            ])->live(),
                        TextInput::make('value')
                            ->numeric()
                            ->visible(fn(Forms\Get $get) => $get('commission_type_select') === 'value'),
                        TextInput::make('percent_off')
                            ->numeric()
                            ->visible(fn(Forms\Get $get) => $get('commission_type_select') === 'percent_off'),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('Save')
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $option = $get('commission_type_select');
                                    switch ($option) {
                                        case 'value':
                                            $value = $get('value');
                                            if (!$value || $value < 0) {
                                                Notification::make()
                                                    ->danger()
                                                    ->title('Value field must not be empty')
                                                    ->body('Please enter a value for coupon')
                                                    ->send();
                                                return;
                                            }
                                            FixedValueCommission::create([
                                                'value' => $value,
                                            ]);
                                            break;
                                        case 'percent_off':
                                            $percent_off = $get('percent_off');
                                            if (!$percent_off || $percent_off < 0) {
                                                Notification::make()
                                                    ->danger()
                                                    ->title('Precent off field must not be empty')
                                                    ->body('Please enter a percent for coupon (ex: 05.')
                                                    ->send();
                                                return;
                                            }
                                            PercentOffCommission::create([
                                                'percent_off' => $percent_off,
                                            ]);
                                            break;
                                        default:
                                            break;
                                    }
                                }),
                        ]),
                    ]),
                Select::make('user_id')
                    ->required()
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload(),
                Select::make('order_id')
                    ->required()
                    ->relationship('order', 'confirmation_number')
                    ->searchable()
                    ->preload(),
                MorphToSelect::make('commissionable')
                    ->types(
                        [
                            MorphToSelect\Type::make(FixedValueCommission::class)->titleAttribute('value'),
                            MorphToSelect\Type::make(PercentOffCommission::class)->titleAttribute('percent_off'),
                        ]
                    )->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')->sortable(),
                TextColumn::make('user.email')->sortable(),
                TextColumn::make('commissionable_type')->badge()->getStateUsing(function (Commission $record) {
                    return $record->commissionable_type = Str::contains($record->commissionable_type, ['Fixed', 'Value']) ? 'Fixed Value' : 'Percent Off';
                })->sortable(),
                TextColumn::make('order.confirmation_number')->sortable(),
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
            'index' => Pages\ListCommissions::route('/'),
            'create' => Pages\CreateCommission::route('/create'),
            'edit' => Pages\EditCommission::route('/{record}/edit'),
        ];
    }
}
