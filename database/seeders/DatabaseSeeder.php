<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call(LevelSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(TreatmentSeeder::class);
        $this->call(CourierTableSeeder::class);
        $this->call(LocationTableSeeder::class);
    }
}
