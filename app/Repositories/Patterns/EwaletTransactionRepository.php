<?php
namespace App\Repositories\Patterns;

use App\Models\EwalletTransaction;
use App\Repositories\Interfaces\EwaletTransactionInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EwaletTransactionRepository implements EwaletTransactionInterface
{
    protected $model;

    public function __construct(EwalletTransaction $model)
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
            : $this->model->where('user_id', auth()->id());
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
}
