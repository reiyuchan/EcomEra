<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupons\Coupon;
use App\Models\Coupons\FixedValueCoupon;
use App\Models\Coupons\PercentOffCoupon;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Section;
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

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Shop Management';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->required()
                    ->default(Str::random(5))
                    ->unique(),
                TextInput::make('length_of_code'),
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('Generate')
                        ->action(function (Forms\Get $get, Forms\Set $set) {
                            $length = $get('length_of_code');
                            if (!$length || $length < 0) {
                                Notification::make()
                                    ->danger()
                                    ->title('Input length of code')
                                    ->body('Please input the length of code to be generated')
                                    ->send();
                                return;
                            }
                            $set('code', Str::upper(Str::random($length)));
                        }),
                ]),
                Fieldset::make('Coupon')
                    ->schema([
                        Select::make('couponable_type_select')
                            ->label('Couponable Type')
                            ->options([
                                'value' => 'Value',
                                'percent_off' => 'Percent Off'
                            ])->live(),
                        TextInput::make('value')
                            ->numeric()
                            ->visible(fn(Forms\Get $get) => $get('couponable_type_select') === 'value'),
                        TextInput::make('percent_off')
                            ->numeric()
                            ->visible(fn(Forms\Get $get) => $get('couponable_type_select') === 'percent_off'),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('Save')
                                ->action(function (Forms\Get $get, Forms\Set $set) {
                                    $option = $get('couponable_type_select');
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
                                            FixedValueCoupon::create([
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
                                            PercentOffCoupon::create([
                                                'percent_off' => $percent_off,
                                            ]);
                                            break;
                                        default:
                                            break;
                                    }
                                }),
                        ]),
                    ]),
                MorphToSelect::make('couponable')
                    ->types(
                        [
                            MorphToSelect\Type::make(FixedValueCoupon::class)->titleAttribute('value'),
                            MorphToSelect\Type::make(PercentOffCoupon::class)->titleAttribute('percent_off'),
                        ]
                    )->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->sortable(),
                TextColumn::make('couponable_id')->sortable(),
                TextColumn::make('couponable_type')->badge()->getStateUsing(function (Coupon $record) {
                    return $record->couponable_type = Str::contains($record->couponable_type, ['Fixed', 'Value']) ? 'Fixed Value' : 'Percent Off';
                })->sortable(),
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
            //,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
