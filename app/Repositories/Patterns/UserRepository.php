<?php
namespace App\Repositories\Patterns;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserInterface
{
    protected $model;

    public function __construct(User $model)
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
        $model = $this->model->create($data);
        if ($model->type === 'seller') {
            $this->updateSellerData($model, $data);
        }

        return $model;
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
        return $this->model->query();
    }

    /**
     * @inheritDoc
     */
    public function find($id)
    {
        return $this->model->with('seller')->find($id);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $model = $this->model->findOrFail($id);
        if ($model->type === 'seller') {
            $this->updateSellerData($model, $data);
        }
        $model->update($data);

        return $model;
    }

    /**
     * Perbarui atau buat data seller terkait.
     *
     * @param Model $model
     * @param array $data
     */
    private function updateSellerData(Model $model, array $data)
    {
        $sellerData = [
            'store_name' => $data['store_name'] ?? $model->seller->store_name,
            'description' => $data['description'] ?? $model->seller->description,
            'logo' => $data['logo'] ?? $model->profile_picture,
            'store_address' => $data['store_address'] ?? $model->seller->store_address,
        ];
        $model->seller()->updateOrCreate(['user_id' => $model->id], $sellerData);
    }

}
