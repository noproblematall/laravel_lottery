<?php

namespace App\Console\Commands;
use App\Http\Controllers\LotteryController;
use Illuminate\Console\Command;

class StartLotteryThree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prize3:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Let us start lottery3!';

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
        $result = $lottery->lottery_prize3();
        echo $result;
    }
}
