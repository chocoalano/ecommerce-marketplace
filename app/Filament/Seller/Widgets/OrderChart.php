<?php

namespace App\Filament\Seller\Widgets;
use App\Models\Order;
use App\Repositories\Interfaces\OrderPatternInterface;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class OrderChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Orders';
    protected static ?string $description = 'An overview of some analytics.';
    public ?string $filter = 'today';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        $data = $this->fetchFilteredData($this->filter);

        return [
            'datasets' => [
                [
                    'label' => 'Pending Orders',
                    'data' => $data['pending'],
                    'backgroundColor' => '#F26B0F',
                    'borderColor' => '#FCC737',
                ],
                [
                    'label' => 'Paid Orders',
                    'data' => $data['paid'],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
                [
                    'label' => 'Shipped Orders',
                    'data' => $data['shipped'],
                    'backgroundColor' => '#FA4032',
                    'borderColor' => '#FA4032',
                ],
                [
                    'label' => 'Completed Orders',
                    'data' => $data['completed'],
                    'backgroundColor' => '#4CAF50',
                    'borderColor' => '#81C784',
                ],
                [
                    'label' => 'Cancelled Orders',
                    'data' => $data['cancelled'],
                    'backgroundColor' => '#FF9800',
                    'borderColor' => '#FFB74D',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    private function fetchFilteredData(?string $filter): array
    {
        $proses = App::make(OrderPatternInterface::class);
        return $proses->chart($filter);
    }

    protected function getType(): string
    {
        return 'line';
    }
}
