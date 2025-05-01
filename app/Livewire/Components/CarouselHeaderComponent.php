<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CarouselHeaderComponent extends Component
{
    public array $images = [];

    public function mount()
    {
        $this->images = [
            asset('img_apps/carousel-1.jpg'),
            asset('img_apps/carousel-2.jpg'),
            asset('img_apps/carousel-3.jpg'),
        ];
    }

    public int $currentIndex = 0;

    public function next()
    {
        $this->currentIndex = ($this->currentIndex + 1) % count($this->images);
    }

    public function prev()
    {
        $this->currentIndex = ($this->currentIndex - 1 + count($this->images)) % count($this->images);
    }
    public function render()
    {
        return view('livewire.components.carousel-header-component');
    }
}
