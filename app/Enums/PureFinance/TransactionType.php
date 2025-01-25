<?php

declare(strict_types=1);

namespace App\Enums\PureFinance;

enum TransactionType: string
{
	case CREDIT = 'credit';
	case DEBIT = 'debit';
	case DEPOSIT = 'deposit';
	case TRANSFER = 'transfer';
	case WITHDRAWAL = 'withdrawal';

	public function label(): string
	{
		return match ($this) {
			self::CREDIT => 'Credit',
			self::DEBIT => 'Debit',
			self::DEPOSIT => 'Deposit',
			self::TRANSFER => 'Transfer',
			self::WITHDRAWAL => 'Withdrawal',
		};
	}
}
