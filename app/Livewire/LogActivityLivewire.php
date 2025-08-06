<?php

namespace App\Livewire;

use App\Models\LogAktivitas;
use Livewire\Component;

class LogActivityLivewire extends Component
{
    public $logs;
    public function mount()
    {
        $this->logs = LogAktivitas::with(['admin','petugas','penghuni'])->get();
    }
    public function render()
    {
        return view('livewire.page.admin.log')->layout('livewire.layouts.app');
    }
}
