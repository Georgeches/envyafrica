<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerResource\RelationManagers;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'firstname';

    public static function getGlobalySearchableAttributes(): array{
        return ['firstname', 'secondname', 'email'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array{
        return [
            'email' => $record->email
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make(['Customer Information'])
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('firstname')
                                    ->label('First name')
                                    ->required(),
                                Forms\Components\TextInput::make('secondname')
                                    ->label('Second name')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->label('Email Address')
                                    ->unique(ignoreRecord: true)
                                    ->email()
                                    ->live(),
                                Forms\Components\TextInput::make('phone')
                                    ->required()
                                    ->label('Phone number'),
                            ])
                    ]),
                Forms\Components\Group::make(['Location'])
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('address')
                                    ->required()
                                    ->label('Address')
                                    ->helperText('Address line 1, Address line 2'),
                                Forms\Components\TextInput::make('city')
                                    ->label('City'),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('firstname')
                    ->label('First name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('secondname')
                    ->label('Last name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone'),
                Tables\Columns\TextColumn::make('address')
                    ->label('Address'),
                Tables\Columns\TextColumn::make('city')
                    ->searchable()
                    ->label('City'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
