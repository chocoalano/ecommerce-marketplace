<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentInterface;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class PaymentChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Payment';
    protected static ?string $description = 'An overview of some analytics.';

    // Filter selection, default to 'today'
    public ?string $filter = 'today';

    /**
     * Get available filters.
     *
     * @return array
     */
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    /**
     * Get chart data based on the selected filter.
     *
     * @return array
     */
    protected function getData(): array
    {
        $data = $this->fetchFilteredData($this->filter);

        return [
            'datasets' => [
                [
                    'label' => 'Total Payments Pending',
                    'data' => $data['pending'],
                    'backgroundColor' => '#FCC737',
                    'borderColor' => '#FCC737',
                ],
                [
                    'label' => 'Total Payments Success',
                    'data' => $data['success'],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
                [
                    'label' => 'Total Payments Failed',
                    'data' => $data['failed'],
                    'backgroundColor' => '#FA4032',
                    'borderColor' => '#FA4032',
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    /**
     * Fetch data based on the selected filter.
     *
     * @param string|null $filter
     * @return array
     */
    private function fetchFilteredData(?string $filter): array
    {
        $proses = App::make(PaymentInterface::class);
        return $proses->chart($filter);
    }

    /**
     * Define the type of chart.
     *
     * @return string
     */
    protected function getType(): string
    {
        return 'bar';
    }
}
