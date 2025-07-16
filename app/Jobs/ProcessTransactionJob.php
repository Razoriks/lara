<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessTransactionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user,
        private int $amount,
        private string $description
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $userService = new UserService($this->user);
        $userService->processTransaction($this->amount, $this->description);
    }
}
