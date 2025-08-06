<?php

namespace App\Livewire;

use App\Models\Keluhan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardLivewire extends Component
{
    public $chartData, $userKeluhan, $newKeluhan;
    public function mount()
    {
        $this->chartData = Keluhan::select('kategori_id', DB::raw('count(*) as total'))
            ->groupBy('kategori_id')
            ->with('kategori')
            ->get()
            ->map(fn($item) => [
                'label' => $item->kategori->nama_kategori,
                'total' => $item->total,
            ]);

        $this->userKeluhan = Keluhan::select('penghuni_id', DB::raw('count(*) as total'))
            ->groupBy('penghuni_id')
            ->with('penghuni')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $this->newKeluhan = Keluhan::with(['penghuni', 'kategori'])
            ->latest()
            ->take(10)
            ->get();
        if (Auth::guard('penghuni')->check()) {
            $this->newKeluhan = Keluhan::with(['penghuni', 'kategori'])->where('penghuni_id', Auth::guard('penghuni')->user()->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // dd($this->chartData);
    }
    public function render()
    {
        return view('livewire.page.admin.dashboard')->layout('livewire.layouts.app');
    }
}
