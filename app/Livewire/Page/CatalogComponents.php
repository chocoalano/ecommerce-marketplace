<?php

namespace App\Livewire\Page;

use Livewire\Component;

class CatalogComponents extends Component
{
    public $slug; // Menambahkan properti slug

    // Menggunakan mount untuk menangkap parameter slug dari route
    public function mount($slug)
    {
        $this->slug = $slug;  // Menyimpan nilai slug ke properti
    }
    public function render()
    {
        return view('livewire.page.catalog-components')->layout('layouts.app');
    }
}
