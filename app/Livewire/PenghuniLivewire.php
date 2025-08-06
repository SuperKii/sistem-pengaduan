<?php

namespace App\Livewire;

use App\Models\LogAktivitas;
use App\Models\Penghuni;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class PenghuniLivewire extends Component
{
    use WithFileUploads;
    public $penghunis, $showModal = false, $mode = 'create';
    public $nama, $email, $password, $no_hp, $alamat_unit, $foto, $penghuni_id;

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
        $this->getPenghuni();
    }

    public function getPenghuni()
    {
        $this->penghunis = Penghuni::all();
    }

    public function openModal($mode, $id = null)
    {
        $this->mode = $mode;

        if ($mode == 'create') {
            $this->showModal = true;
        } else if ($mode == 'edit' && $id) {
            $this->showModal = true;
            $penghuni = Penghuni::findOrFail($id);
            $this->penghuni_id = $penghuni->id;
            $this->nama = $penghuni->nama;
            $this->email = $penghuni->email;
            $this->no_hp = $penghuni->no_hp;
            $this->alamat_unit = $penghuni->alamat_unit;
            $this->foto = $penghuni->foto;
        } else if ($mode == 'show' && $id) {
            $this->showModal = true;
            $penghuni = Penghuni::findOrFail($id);
            $this->penghuni_id = $penghuni->id;
            $this->nama = $penghuni->nama;
            $this->email = $penghuni->email;
            $this->no_hp = $penghuni->no_hp;
            $this->alamat_unit = $penghuni->alamat_unit;
            $this->foto = $penghuni->foto;
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
        $this->no_hp = '';
        $this->alamat_unit = '';
        $this->foto = '';
        $this->penghuni_id = '';
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'no_hp' => 'required',
            'alamat_unit' => 'required',
            'foto' => 'required',
        ]);
        $path = '';
        $nama_foto = $this->nama . '-' . $this->foto->getClientOriginalName();
        $path = $this->foto->storeAs('foto_penghuni', $nama_foto, 'public');

        $store = Penghuni::create([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'no_hp' => $this->no_hp,
            'alamat_unit' => $this->alamat_unit,
            'foto' => $path,
        ]);

        if ($store) {
            session()->flash('success', 'Berhasil menambah penghuni');
            $this->getPenghuni();
            $this->closeModal();

            $this->logActivity('Penghuni', 'Create', $store->id, 'Menambah Penghuni');
        } else {
            session()->flash('error', 'Gagal menambah penghuni');
            $this->closeModal();
        }
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'alamat_unit' => 'required',
            'foto' => 'required',
        ]);

        $update = Penghuni::findOrFail($this->penghuni_id);
        $path = $update->foto;
        if ($this->foto != $update->foto) {
            Storage::disk('public')->delete($path);
            $nama_foto = $this->nama . '-' . $this->foto->getClientOriginalName();
            $path = $this->foto->storeAs('foto_penghuni', $nama_foto, 'public');
        }
        $password = $update->password;
        if ($this->password != '' || $this->password != null) {
            $password = $this->password;
        }
        $update->update([
            'nama' => $this->nama,
            'email' => $this->email,
            'password' => bcrypt($password),
            'no_hp' => $this->no_hp,
            'alamat_unit' => $this->alamat_unit,
            'foto' => $path,
        ]);

        if ($update) {
            session()->flash('success', 'Berhasil mengubah penghuni');
            $this->getPenghuni();
            $this->closeModal();

            $this->logActivity('Penghuni', 'Update', $update->id, 'Mengubah Penghuni');
        } else {
            session()->flash('error', 'Gagal mengubah penghuni');
            $this->closeModal();
        }
    }

    public function delete($id)
    {
        $delete = Penghuni::findOrFail($id);
        Storage::disk('public')->delete($delete->foto);
        $delete->delete();

        if ($delete) {
            session()->flash('success', 'Berhasil menghapus penghuni');
            $this->getPenghuni();

            $this->logActivity('Penghuni', 'Delete', $id, 'Menghapus Penghuni');
        } else {
            session()->flash('error', 'Gagal menghapus penghuni');
        }
    }
    public function render()
    {
        return view('livewire.page.admin.penghuni')->layout('livewire.layouts.app');
    }
}
