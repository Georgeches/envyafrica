<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'order_items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('order_id')
                                ->label('Order')
                                ->options(
                                    Order::all()->pluck('number', 'id')->toArray()
                                ),
                                Forms\Components\Select::make('product_id')
                                        ->options(Product::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->label('Product')
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                                            $set('price', Product::find($state)->price ?? 0);
                                        }),
                                Forms\Components\TextInput::make('price'),
                                Forms\Components\TextInput::make('quantity')
                            ]),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('price')
            ->columns([
                Tables\Columns\TextColumn::make('order.number'),
                Tables\Columns\ImageColumn::make('product.image')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('product.name'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('quantity'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name'),
                Tables\Filters\SelectFilter::make('order')
                    ->relationship('order', 'number')
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
