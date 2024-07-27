<?php

declare(strict_types=1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AlertPopup extends Component
{
    public array $alerts = [];

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
