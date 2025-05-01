<?php

namespace App\Filament\Admin\Widgets;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

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
        $query = Order::query();
        $labels = [];
        $pending = [];
        $paid = [];
        $shipped = [];
        $completed = [];
        $cancelled = [];

        // Determine the date range based on the selected filter
        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                $labels = [Carbon::now()->format('Y-m-d')];
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $labels = $this->generateDateLabels(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month);
                $labels = $this->generateDateLabels(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
                break;
            case 'year':
                $query->whereYear('created_at', Carbon::now()->year);
                $labels = [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];
                break;
            default:
                $labels = ['No Data'];
                break;
        }

        // Fetch grouped data by order status
        $groupedData = Order::selectRaw('COUNT(*) as total, DATE(created_at) as date, status')
            ->whereBetween('created_at', [Carbon::parse($labels[0])->startOfDay(), Carbon::parse(end($labels))->endOfDay()])
            ->groupBy('date', 'status')
            ->get()
            ->groupBy('status');

        // Initialize datasets with default values
        $statuses = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
        $data = array_fill_keys($statuses, array_fill(0, count($labels), 0));

        // Map the grouped data to the correct status arrays
        foreach ($groupedData as $status => $dataGroup) {
            foreach ($dataGroup as $entry) {
                $date = $entry->date;
                $total = $entry->total;

                // Find the index of the label matching the date
                $labelIndex = array_search($date, $labels);
                if ($labelIndex !== false) {
                    // Set the total for the corresponding status
                    if (in_array($status, $statuses)) {
                        $data[$status][$labelIndex] = $total;
                    }
                }
            }
        }

        return [
            'labels' => $labels,
            'pending' => $data['pending'],
            'paid' => $data['paid'],
            'shipped' => $data['shipped'],
            'completed' => $data['completed'],
            'cancelled' => $data['cancelled'],
        ];
    }

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

    protected function getType(): string
    {
        return 'line';
    }
}
