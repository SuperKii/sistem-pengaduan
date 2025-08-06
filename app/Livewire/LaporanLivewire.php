<?php

namespace App\Livewire;

use App\Mail\ReportMail;
use App\Models\Keluhan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class LaporanLivewire extends Component
{
    public $laporans = [], $tanggal_awal, $tanggal_akhir, $status;

    public function mount()
    {
        $this->getLaporan();
    }

    public function getLaporan()
    {
        $this->validate([
            'tanggal_awal' => 'required',
            'tanggal_akhir' => 'required',
        ]);

        if ($this->status != null && $this->status != '') {
            $this->dispatch('reinitDatatable');
            $this->laporans = Keluhan::with(['penghuni', 'kategori'])->whereBetween('created_at', [$this->tanggal_awal, $this->tanggal_akhir])->where('status', $this->status)->get();
        } else {
            $this->dispatch('reinitDatatable');
            $this->laporans = Keluhan::with(['penghuni', 'kategori'])->whereBetween('created_at', [$this->tanggal_awal, $this->tanggal_akhir])->get();
        }
    }

    public function generatePdf()
    {
        $data = $this->laporans;
        $periode = $this->tanggal_awal . " -> " . $this->tanggal_akhir;

        $pdf = Pdf::loadView('export', [
            'dataKeluhan' => $data,
            'periode' => $periode
        ])->output();

        // dd($pdf);
        Mail::to('rochmathidayahrizki@gmail.com')->send(new ReportMail($periode, $pdf, $data));
        session()->flash('success', 'Laporan berhasil dikirim ke email.');
        $this->dispatch('reinitDatatable');
    }

    public function render()
    {
        return view('livewire.page.admin.laporan')->layout('livewire.layouts.app');
    }
}
