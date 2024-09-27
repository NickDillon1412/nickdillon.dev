<?php

declare(strict_types=1);

namespace App\Services;

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

		return $genres;
	}
}
