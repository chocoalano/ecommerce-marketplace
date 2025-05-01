<?php
namespace App\Repositories\Patterns;

use App\Models\Order;
use App\Repositories\Interfaces\OrderPatternInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderPatternInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function filament_table()
    {
        return auth()->user()->type === 'admin'
            ? $this->model->query()
            : $this->filterOrdersByAuthUser($this->model->query());
    }

    public function all()
    {
        return $this->filterOrdersByAuthUser($this->model->query())->get();
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $order = $this->model->create($this->extractOrderData($data));
            $this->syncPayment($order, $data);
            $this->syncShipping($order, $data);
            $this->syncItems($order, $data['items']);

            return $order;
        });
    }

    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $order = $this->model->findOrFail($id);
            $order->update($this->extractOrderData($data));
            $this->syncPayment($order, $data);
            $this->syncShipping($order, $data);
            $this->syncItems($order, $data['items']);

            return $order;
        });
    }

    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->delete();
    }

    public function find($id)
    {
        return $this->model->with(['payment', 'shipping', 'item'])->findOrFail($id)->toArray();
    }

    private function filterOrdersByAuthUser($query)
    {
        return $query->whereHas('item.products.seller.user', function (Builder $userQuery) {
            $userQuery->where('id', auth()->id());
        });
    }

    private function extractOrderData(array $data)
    {
        return collect($data)->only([
            'buyer_id',
            'payment_id',
            'total_price',
            'status',
        ])->toArray();
    }

    private function syncPayment(Order $order, array $data)
    {
        $order->payment()->updateOrCreate(
            ['id' => $order->payment_id],
            collect($data)->only([
                'payment_method',
                'payment_status',
                'payment_date',
                'amount_paid',
            ])->toArray()
        );
    }

    private function syncShipping(Order $order, array $data)
    {
        $order->shipping()->updateOrCreate(
            ['order_id' => $order->id],
            collect($data)->only([
                'shipping_address',
                'shipping_status',
                'shipping_date',
                'tracking_number',
            ])->toArray()
        );
    }

    private function syncItems(Order $order, array $items)
    {
        foreach ($items as $itemData) {
            $order->item()->updateOrCreate(
                ['order_id' => $order->id, 'product_id' => $itemData['product_id']],
                collect($itemData)->only(['qty', 'item_price', 'total_price'])->toArray()
            );
        }
    }
    /**
     * @inheritDoc
     */
    public function chart(string $filter)
    {
        $query = Order::query();
        $labels = [];

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
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
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
}
