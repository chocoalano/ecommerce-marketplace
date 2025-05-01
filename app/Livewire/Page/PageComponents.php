<?php

namespace App\Livewire\Page;

use App\Models\Page;
use Livewire\Component;

class PageComponents extends Component
{
    public string $pagename;
    public ?Page $data = null; // Pastikan $data bisa null untuk menghindari error

    public function mount(string $pagename): void
    {
        $this->pagename = $pagename;
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->data = Page::where('pagename', $this->pagename)->first();
    }

    public function render()
    {
        return view('livewire.page.page-components', [
            'data' => $this->data // Kirim data ke view sebagai parameter
        ])->layout('layouts.app');
    }
}
