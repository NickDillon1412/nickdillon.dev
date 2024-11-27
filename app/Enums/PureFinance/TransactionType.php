<?php

declare(strict_types=1);

namespace App\Enums\PureFinance;

enum TransactionType: string
{
	case WITHDRAWAL = 'withdrawal';
	case DEPOSIT = 'deposit';
	case TRANSFER = 'transfer';

	public function label(): string
	{
		return match ($this) {
			self::WITHDRAWAL => 'Withdrawal',
			self::DEPOSIT => 'Deposit',
			self::TRANSFER => 'Transfer',
		};
	}
}
