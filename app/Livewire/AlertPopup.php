<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class AlertPopup extends Component
{
    public array $alerts = [];

    public function mount(): void
    {
        if (Session::has('alert')) {
            $this->alerts[] = Session::get('alert');
        }
    }

    #[On('showAlertPopup')]
    public function showAlertPopup(array $params): void
    {
        $this->alerts[] = $params;
    }

    public function render(): View
    {
        return view('livewire.alert-popup');
    }
}
