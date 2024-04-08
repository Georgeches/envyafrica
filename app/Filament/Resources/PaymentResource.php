<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Enums\PaymentStatusEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 4;

    public static function getGlobbalySearchableAttributes(): array{
        return ['order.number', 'amount', 'phone', 'transaction_code'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array{
        return [
            'transaction_code' => $record->transaction_code
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make(['Payment Information'])
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('order_id')
                                    ->label('Order')
                                    ->options(
                                        Order::all()->pluck('number', 'id')->toArray()
                                    )
                                    ->afterStateUpdated(function(String $operation, $state, Forms\Set $set){
                                        $order = Order::find($state);
                                        if($order){
                                            $set('amount', $order->amount);
                                        }
                                    })
                                    ->live(onBlur: true),
                                Forms\Components\TextInput::make('amount')
                                    ->label('Amount'),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone number'),
                                Forms\Components\Select::make('status')
                                    ->label('Payment Status')
                                    ->options([
                                        'failed'=>'failed',
                                        'pending'=>'pending',
                                        'success'=>'success',
                                        'refunded'=>'refunded',
                                        'cancelled'=>'cancelled'
                                    ]),
                            ])
                    ]),
                Forms\Components\Group::make(['Mpesa Information'])
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('transaction_code')
                                    ->label('Transaction Code'),
                                Forms\Components\TextInput::make('merchant_request_id')
                                    ->label('Merchant Request ID'),
                                Forms\Components\TextInput::make('transaction_date')
                                    ->label('Transaction Date'),
                                Forms\Components\TextInput::make('transaction_time')
                                    ->label('Transaction Time'),
                                Forms\Components\TextInput::make('transaction_date_time')
                                    ->label('Transaction Code'),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_code')
                    ->label('Transaction code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('merchant_request_id')
                    ->label('Merchant Request ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.number')
                    ->label('Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone Number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Transaction code')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
