<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

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
        $startDate = null;
        $endDate = null;
        $labels = [];

        // Determine date range based on filter
        switch ($filter) {
            case 'today':
                $startDate = Carbon::today();
                $endDate = Carbon::today();
                $labels = [$startDate->format('Y-m-d')];
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                $labels = $this->generateDateLabels($startDate, $endDate);
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $labels = $this->generateDateLabels($startDate, $endDate);
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                $labels = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];
                break;
            default:
                $labels = ['No Data'];
                break;
        }

        if (!$startDate || !$endDate) {
            return ['labels' => $labels, 'pending' => [], 'success' => [], 'failed' => []];
        }

        // Query to fetch grouped data
        $groupedData = Payment::selectRaw('COUNT(*) as total, DATE(payment_date) as date, payment_status')
            ->where('payment_date', '>=', $startDate)
            ->where('payment_date', '<=', $endDate)
            ->groupByRaw('DATE(payment_date), payment_status')
            ->get()
            ->groupBy('payment_status');

        // Initialize datasets
        $pending = array_fill(0, count($labels), 0);
        $success = array_fill(0, count($labels), 0);
        $failed = array_fill(0, count($labels), 0);

        // Map the grouped data to the correct dataset
        foreach ($groupedData as $status => $data) {
            foreach ($data as $entry) {
                $date = $entry->date;
                $total = $entry->total;

                // Ensure the date exists in the labels
                $labelIndex = array_search($date, $labels);
                if ($labelIndex !== false) {
                    // Assign total counts to the respective status
                    switch ($status) {
                        case 'pending':
                            $pending[$labelIndex] = $total;
                            break;
                        case 'success':
                            $success[$labelIndex] = $total;
                            break;
                        case 'failed':
                            $failed[$labelIndex] = $total;
                            break;
                    }
                }
            }
        }

        return [
            'labels' => $labels,
            'pending' => $pending,
            'success' => $success,
            'failed' => $failed,
        ];
    }

    /**
     * Generate labels for a date range.
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    private function generateDateLabels(Carbon $startDate, Carbon $endDate): array
    {
        $labels = [];
        $currentDate = $startDate->copy();

        while ($currentDate->lte($endDate)) {
            $labels[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        return $labels;
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
