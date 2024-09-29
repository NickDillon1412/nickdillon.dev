<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Number;

class MovieVaultService
{
	public static function getGenres(?bool $on_wishlist = false): array
	{
		$genres = [];

		auth()
			->user()
			->vaults()
			->whereOnWishlist($on_wishlist)
			->pluck('genres')
			->each(function (string $genre) use (&$genres): void {
				$genres_array = explode(',', $genre);

				foreach ($genres_array as $genre_key) {
					if (!in_array($genre_key, $genres)) {
						$genres[] = $genre_key;
					}
				}
			});

		sort($genres);

		return $genres;
	}

	public static function formatRuntime(int $runtime): string
	{
		if ($runtime >= 60) {
			$hours = intdiv($runtime, 60);

			$minutes = $runtime % 60;

			return Number::format($hours) . 'h ' . Number::format($minutes) . 'm';
		} else {
			return Number::format($runtime) . 'm';
		}
	}
}
