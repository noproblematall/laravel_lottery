<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('111'),
            'role_id' => 1,
            'email_verified_at' => date('Y-m-d h:i:s'),
        ]);

        $faker = Faker::create();
    	foreach (range(1,20) as $index) {
	        DB::table('users')->insert([
                'username' => strtolower($faker->unique()->firstName()),
	            'email' => $faker->email,
                'password' => bcrypt('111'),
                'role_id' => 2,
                'email_verified_at' => $faker->date('Y-m-d', 'now')
	        ]);
	    }

    }
}
