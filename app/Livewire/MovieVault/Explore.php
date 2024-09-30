<?php

declare(strict_types=1);

namespace App\Livewire\MovieVault;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use GuzzleHttp\Promise\Promise;
use Livewire\Attributes\Layout;
use Illuminate\Http\Client\Pool;
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

    protected function extractRating(string $media_type, array $detail_response): string
    {
        if ($media_type === 'movie') {
            $releases = $detail_response['release_dates']['results'] ?? [];

            $us_releases = collect($releases)->firstWhere('iso_3166_1', 'US')['release_dates'] ?? [];

            return collect($us_releases)->pluck('certification')->filter()->first() ?? 'N/A';
        } else {
            $releases = $detail_response['content_ratings']['results'] ?? [];

            return collect($releases)->firstWhere('iso_3166_1', 'US')['rating'] ?? 'N/A';
        }
    }

    #[Computed]
    public function searchResults(): array
    {
        if (strlen($this->search) < 1) return [];

        $results = Http::withToken(config('services.movie-api.token'))
            ->get("https://api.themoviedb.org/3/search/multi?query={$this->search}&include_adult=false&language=en-US")
            ->json()['results'];

        $detail_requests = Http::pool(
            function (Pool $pool) use ($results): void {
                collect($results)->map(function (array $result) use ($pool): Promise {
                    $endpoint = $result['media_type'] === 'movie' ? 'movie' : 'tv';

                    $append_response = $result['media_type'] === 'movie' ? 'release_dates' : 'content_ratings';

                    return $pool->withToken(config('services.movie-api.token'))
                        ->get("https://api.themoviedb.org/3/{$endpoint}/{$result['id']}?append_to_response={$append_response},credits");
                })->toArray();
            }
        );

        return collect($results)->map(
            function (array $result, int $index) use ($detail_requests): array {
                $detail_response = $detail_requests[$index]->json();

                $result['rating'] = $this->extractRating($result['media_type'], $detail_response);

                if (isset($detail_response['genres'])) {
                    $result['genres'] = implode(',', collect($detail_response['genres'])->pluck('name')->toArray());
                }

                foreach (['runtime', 'number_of_seasons'] as $key) {
                    if (isset($detail_response[$key])) {
                        $result[$key] = $detail_response[$key];
                    }
                }

                if (isset($detail_response['credits']['cast'])) {
                    $result['actors'] = collect($detail_response['credits']['cast'])
                        ->pluck('name')
                        ->take(3)
                        ->implode(',');
                }

                return $result;
            }
        )->keyBy('id')->toArray();
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
                    'release_date' => $media['release_date'],
                ]
                : [
                    'first_air_date' => $media['first_air_date'],
                ];

            $this->new_media['title'] = $media['title'] ?? $media['name'];
            $this->new_media['original_title'] = $media['original_title'] ?? $media['original_name'];
            $this->new_media['poster_path'] = $media['poster_path'] ?? $media['backdrop_path'] ?? null;
            $this->new_media['vault_id'] = $media['id'];
            $this->new_media['vault_type'] = $media['media_type'];
            $this->new_media['overview'] = $media['overview'];
            $this->new_media['rating'] = $media['rating'];
            $this->new_media['genres'] = $media['genres'] ?: null;
            $this->new_media['runtime'] = $media['runtime'] ?? null;
            $this->new_media['seasons'] = $media['number_of_seasons'] ?? null;
            $this->new_media['actors'] = $media['actors'] ?? null;
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
