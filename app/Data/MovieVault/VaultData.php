<?php

declare(strict_types=1);

namespace App\Data\MovieVault;

use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class VaultData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public int $vault_id,
        public string $vault_type,
        public ?string $title,
        public ?string $original_title,
        public ?string $name,
        public ?string $original_name,
        public string $overview,
        public ?string $backdrop_path,
        public ?string $poster_path,
        public ?string $release_date,
        public ?string $first_air_date,
    ) {}
}
