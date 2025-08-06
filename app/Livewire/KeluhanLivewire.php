<?php

namespace App\Livewire;

use App\Helpers\Telegram;
use App\Models\Kategori;
use App\Models\Keluhan;
use App\Models\LogAktivitas;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class KeluhanLivewire extends Component
{
    use WithFileUploads;
    public $keluhans, $kategori, $petugas, $showModal = false, $showPetugas = false, $mode = 'create';
    public $deskripsi, $penghuni_id, $kategori_id, $petugas_id, $status = "pending", $proses_at, $selesai_at, $foto_keluhan, $foto_selfie, $keluhan_id;

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
        $this->getKeluhan();
    }

    public function getKeluhan()
    {
        $this->keluhans = Keluhan::all();
    }

    public function openModal($mode, $id = null)
    {
        $this->mode = $mode;
        if ($mode == 'edit' && $id) {
            $this->showModal = true;
            $this->dispatch('editMode');
            $keluhan = Keluhan::findOrFail($id);
            $this->petugas = Petugas::where('kategori_id', $keluhan->kategori_id)->get();
            $this->keluhan_id = $keluhan->id;
            $this->status = $keluhan->status;
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('reinitDatatable');
    }

    public function update()
    {
        $this->validate([
            'status' => 'required'
        ]);

        // set to id
        Carbon::setLocale('id');
        $statusAwal = '';
        $update = '';
        $update = Keluhan::findOrFail($this->keluhan_id);
        $statusAwal = $update->status;
        switch ($this->status) {
            case 'proses':
                $update->update([
                    'petugas_id' => $this->petugas_id,
                    'status' => $this->status,
                    'proses_at' => Carbon::now()->toDateTimeString(),
                ]);
                break;

            case 'selesai':
                $update->update([
                    'status' => $this->status,
                    'selesai_at' => Carbon::now()->toDateTimeString(),
                ]);
                break;

            case 'ditolak':
                $update->update([
                    'status' => $this->status,
                ]);
                break;

            default:
                session()->flash('eror', 'Gagal mengubah keluhan');
                break;
        }

        if ($update || $update != '') {
            session()->flash('success', 'Berhasil mengubah keluhan');

            $pesan = "📢 <b>Data Keluhan Berubah</b>\n\n"
                . "👤 <b>Nama Penghuni</b> : {$update->penghuni->nama}\n"
                . "🏠 <b>Alamat</b> : {$update->penghuni->alamat_unit}\n"
                . "📁 <b>Kategori</b> : {$update->kategori->nama_kategori}\n"
                . "📝 <b>Deskripsi</b> : {$update->deskripsi}\n"
                . "🧑‍💼 <b>Admin</b> : " . Auth::user()->name . "\n";
            if ($this->status === 'proses') {
                $pesan .= "📤 <b>Pesan</b> : Menugaskan Petugas {$update->petugas->nama}\n";
            }
            $pesan .= "🔄 <b>Status</b> : {$statusAwal} -> {$this->status}\n"
                . "🕒 <b>Waktu</b> : " . Carbon::now()->format('d-m-Y H:i');


            Telegram::sendMessage(config('services.telegram.chat_id'), $pesan);
            $this->getKeluhan();
            $this->closeModal();

            $this->logActivity('Keluhan', 'Update', $update->id, 'Mengubah Keluhan');
        } else {
            session()->flash('error', 'Gagal mengubah keluhan');
            $this->closeModal();
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
            $this->getKeluhan();
            $this->dispatch('reinitDatatable');
            $this->logActivity('Keluhan', 'Delete', $id, 'Menghapus Keluhan');
        } else {
            $this->dispatch('reinitDatatable');
            session()->flash('error', 'Gagal menghapus keluhan');
        }
    }
    public function render()
    {
        return view('livewire.page.admin.keluhan')->layout('livewire.layouts.app');
    }
}
