<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
    	foreach (range(1,20) as $index) {
	        DB::table('invoices')->insert([
                'user_id' => $faker->unique()->numberBetween(2, 21),
	            'secret' => md5(uniqid()),
                'my_invoice_id' => $faker->unique()->numberBetween($min = 100001, $max = 100020),
                'price_in_bitcoin' => 0.02,
                'address' => $faker->creditCardNumber,
                'number_of_ticket' => 5,
                'wallet_address' => $faker->iban(),
                'is_paid' => '1'
	        ]);
	    }
    }
}
