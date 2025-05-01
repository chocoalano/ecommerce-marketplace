<?php
namespace App\Repositories\Patterns;

use App\Models\Payment;
use App\Repositories\Interfaces\PaymentInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PaymentRepository implements PaymentInterface
{
    protected $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        if (auth()->user()->type === "seller") {
            $data['user_id'] = auth()->id();
            $data['transaction_at'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        return $this->model->create($data);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        $order = $this->model->findOrFail($id);
        return $order->delete();
    }

    /**
     * @inheritDoc
     */
    public function filament_table()
    {
        return auth()->user()->type === 'admin'
            ? $this->model->query()
            : $this->model->query()->whereHas('order', function (Builder $o) {
                $o->whereHas('item', function (Builder $i) {
                    $i->whereHas('products', function (Builder $p) {
                        $p->whereHas('seller', function (Builder $s) {
                            $s->whereHas('user', function (Builder $u) {
                                $u->where('id', auth()->id());
                            });
                        });
                    });
                });
            });
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $update = $this->model->findOrFail($id);
        $update->update($data);
        return $update;
    }
    /**
     * @inheritDoc
     */
    public function chart(string $filter)
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
