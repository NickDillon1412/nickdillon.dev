<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use App\Data\MovieVault\VaultData;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Explore extends Component
{
    public string $search = '';

    public array $search_results = [];

    public array $new_media = [];

    #[Computed]
    public function searchResults(): array
    {
        return Http::withToken(config('services.movie-api.token'))
            ->get("https://api.themoviedb.org/3/search/multi?query={$this->search}&include_adult=false&language=en-US")
            ->json()['results'];
    }

    public function save(array $media, ?string $wishlist = null): void
    {
        if (
            auth()
                ->user()
                ->vaults()
                ->whereVaultId($media['id'])
                ->exists()
        ) {
            $this->dispatch('showAlertPopup', [
                'status' => 'danger',
                'message' => (string) new HtmlString(
                    '<strong>'
                    .($media['title'] ?? $media['name']).
                    '</strong> is already in your vault'
                ),
            ]);
        } else {
            $this->new_media = $media['media_type'] === 'movie'
                ? [
                    'title' => $media['title'],
                    'original_title' => $media['original_title'],
                    'release_date' => $media['release_date'],
                ]
                : [
                    'name' => $media['name'],
                    'original_name' => $media['original_name'],
                    'first_air_date' => $media['first_air_date'],
                ];

            $this->new_media['poster_path'] = $media['poster_path'] ?? $media['backdrop_path'] ?? null;
            $this->new_media['vault_id'] = $media['id'];
            $this->new_media['vault_type'] = $media['media_type'];
            $this->new_media['overview'] = $media['overview'];
            $this->new_media['on_wishlist'] = $wishlist ? true : false;

            auth()->user()->vaults()->create(
                VaultData::from($this->new_media)->toArray()
            );

            $this->dispatch('showAlertPopup', [
                'status' => 'success',
                'message' => $wishlist ? (string) new HtmlString(
                    '<p>Successfully added <strong>'
                    .($this->new_media['title'] ?? $this->new_media['name']).
                    '</strong> to your wishlist</p>'
                ) : 'Successfully added to your vault',
            ]);
        }
    }

    public function render(): View
    {
        return view('livewire.movie-vault.explore');
    }
}
