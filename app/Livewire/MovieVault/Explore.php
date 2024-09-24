<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Data\MovieVault\VaultData;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

#[Layout('layouts.app')]
class Explore extends Component
{
    public string $search = '';

    public array $search_results = [];

    public array $new_media = [];

    #[Computed]
    public function searchResults(): array
    {
        if (strlen($this->search) > 1) {
            $results = Http::withToken(config('services.movie-api.token'))
                ->get("https://api.themoviedb.org/3/search/multi?query={$this->search}&include_adult=false&language=en-US")
                ->json()['results'];

            $data = [];

            foreach ($results as $result) {
                if ($result['media_type'] === 'movie') {
                    $movie_response = Http::withToken(config('services.movie-api.token'))
                        ->get("https://api.themoviedb.org/3/movie/{$result['id']}", [
                            'append_to_response' => 'release_dates',
                        ]);

                    $releases = $movie_response->json()['release_dates']['results'] ?? [];

                    $us_releases = collect($releases)->firstWhere('iso_3166_1', 'US') ?? [];

                    $rating = '';

                    if (array_key_exists('release_dates', $us_releases)) {
                        foreach ($us_releases['release_dates'] as $us_release) {
                            if ($us_release['certification']) {
                                $rating = $us_release['certification'] ?? 'No rating found';
                            }
                        }
                    }

                    $result['rating'] = $rating;

                    $data[$result['id']] = $result;
                } elseif ($result['media_type'] === 'tv') {
                    $tv_response = Http::withToken(config('services.movie-api.token'))
                        ->get("https://api.themoviedb.org/3/tv/{$result['id']}", [
                            'append_to_response' => 'content_ratings',
                        ]);

                    $releases = $tv_response->json()['content_ratings']['results'] ?? [];

                    $us_release = collect($releases)->firstWhere('iso_3166_1', 'US');

                    $rating = $us_release['rating'] ?? 'No rating found';

                    $result['rating'] = $rating ?: 'N/A';

                    $data[$result['id']] = $result;
                }
            }

            return $data;
        } else {
            return [];
        }
    }

    public function save(array $media, ?string $wishlist = null): void
    {
        $user_vaults = auth()->user()->vaults();

        if ($in_vault = $user_vaults->whereVaultId($media['id'])->exists()) {
            $name = $media['title'] ?? $media['name'];

            $page = $in_vault ? 'vault' : 'wishlist';

            Toaster::error("{$name} is already in your {$page}");
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
            $this->new_media['rating'] = $media['rating'];
            $this->new_media['on_wishlist'] = $wishlist ? true : false;

            $user_vaults->create(
                VaultData::from($this->new_media)->toArray()
            );

            $media = $this->new_media['title'] ?? $this->new_media['name'];

            $page = $wishlist ? 'wishlist' : 'vault';

            Toaster::success("Successfully added {$media} to your {$page}");
        }
    }

    public function render(): View
    {
        return view('livewire.movie-vault.explore');
    }
}
