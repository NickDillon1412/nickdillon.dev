<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\PureFinance\Category;
use Illuminate\Support\Facades\Storage;

class PureFinanceService
{
	public function getAccounts(): Collection
	{
		return auth()
			->user()
			->accounts()
			->select('name')
			->distinct()
			->pluck('name')
			->sort();
	}

	public function getCategories(): Collection
	{
		return Category::query()
			->select('name')
			->distinct()
			->pluck('name')
			->sort();
	}

	public static function getS3Path(string $file_name): string
	{
		return Storage::disk('s3')->url("pure-finance/files/{$file_name}");
	}
}
