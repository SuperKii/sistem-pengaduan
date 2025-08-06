<?php

namespace App\Livewire;

use App\Models\Keluhan;
use App\Models\Komentar;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KeluhanDetailLivewire extends Component
{
    public $keluhans, $komentars, $deskripsi;

    public function logActivity($aksi, $tipe_aksi, $aksi_id, $deskripsi)
    {
        LogAktivitas::create([
            'admin_id' => Auth::user()->id,
            'aksi' => $aksi,
            'tipe_aksi' => $tipe_aksi,
            'aksi_id' => $aksi_id,
            'deskripsi' => $deskripsi,
        ]);
    }
    
    public function mount($id)
    {
        $this->keluhans = Keluhan::with(['kategori', 'petugas', 'penghuni'])->where('id', $id)->first();
        $this->getKomentar($id);
    }

    public function getKomentar($id)
    {
        $this->komentars = Komentar::with('admin')->where('keluhan_id', $id)->get();
    }


    // Komentar Add
    public function store($id)
    {
        $this->validate([
            'deskripsi' => 'required',
        ]);

        $store = Komentar::create([
            'deskripsi' => $this->deskripsi,
            'admin_id' => Auth::user()->id,
            'keluhan_id' => $id,
        ]);

        if ($store) {
            session()->flash('success', 'behasil menambahkan komentar');
            $this->getKomentar($id);
            $this->deskripsi = '';

            $this->logActivity('Komentar', 'Create', $id, 'Menambah Komentar');
        } else {
            session()->flash('error', 'gagal menambahkan komentar');
        }
    }

    // Komentar Delete
    public function delete($id_komentar,$id_keluhan)
    {
        $delete = Komentar::where('id', $id_komentar)->delete();

        if ($delete) {
            session()->flash('success', 'behasil menghapus komentar');
            $this->getKomentar($id_keluhan);
            $this->deskripsi = '';

            $this->logActivity('Komentar', 'Delete', $id_keluhan, 'Menghapus Komentar');
        } else {
            session()->flash('error', 'gagal menghapus komentar');
        }
    }

    public function render()
    {
        return view('livewire.page.admin.keluhan-detail')->layout('livewire.layouts.app');
    }
}
