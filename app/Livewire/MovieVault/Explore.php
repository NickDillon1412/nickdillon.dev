<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Explore extends Component
{
    public string $search = '';

    public array $search_results = [];

    #[Computed]
    public function searchResults(): array
    {
        return Http::withToken(config('services.movie-api.token'))
            ->get("https://api.themoviedb.org/3/search/multi?query={$this->search}&include_adult=false&language=en-US")
            ->json()['results'];
    }

    public function render(): View
    {
        return view('livewire.movie-vault.explore');
    }
}
