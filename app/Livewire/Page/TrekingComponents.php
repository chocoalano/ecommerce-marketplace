<?php

namespace App\Livewire\Page;

use App\Models\OrderItem;
use Livewire\Component;

class TrekingComponents extends Component
{
    public $id;
    public $orderItem;

    public function mount($id)
    {
        $this->id = $id;
        $this->load($this->id);
    }
    public function load($id)
    {
        $this->orderItem = OrderItem::with('order', 'products', 'shipping')->find($id);
    }
    public function render()
    {
        return view('livewire.page.treking-components')->layout('layouts.app');
    }
}
