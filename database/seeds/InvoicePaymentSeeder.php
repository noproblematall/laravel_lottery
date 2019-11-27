<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\InvoicePayment;
class InvoicePaymentSeeder extends Seeder
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
	        DB::table('invoice_payments')->insert([
                'transaction_hash' => $faker->unique()->numberBetween($min = 200001, $max = 200020),
	            'value' => 0.1,
                'invoice_id' => $faker->unique()->numberBetween($min = 100001, $max = 100020),
	        ]);
	    }
    }
}
