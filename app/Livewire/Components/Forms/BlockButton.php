<?php

namespace App\Livewire\Components\Forms;

use Livewire\Component;

class BlockButton extends Component
{
    public $type = 'submit'; // Tipe button (submit, button, dll)
    public $text = 'Masuk untuk memulai belanja'; // Teks untuk tombol
    public $color = 'green'; // Warna tombol (default: green)
    public $route = null; // Arahkan ke rute (jika diperlukan)

    public function mount($text = null, $type = 'submit', $color = 'green', $route = null)
    {
        // Set nilai dinamis jika diberikan
        if ($text) {
            $this->text = $text;
        }
        $this->type = $type;
        $this->color = $color;
        $this->route = $route;
    }
    public function render()
    {
        return view('livewire.components.forms.block-button');
    }
}
