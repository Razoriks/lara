<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {login} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $validator = Validator::make($this->arguments(), [
            'login' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        try {
            $user = User::create([
                'name' => $this->argument('login'),
                'login' => $this->argument('login'),
                'email' => $this->argument('email'),
                'password' => Hash::make($this->argument('password')),
            ]);

            $this->info('User created!');
            $this->info("New user id: $user->id ");
        } catch (\Throwable $e) {
            $this->error("Error: {$e->getMessage()}");
        }
    }
}
