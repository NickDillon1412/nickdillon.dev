<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;

#[Layout('layouts.app')]
class TagTable extends Component
{
    public function render(): View
    {
        return view('livewire.pure-finance.tag-table');
    }
}
