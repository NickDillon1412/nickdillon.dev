<?php

declare(strict_types=1);

namespace App\Actions\PureFinance;

use App\Models\PureFinance\Account;
use function Illuminate\Support\defer;
use App\Models\PureFinance\Transaction;
use App\Enums\PureFinance\TransactionType;

class UpdateAccountBalance
{
	public function handle(Transaction $transaction, string $event): void
	{
		defer(function () use ($transaction, $event) {
			$account = $transaction->account;

			match ($event) {
				'creating' => $this->adjustBalance($account, $transaction->type, $transaction->amount),
				'updating' => $this->handleUpdatedTransaction($account, $transaction),
				'deleting' => $this->reverseBalance($account, $transaction->type, $transaction->amount),
			};
		});
	}

	private function adjustBalance(Account $account, TransactionType $type, float $amount): void
	{
		match ($type) {
			TransactionType::CREDIT,
			TransactionType::DEPOSIT => $account->increment('balance', $amount),
			TransactionType::DEBIT,
			TransactionType::TRANSFER,
			TransactionType::WITHDRAWAL => $account->decrement('balance', abs($amount)),
		};
	}

	private function handleUpdatedTransaction(Account $account, Transaction $transaction): void
	{
		$this->reverseBalance($account, $transaction->getOriginal('type'), $transaction->getOriginal('amount'));

		$this->adjustBalance($account, $transaction->type, $transaction->amount);
	}

	private function reverseBalance(Account $account, TransactionType $type, float $amount): void
	{
		match ($type) {
			TransactionType::CREDIT,
			TransactionType::DEPOSIT => $account->decrement('balance', abs($amount)),
			TransactionType::DEBIT,
			TransactionType::TRANSFER,
			TransactionType::WITHDRAWAL => $account->increment('balance', $amount),
		};
	}
}
