<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class MyVault extends Component
{
    public function render(): View
    {
        // dd(Http::withToken(config('services.movie-api.token'))
        //     ->get('https://api.themoviedb.org/3/search/multi?query=toy story}&include_adult=false&language=en-US')
        //     ->json()['results']);

        return view('livewire.movie-vault.my-vault');
    }
}
