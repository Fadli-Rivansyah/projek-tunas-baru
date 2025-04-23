<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Pakan;
use Livewire\Attributes\Title;

class PakanMain extends Component
{
    public $search = '';

    public function getSearchPakanProperty()
    {
        return Pakan::when($this->search, function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%');
        })->get();
    }

    public function destroy($id)
    {
        $telur= Pakan::findOrFail($id);
        $telur->delete();

        return redirect()->route('pakan')->with('success', 'Data pakan berhasil dihapus.');
    }

    #[Title('Pakan')] 
    public function render()
    {
        return view('livewire.pages.pakan-main')->layout('layouts.app');
    }
}
