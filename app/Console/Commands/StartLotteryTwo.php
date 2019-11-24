<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\LotteryController;

class StartLotteryTwo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prize2:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Let us start lottery2!';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $lottery = new LotteryController();
        $result = $lottery->lottery_prize2();
        echo $result;
    }
}
