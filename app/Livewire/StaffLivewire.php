<?php

namespace App\Livewire;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StaffLivewire extends Component
{
    public $staffs, $showModal = false, $mode = 'create';
    public $name, $email, $password, $role, $staff_id;

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
        $this->getStaff();
    }

    public function getStaff()
    {
        $this->staffs = User::all();
    }

    public function openModal($mode, $id = null)
    {
        $this->mode = $mode;

        if ($mode == 'create') {
            $this->showModal = true;
        } else if ($mode == 'edit' && $id) {
            $this->showModal = true;
            $staff = User::findOrFail($id);
            $this->name = $staff->name;
            $this->email = $staff->email;
            $this->role = $staff->role;
            $this->staff_id = $staff->id;
        } else if ($mode == 'show' && $id) {
            $this->showModal = true;
            $staff = User::findOrFail($id);
            $this->name = $staff->name;
            $this->email = $staff->email;
            $this->role = $staff->role;
            $this->staff_id = $staff->id;
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
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->staff_id = '';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $store = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role' => $this->role
        ]);

        if ($store) {
            session()->flash('success', 'Berhasil menambah staff');
            $this->getStaff();
            $this->closeModal();

            $this->logActivity('Staff', 'Create', $store->id, 'Menambah Staff');
        } else {
            session()->flash('error', 'Gagal menambah staff');
            $this->closeModal();
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);

        $update = User::findOrFail($this->staff_id);
        $password = $update->password;
        if ($this->password != '' || $this->password != null) {
            $password = $this->password;
        }
        $update->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($password),
            'role' => $this->role
        ]);

        if ($update) {
            session()->flash('success', 'Berhasil mengubah staff');
            $this->getStaff();
            $this->closeModal();
            $this->logActivity('Staff', 'Update', $update->id, 'Mengubah Staff');
        } else {
            session()->flash('error', 'Gagal mengubah staff');
            $this->closeModal();
        }
    }

    public function delete($id)
    {
        $delete = User::findOrFail($id);
        $delete->delete();

        if ($delete) {
            session()->flash('success', 'Berhasil menghapus staff');
            $this->getStaff();

            $this->logActivity('Staff', 'Delete', $id, 'Menghapus Staff');
        } else {
            session()->flash('error', 'Gagal menghapus staff');
        }
    }
    public function render()
    {
        return view('livewire.page.admin.staff')->layout('livewire.layouts.app');
    }
}
