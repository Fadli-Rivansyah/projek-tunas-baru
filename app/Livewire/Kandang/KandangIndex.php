<?php

namespace App\Livewire\Kandang;

use Livewire\Component;

class KandangIndex extends Component
{
    public function render()
    {
        return view('livewire.kandang.kandang-index')->layout('components.layouts.app');
    }
}
