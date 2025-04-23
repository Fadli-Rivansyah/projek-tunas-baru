<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class DashboardAdmin extends Component
{
    public function render()
    {
        return view('livewire.pages.dashboard-admin')->layout('layouts.app');
    }
}
