<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProductImage;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductImageResource\Pages;
use App\Filament\Resources\ProductImageResource\RelationManagers;

class ProductImageResource extends Resource
{
    protected static ?string $model = ProductImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                ->label('Product')
                                ->options(
                                    Product::all()->pluck('name', 'id')->toArray()
                                ),
                            ]),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Image')
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('product.name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product')
                    ->relationship('product', 'name'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductImages::route('/'),
            'create' => Pages\CreateProductImage::route('/create'),
            'edit' => Pages\EditProductImage::route('/{record}/edit'),
        ];
    }
}
