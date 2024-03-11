<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected function getStats(): array

    {
        $currentMonth = Carbon::now()->month;
        $completedMonthOrders = Order::whereMonth('created_at', '=', $currentMonth)
            ->where('status', '=', 'completed');
        return [
            Stat::make('Total Customers', Customer::count()),
            Stat::make('Products In Stock', Product::sum('quantity')),
            Stat::make('Pending Orders', Order::where('status', 'like', 'pending')->count()),
            Stat::make('Processing Orders', Order::where('status', 'like', 'processing')->count()),
            Stat::make('Orders completed this month', $completedMonthOrders->count()),
        ];
    }
}
