<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTransactionJob;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class UserBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:balance {--login=} {--amount=} {--desc=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change user balance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $validator = Validator::make($this->options(), [
            'login' => ['required', 'exists:users,login'],
            'amount' => ['required', 'numeric', 'different:0'],
            'desc' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        try {
            $user = User::where('login', $this->option('login'))->firstOrFail();

            ProcessTransactionJob::dispatch(
                $user,
                (int) ($this->option('amount') * 100),
                $this->option('desc')
            );

            $this->info('Process transaction job created!');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error("Error: {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
