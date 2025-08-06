<?php

namespace App\Livewire;

use App\Helpers\Telegram;
use App\Models\Kategori;
use App\Models\Keluhan;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateKeluhanPenghuniLivewire extends Component
{
    use WithFileUploads;
    public $keluhans, $kategori, $petugas, $showModal = false, $showPetugas = false, $mode = 'create';
    public $deskripsi, $penghuni_id, $kategori_id, $petugas_id, $status = "pending", $proses_at, $selesai_at, $foto_keluhan, $foto_selfie, $keluhan_id;

    public function logActivity($aksi, $tipe_aksi, $aksi_id, $deskripsi)
    {
        LogAktivitas::create([
            'penghuni_id' => Auth::guard('penghuni')->user()->id,
            'aksi' => $aksi,
            'tipe_aksi' => $tipe_aksi,
            'aksi_id' => $aksi_id,
            'deskripsi' => $deskripsi,
        ]);
    }

    public function mount()
    {
        $this->kategori = Kategori::all();
    }
    
    public function resetForm()
    {
        $this->deskripsi = '';
        $this->kategori_id = '';
        $this->petugas_id = '';
        $this->penghuni_id = '';
        $this->foto_keluhan = '';
        $this->foto_selfie = '';
        $this->status = '';
        $this->selesai_at = '';
        $this->proses_at = '';
        $this->keluhan_id = '';
    }

    public function store()
    {
        $this->validate([
            'deskripsi' => 'required',
            'kategori_id' => 'required',
            'foto_keluhan' => 'required',
            'foto_selfie' => 'required',
        ]);

        // foto keluhan
        $path_keluhan = '';
        $nama_foto = 'keluhan' . '-' . $this->foto_keluhan->getClientOriginalName();
        $path_keluhan = $this->foto_keluhan->storeAs('foto_keluhan', $nama_foto, 'public');

        // foto selfie
        $path_selfie = '';
        $nama_foto = 'penghuni' . '-' . $this->foto_selfie->getClientOriginalName();
        $path_selfie = $this->foto_selfie->storeAs('foto_selfie', $nama_foto, 'public');

        $store = Keluhan::create([
            'deskripsi' => $this->deskripsi,
            'penghuni_id' => Auth::guard('penghuni')->user()->id,
            'kategori_id' => $this->kategori_id,
            'foto_keluhan' => $path_keluhan,
            'foto_selfie' => $path_selfie,
            'status' => 'pending',
        ]);

        if ($store) {
            // set to id
            Carbon::setLocale('id');
            $pesan = "📢 <b>Keluhan Baru Masuk</b>\n\n"
                . "👤 <b>Nama Penghuni</b> : {$store->penghuni->nama}\n"
                . "🏠 <b>Alamat</b> : {$store->penghuni->alamat_unit}\n"
                . "📁 <b>Kategori</b> : {$store->kategori->nama_kategori}\n"
                . "🖊️ <b>Deskripsi</b> : {$store->deskripsi}\n"
                . "🕒 <b>Waktu</b> : " . Carbon::now()->format('d-m-Y H:i');

            Telegram::sendMessage(config('services.telegram.chat_id'), $pesan);
            return redirect()->route('keluhanPenghuni')->with('success','Berhasil Menambah Keluhan');
            $this->logActivity('Keluhan', 'Create', $store->id, 'Menambah Keluhan');
        } else {
            return redirect()->route('keluhanPenghuni')->with('error','Gagal Menambah Keluhan');
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.page.user.tambah_keluhan')->layout('livewire.layouts.app');
    }
}
