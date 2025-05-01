<?php

namespace App\Livewire\Components;

use Livewire\Component;

class NavbarComponent extends Component
{
    public $searchTerm = '';
    public function updatedSearchTerm($value)

    {
        dd($value);
    }
    public function render()
    {
        return view('livewire.components.navbar-component');
    }
}
