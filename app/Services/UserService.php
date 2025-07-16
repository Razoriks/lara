<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(private User $user) {}

    public function processTransaction(int $amount, ?string $description = null): void
    {
        DB::transaction(function () use ($amount, $description) {
            $userBalance = $this->user->balance()->lockForUpdate()->firstOrCreate();

            $newBalance = $userBalance->balance + $amount;

            if ($newBalance < 0) {
                throw new \Exception('Insufficient funds');
            }

            $userBalance->update(['balance' => $newBalance]);

            $this->user->transactions()->create([
                'amount' => abs($amount),
                'type' => $amount > 0 ? TransactionType::DEPOSIT : TransactionType::WITHDRAWAL,
                'description' => $description,
            ]);
        });
    }
}
