<?php

namespace App\Console\Commands;

use App\Http\Controllers\FrontEndController;

use Illuminate\Console\Command;

class FakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake Data Seeder';

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
        $fake = new FrontEndController();
        $result = $fake->fake_data();
    }
}
