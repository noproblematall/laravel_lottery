<?php


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(InvoicePaymentSeeder::class);
        $this->call(TicketSeeder::class);

    }
}
