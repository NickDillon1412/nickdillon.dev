<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

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
