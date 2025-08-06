<?php

namespace App\Livewire;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PetugasLivewire extends Component
{
    public $petugas, $kategoris, $showModal = false, $mode = 'create';
    public $nama, $email, $password, $kategori_id, $petugas_id;

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
        $this->getPetugas();
    }

    public function getPetugas()
    {
        $this->petugas = Petugas::all();
    }

    public function openModal($mode, $id = null)
    {
        $this->mode = $mode;

        if ($mode == 'create') {
            $this->showModal = true;
            $this->kategoris = Kategori::all();
        } else if ($mode == 'edit' && $id) {
            $this->showModal = true;
            $this->kategoris = Kategori::all();
            $petugas = Petugas::findOrFail($id);
            $this->nama = $petugas->nama;
            $this->email = $petugas->email;
            $this->kategori_id = $petugas->kategori_id;
            $this->petugas_id = $petugas->id;
        } else if ($mode == 'show' && $id) {
            $this->showModal = true;
            $this->kategoris = Kategori::all();
            $petugas = Petugas::findOrFail($id);
            $this->nama = $petugas->nama;
            $this->email = $petugas->email;
            $this->kategori_id = $petugas->kategori_id;
            $this->petugas_id = $petugas->id;
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
        $this->nama = '';
        $this->email = '';
        $this->password = '';
        $this->kategori_id = '';
        $this->petugas_id = '';
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'kategori_id' => 'required',
        ]);

        $store = Petugas::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'kategori_id' => $this->kategori_id
        ]);

        if ($store) {
            session()->flash('success', 'Berhasil menambah petugas');
            $this->getPetugas();
            $this->closeModal();

            $this->logActivity('Petugas', 'Create', $store->id, 'Menambah Petugas');
        } else {
            session()->flash('error', 'Gagal menambah petugas');
            $this->closeModal();
        }
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required',
            'kategori_id' => 'required',
        ]);

        $update = Petugas::findOrFail($this->petugas_id);
        $password = $update->password;
        if ($this->password != '' || $this->password != null) {
            $password = $this->password;
        }
        $update->update([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => bcrypt($password),
            'kategori_id' => $this->kategori_id
        ]);

        if ($update) {
            session()->flash('success', 'Berhasil mengubah petugas');
            $this->getPetugas();
            $this->closeModal();

            $this->logActivity('Petugas', 'Update', $update->id, 'Mengubah Petugas');
        } else {
            session()->flash('error', 'Gagal mengubah petugas');
            $this->closeModal();
        }
    }

    public function delete($id)
    {
        $delete = Petugas::findOrFail($id);
        $delete->delete();

        if ($delete) {
            session()->flash('success', 'Berhasil menghapus petugas');
            $this->getPetugas();

            $this->logActivity('Petugas', 'Delete', $id, 'Menghapus Petugas');
        } else {
            session()->flash('error', 'Gagal menghapus petugas');
        }
    }
    public function render()
    {
        return view('livewire.page.admin.petugas')->layout('livewire.layouts.app');
    }
}
