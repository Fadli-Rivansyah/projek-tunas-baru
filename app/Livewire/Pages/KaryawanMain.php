<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Title;

class KaryawanMain extends Component
{
    public $search='';

    public function getSearchKaryawanProperty()
    {
        return User::with('kandang')
        ->where('is_admin', false)
        ->when($this->search, function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%');
        })
        ->paginate(10);
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();

        return redirect()->route('karyawan')->with('success', 'Data karyawan berhasil dihapus.');
    }


    #[Title('Karyawan')] 
    public function render()
    {
        return view('livewire.pages.karyawan-main')->layout('layouts.app');
    }
}
