<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KategoriLivewire extends Component
{
    public $kategoris, $showModal = false, $mode = 'create';
    public $nama_kategori, $kategori_id;

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
    public function mount()
    {
        $this->getKategori();
    }

    public function getKategori()
    {
        $this->kategoris = Kategori::all();
    }

    public function openModal($mode, $id = null)
    {
        $this->mode = $mode;

        if ($mode == 'create') {
            $this->showModal = true;
        } else if ($mode == 'edit' && $id) {
            $this->showModal = true;
            $kategori = Kategori::findOrFail($id);
            $this->kategori_id = $kategori->id;
            $this->nama_kategori = $kategori->nama_kategori;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->dispatch('reinitDatatable');
    }

    public function resetForm()
    {
        $this->nama_kategori = '';
        $this->kategori_id = '';
    }

    public function store()
    {
        $this->validate([
            'nama_kategori' => 'required'
        ]);

        $store = Kategori::create([
            'nama_kategori' => $this->nama_kategori
        ]);

        if ($store) {
            session()->flash('success', 'Berhasil menambah kategori');
            $this->getKategori();
            $this->closeModal();

            $this->logActivity('Kategori', 'Create', $store->id, 'Menambah Kategori');
        } else {
            session()->flash('error', 'Gagal menambah kategori');
            $this->closeModal();
        }
    }

    public function update()
    {
        $this->validate([
            'nama_kategori' => 'required'
        ]);

        $update = Kategori::findOrFail($this->kategori_id);
        $update->update([
            'nama_kategori' => $this->nama_kategori
        ]);

        if ($update) {
            session()->flash('success', 'Berhasil mengubah kategori');
            $this->getKategori();
            $this->closeModal();

            $this->logActivity('Kategori', 'Update', $this->kategori_id, 'mengubah Kategori');
        } else {
            session()->flash('error', 'Gagal mengubah kategori');
            $this->closeModal();
        }
    }

    public function delete($id)
    {
        $delete = Kategori::findOrFail($id);
        $delete->delete();

        if ($delete) {
            session()->flash('success', 'Berhasil menghapus kategori');
            $this->getKategori();

            $this->logActivity('Kategori', 'Delete', $id, 'Menghapus Kategori');
        } else {
            session()->flash('error', 'Gagal menghapus kategori');
        }
    }
    public function render()
    {
        return view('livewire.page.admin.kategori')->layout('livewire.layouts.app');
    }
}
