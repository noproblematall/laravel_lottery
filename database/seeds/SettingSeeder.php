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
            'time_of_prize1' => '14:00',
            'time_of_prize2' => '15:00',
            'time_of_prize3' => '16:00',
            'cost_of_ticket' => 10,
            'min_of_btc' => 1.2,
        ]);
    }
}
