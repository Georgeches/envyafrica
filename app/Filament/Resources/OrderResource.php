<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\OrderStatusEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemsRelationManager;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'number';

    public static function getGlobbalySearchableAttributes(): array{
        return ['number', 'customer.firstname', 'customer.email', 'customer.secondname'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array{
        return [
            'customer' => $record->customer->email
        ];
    }


    public static function getNavigationBadge(): ?string
    {
        $totalNewOrders = Order::where('status', 'like', '%pending')->count();
        return ($totalNewOrders > 0) ? $totalNewOrders : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Order Details')
                        ->schema([
                            Forms\Components\TextInput::make('number')
                                ->label('Order number')
                                ->disabled()
                                ->default(random_int(1000000, 9999999))
                                ->dehydrated()
                                ->required()
                                ->unique(ignoreRecord: true),
                            Forms\Components\Select::make('customer_id')
                                ->label('Customer')
                                ->options(
                                    Customer::all()->pluck('email', 'id')->toArray()
                                )
                                ->searchable()
                                ->required(),
                            Forms\Components\Select::make('status')
                                ->label('Status')
                                ->options([
                                    'pending' => OrderStatusEnum::PENDING->value,
                                    'processing' => OrderStatusEnum::PROCESSING->value,
                                    'completed' => OrderStatusEnum::COMPLETED->value,
                                    'declined' => OrderStatusEnum::DECLINED->value,
                                ])
                                ->required(),
                            Forms\Components\TextInput::make('shipping_price')
                                ->label('Shipping price')
                                ->numeric()
                                ->required(),
                            Forms\Components\MarkdownEditor::make('notes')
                                ->label('Notes')
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(2),

                    Forms\Components\Wizard\Step::make('Order Items')
                        ->schema([
                            Forms\Components\Repeater::make('order_items')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make('product_id')
                                        ->options(Product::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->columnSpanFull()
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                                            $set('price', Product::find($state)->price ?? 0);
                                        }),
                                    Forms\Components\TextInput::make('price'),
                                    Forms\Components\TextInput::make('color')
                                ]),
                        ])->columns(2)
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('Order Number')
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.firstname')
                    ->label('Customer first name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('customer.secondname')
                    ->label('Customer last name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('customer.email')
                    ->label('Customer email')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->toggleable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer.phone')
                    ->label('Customer phone')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_price')
                    ->label('Shipping price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('customer')
                    ->relationship('customer', 'email')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            OrderItemsRelationManager::class
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
