<?php

namespace App\Livewire\Components;

use App\Models\Category;
use Livewire\Component;

class CarouselCategoryComponent extends Component
{
    public $items = [];
    public $currentIndex = 0;

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $categories = Category::where("status", "active")->get();
        $this->items = $categories->map(function ($category) {
            return [
                'name' => $category->name
            ];
        })->toArray();
    }

    public function next()
    {
        $this->currentIndex = ($this->currentIndex + 1) % (count($this->items) / 5);
        $this->loadItems(); // Reload items with sequential colors when moving to the next
    }

    public function prev()
    {
        $this->currentIndex = ($this->currentIndex - 1 + (count($this->items) / 5)) % (count($this->items) / 5);
        $this->loadItems(); // Reload items with sequential colors when moving to the previous
    }

    public function render()
    {
        return view('livewire.components.carousel-category-component');
    }
}
