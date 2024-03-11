<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Product;
use Filament\Widgets\ChartWidget;

class ProductChart extends ChartWidget
{
    protected static ?string $heading = 'Stocks bought per month';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = $this->getProductsPerMonth();
        return [
            'datasets' => [
                [
                    'label' => 'Stock Bought',
                    'data' => $data['productsPerMonth']
                ]
                ],
                'labels' => $data['months']
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    private function getProductsPerMonth(): array{
        $productsPerMonth = [];
        $months = range(1, 12);
        for($i=1; $i<=count($months); $i++){
            $productCount = Product::whereMonth('created_at', '=', $i)->count();
            $productsPerMonth[] = $productCount;
        }

        return [
            'productsPerMonth' => $productsPerMonth,
            'months' => array_map(function($monthIndex){
                if($monthIndex == 6 || $monthIndex == 7){
                    return substr(Carbon::create()->month($monthIndex)->monthName, 0, 4);
                }
                return substr(Carbon::create()->month($monthIndex)->monthName, 0, 3);
            }, $months)
        ];
    }
}
