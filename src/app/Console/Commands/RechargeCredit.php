<?php

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RechargeCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit:recharge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $userService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = $this->userService->getAll();

        foreach($users as $user) {
            $user->update(["credit_amount" => $user->credit_amount + 1]);
        }
    }
}
