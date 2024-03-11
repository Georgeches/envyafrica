<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Orders per month';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = $this->getOrdersPerMonth();
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data['ordersPerMonth']
                ]
                ],
                'labels' => $data['months']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getOrdersPerMonth(): array{
        $ordersPerMonth = [];
        $months = range(1, 12);
        for($i=1; $i<=count($months); $i++){
            $orderCount = Order::whereMonth('created_at', '=', $i)->count();
            $ordersPerMonth[] = $orderCount;
        }

        return [
            'ordersPerMonth' => $ordersPerMonth,
            'months' => array_map(function($monthIndex){
                if($monthIndex == 6 || $monthIndex == 7){
                    return substr(Carbon::create()->month($monthIndex)->monthName, 0, 4);
                }
                return substr(Carbon::create()->month($monthIndex)->monthName, 0, 3);
            }, $months)
        ];
    }
}
