<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MovieVault\Vault;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class VaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vaults = Vault::get();

        $responses = Http::pool(fn(Pool $pool) => $vaults->map(function (Vault $vault) use ($pool) {
            $endpoint = $vault['vault_type'] === 'movie' ? 'movie' : 'tv';

            $append_response = $vault['vault_type'] === 'movie' ? 'release_dates' : 'content_ratings';

            return $pool->as($vault['vault_id'])
                ->withToken(config('services.movie-api.token'))
                ->get("https://api.themoviedb.org/3/{$endpoint}/{$vault['vault_id']}?append_to_response={$append_response}");
        }));

        foreach ($vaults as $vault) {
            $response = $responses[$vault['vault_id']]->json();

            $keys = ['runtime', 'number_of_seasons'];

            foreach ($keys as $key) {
                if (isset($response[$key])) {
                    $response[$key] = $response[$key];
                }
            }

            $vault->update([
                'runtime' => $response['runtime'] ?? null,
                'seasons' => $response['number_of_seasons'] ?? null
            ]);
        }
    }
}
