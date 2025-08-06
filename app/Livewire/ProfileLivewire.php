<?php

namespace App\Livewire;

use Livewire\Component;

class ProfileLivewire extends Component
{
    public function render()
    {
        return view('livewire.page.user.profile')->layout('livewire.layouts.app');
    }
}
