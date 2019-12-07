<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'time_of_prize1' => '16:00',
            'time_of_prize2' => '17:00',
            'time_of_prize3' => '18:00',
            'cost_of_ticket' => 25,
            'min_of_btc' => 2,
        ]);
    }
}
