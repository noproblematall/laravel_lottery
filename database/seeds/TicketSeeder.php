<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,100) as $index) {
            mt_srand();
	        DB::table('tickets')->insert([
                'user_id' => $faker->numberBetween(2, 21),
	            'invoice_id' => $faker->numberBetween($min = 100001, $max = 100020),
                // 'lottery_id' => ,
                'number' => mt_rand(1000000, 9999999),
                'is_win' => 0,
	        ]);
	    }
    }
}
