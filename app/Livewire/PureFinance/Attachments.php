<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;

class Attachments extends Component
{
    public array $attachments = [];

    #[On('open-attachments')]
    public function loadAttachments(?array $attachments = null): void
    {
        if ($attachments) {
            $this->attachments = $attachments;
        }
    }

    public function render(): View
    {
        return view('livewire.pure-finance.attachments');
    }
}
