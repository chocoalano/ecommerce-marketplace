<?php

namespace App\Repositories\Patterns;

use App\Models\Product;
use App\Repositories\Interfaces\ProductPatternInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductRepository implements ProductPatternInterface
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Get the query for the Filament table.
     *
     * @return Builder
     */
    public function filament_table()
    {
        return $this->getQueryByUserType();
    }

    /**
     * Get all records based on user type.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->getQueryByUserType()->get();
    }

    /**
     * Create a new product record.
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data)
    {
        $record = $this->model->create($data);

        // Handle images
        $this->syncImages($record, $data['image'] ?? []);

        return $record;
    }

    /**
     * Delete a product by ID, including its associated images.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        $record = $this->model->findOrFail($id);

        // Delete associated images from storage
        foreach ($record->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        // Delete the product record
        return $record->delete();
    }

    /**
     * Find a product by ID with its images.
     *
     * @param int $id
     * @return array
     */
    public function find($id)
    {
        $record = $this->model->with('images')->findOrFail($id);

        $data = $record->toArray();
        $data['images'] = $record->images->pluck('image')->toArray();

        return $data;
    }

    /**
     * Update a product by ID.
     *
     * @param int $id
     * @param array $data
     * @return Product
     */
    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);

        // Update product data
        $updateData = $this->prepareUpdateData($data);
        $record->update($updateData);

        // Sync images
        $this->syncImages($record, $data['image'] ?? []);

        return $record;
    }

    /**
     * Prepare update data with conditional fields.
     *
     * @param array $data
     * @return array
     */
    protected function prepareUpdateData(array $data): array
    {
        $updateData = [
            "seller_id" => $data['seller_id'],
            "category_id" => $data['category_id'],
            "name" => $data['name'],
            "slug" => $data['slug'],
            "description" => $data['description'],
            "price" => $data['price'],
            "stock" => $data['stock'],
            "status" => $data['status'],
        ];

        if (Auth::user()->type === 'admin') {
            $updateData['rating'] = $data['rating'];
        }

        return $updateData;
    }

    /**
     * Sync product images by detaching old ones and attaching new ones.
     *
     * @param Product $record
     * @param array $newImageIds
     * @return void
     */
    protected function syncImages(Product $record, array $newImageIds): void
    {
        $existingImageIds = $record->images->pluck('id')->toArray();

        // Detach images that are no longer associated
        $imagesToDetach = array_diff($existingImageIds, $newImageIds);
        if (!empty($imagesToDetach)) {
            $record->images()->whereIn('id', $imagesToDetach)->delete();
        }

        // Attach new images
        $imagesToAttach = array_diff($newImageIds, $existingImageIds);
        foreach ($imagesToAttach as $imageId) {
            $record->images()->create(['image' => $imageId]);
        }
    }

    /**
     * Get the query based on the user's type.
     *
     * @return Builder
     */
    protected function getQueryByUserType(): Builder
    {
        if (Auth::user()->type === 'seller') {
            return $this->model->whereHas('seller', function (Builder $sellerQuery) {
                $sellerQuery->where('user_id', Auth::id());
            });
        }

        return $this->model->query();
    }
}
