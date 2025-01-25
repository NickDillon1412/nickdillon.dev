<?php

declare(strict_types=1);

namespace App\Actions\PureFinance;

use App\Models\PureFinance\Account;
use App\Enums\PureFinance\TransactionType;

class RecalculateAccountBalance
{
	public function handle(Account $account): void
	{
		$debit_amount = $account
			->transactions()
			->where('type', TransactionType::DEBIT)
			->sum('amount');

		$credit_amount = $account
			->transactions()
			->whereIn('type', [TransactionType::CREDIT, TransactionType::DEPOSIT])
			->sum('amount');

		$withdrawal_amount = $account
			->transactions()
			->whereIn('type', [TransactionType::TRANSFER, TransactionType::WITHDRAWAL])
			->sum('amount');

		$account->update([
			'balance' => $credit_amount - $debit_amount - $withdrawal_amount
		]);
	}
}
