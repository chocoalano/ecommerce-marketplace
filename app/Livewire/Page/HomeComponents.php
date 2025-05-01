<?php

namespace App\Livewire\Page;

use Livewire\Component;

class HomeComponents extends Component
{
    public function render()
    {
        return view('livewire.page.home-components')->layout('layouts.app');
    }
}
