<?php

namespace App\Filament\Widgets;

use App\Models\Product;

use Illuminate\Support\Carbon;
use Filament\Widgets\ChartWidget;

class ProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = [
            'datasets' => [
                [
                    'label' => 'Products created',
                    'data' => $this->getProductsPerMonth(),
                ],
            ],
            'labels' => $this->getMonthLabels(),
        ];

        return $data;
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getProductsPerMonth(): array
    {
        $now = Carbon::now();
        $productsPerMonth = [];

        foreach (range(1, 12) as $month) {
            $count = Product::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $month)
                ->count();

            $productsPerMonth[] = $count;
        }

        return $productsPerMonth;
    }

    private function getMonthLabels(): array
    {
        $now = Carbon::now();
        $months = [];

        foreach (range(1, 12) as $month) {
            $months[] = $now->month($month)->format('M');
        }

        return $months;
    }



}
