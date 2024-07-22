<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class MyVault extends Component
{
    public function render(): View
    {
        return view('livewire.movie-vault.my-vault');
    }
}
