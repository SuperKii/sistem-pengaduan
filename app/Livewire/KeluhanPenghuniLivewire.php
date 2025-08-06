<?php

namespace App\Livewire;

use App\Models\Keluhan;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class KeluhanPenghuniLivewire extends Component
{
    public $keluhans, $status;

    public function mount()
    {
        $this->getKeluhan();
    }

    public function getKeluhan()
    {
        $this->keluhans = Keluhan::where('penghuni_id', Auth::guard('penghuni')->user()->id)->get();
        if ($this->status != null && $this->status != '') {
            $this->keluhans = Keluhan::with(['penghuni', 'kategori'])->where('status', $this->status)->where('penghuni_id', Auth::guard('penghuni')->user()->id)->get();
        }
    }

    public function delete($id)
    {
        $delete = Keluhan::findOrFail($id);
        Storage::disk('public')->delete($delete->foto_keluhan);
        Storage::disk('public')->delete($delete->foto_selfie);
        $delete->delete();

        if ($delete) {
            session()->flash('success', 'Berhasil menghapus keluhan');
            $this->dispatch('reinitDatatable');
            $this->logActivity('Keluhan', 'Delete', $id, 'Menghapus Keluhan');
        } else {
            $this->dispatch('reinitDatatable');
            session()->flash('error', 'Gagal menghapus keluhan');
        }
    }
    public function render()
    {
        return view('livewire.page.user.keluhan')->layout('livewire.layouts.app');
    }
}
