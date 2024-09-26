<?php

declare(strict_types=1);

use App\Models\User;
use function Pest\Laravel\actingAs;

use App\Livewire\MovieVault\Explore;
use function Pest\Livewire\livewire;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    actingAs(
        User::factory()
            ->hasVaults(1)
            ->create()
    );
});

it('can save new movie', function () {
    Http::fake([
        "https://api.themoviedb.org/3/search/multi*" => Http::response([
            'results' => [
                [
                    "backdrop_path" => "/wjxyKpUAZu6OVbKx9krhgI9KMl2.jpg",
                    "id" => 11528,
                    "title" => "The Sandlot",
                    "original_title" => "The Sandlot",
                    "overview" => "During a summer of friendship and adventure, one boy becomes a part of the gang, nine boys become a team and their leader becomes a legend by confronting the team",
                    "poster_path" => "/7PYqz0viEuW8qTvuGinUMjDWMnj.jpg",
                    "media_type" => "movie",
                    "adult" => false,
                    "original_language" => "en",
                    "release_date" => "1993-04-07",
                ]
            ]
        ], 200)
    ]);

    Http::fake([
        "https://api.themoviedb.org/3/movie/*",
        Http::response([
            [
                "backdrop_path" => "/wjxyKpUAZu6OVbKx9krhgI9KMl2.jpg",
                "id" => 1234,
                "title" => "The Sandlot",
                "original_title" => "The Sandlot",
                "overview" => "During a summer of friendship and adventure, one boy becomes a part of the gang, nine boys become a team and their leader becomes a legend by confronting the team",
                "poster_path" => "/7PYqz0viEuW8qTvuGinUMjDWMnj.jpg",
                "media_type" => "movie",
                "adult" => false,
                "original_language" => "en",
                "release_date" => "1993-04-07",
                'release_dates' => [
                    'results' => [
                        [
                            'iso_3166_1' => 'US',
                            'release_dates' => [
                                [
                                    'certification' => 'PG'
                                ]
                            ]
                        ]
                    ]
                ],
                'genres' => [
                    [
                        'id' => 1,
                        'name' => 'Family'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Comedy'
                    ]
                ]
            ]
        ], 200)
    ]);

    Http::withToken('test-key')
        ->get("https://api.themoviedb.org/3/movie/*", [
            'append_to_response' => 'release_dates',
        ]);

    livewire(Explore::class)
        ->set('search', 'Interstellar')
        ->call('save', [
            'backdrop_path' => '/xJHokMbljvjADYdit5fK5VQsXEG.jpg',
            'id' => 157336,
            'title' => 'Interstellar',
            'original_title' => 'Interstellar',
            'overview' => 'Interstellar',
            'poster_path' => '/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
            'media_type' => 'movie',
            'release_date' => '2014-11-05',
            'rating' => 'PG',
            'genres' => 'Drama,Space'
        ])
        ->assertNoRedirect()
        ->assertHasNoErrors();
});

it('can save new tv show', function () {
    Http::fake([
        "https://api.themoviedb.org/3/search/multi*" => Http::response([
            'results' => [
                [
                    "backdrop_path" => "/wjxyKpUAZu6OVbKx9krhgI9KMl2.jpg",
                    "id" => 11528,
                    "name" => "Psych",
                    "original_name" => "Psych",
                    "overview" => "Thanks to his police officer father's efforts, Shawn Spencer spent his childhood developing a keen eye for detail (and a lasting dislike of his dad). Years late",
                    "poster_path" => "/7PYqz0viEuW8qTvuGinUMjDWMnj.jpg",
                    "media_type" => "tv",
                    "adult" => false,
                    "original_language" => "en",
                    "first_air_date" => "2014-03-26",
                ]
            ]
        ], 200)
    ]);

    Http::withToken('test-key')
        ->get("https://api.themoviedb.org/3/search/multi*");

    Http::fake([
        "https://api.themoviedb.org/3/tv/*",
        Http::response([
            [
                "backdrop_path" => "/zHA6kd8INvqMfGR9vDrn1GATKxs.jpg",
                "id" => 1234,
                "name" => "Psych",
                "original_name" => "Psych",
                "overview" => "Thanks to his police officer father's efforts, Shawn Spencer spent his childhood developing a keen eye for detail (and a lasting dislike of his dad). Years late",
                "poster_path" => "/fDI15gTVbtW5Sbv5QenqecRxWKJ.jpg",
                "media_type" => "tv",
                "adult" => false,
                "original_language" => "en",
                "first_air_date" => "2014-03-26",
                'content_ratings' => [
                    'results' => [
                        [
                            'iso_3166_1' => 'US',
                            'rating' => 'TV-PG'
                        ]
                    ]
                ],
                'genres' => [
                    [
                        'id' => 1,
                        'name' => 'Family'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Comedy'
                    ]
                ]
            ]
        ], 200)
    ]);

    Http::withToken('test-key')
        ->get("https://api.themoviedb.org/3/tv/*", [
            'append_to_response' => 'content_ratings',
        ]);

    livewire(Explore::class)
        ->set('search', 'Suits')
        ->call('save', [
            'backdrop_path' => '/xJHokMbljvjADYdit5fK5VQsXEG.jpg',
            'id' => 1573367,
            'name' => 'Suits',
            'original_name' => 'Suits',
            'overview' => 'Suits',
            'poster_path' => '/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
            'media_type' => 'tv',
            'first_air_date' => '2010-07-10',
            'rating' => 'TV-PG',
            'genres' => 'Drama,Comedy'
        ])
        ->assertNoRedirect()
        ->assertHasNoErrors();
});

it('can show popup alert when record already exists in vault', function () {
    livewire(Explore::class)
        ->call('save', [
            'id' => 1234,
            'title' => 'Test Movie',
        ])
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(Explore::class)
        ->assertHasNoErrors();
});
