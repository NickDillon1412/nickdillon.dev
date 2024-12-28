<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use App\Models\PureFinance\Category;

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
}
