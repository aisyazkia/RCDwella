<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::insert([
            [
                'id' => 1,
                'day' => 1,
            ],
            [
                'id' => 2,
                'day' => 2,
            ],
            [
                'id' => 3,
                'day' => 3,
            ],
            [
                'id' => 4,
                'day' => 4,
            ],
            [
                'id' => 5,
                'day' => 5,
            ],
            [
                'id' => 6,
                'day' => 6,
            ],
        ]);

        ScheduleDetail::insert([
            [
                'schedule_id' => 1,
                'time' => '09:00',
            ],
            [
                'schedule_id' => 1,
                'time' => '10:00',
            ],
            [
                'schedule_id' => 1,
                'time' => '11:00',
            ],
            [
                'schedule_id' => 1,
                'time' => '13:00',
            ],
            [
                'schedule_id' => 1,
                'time' => '14:00',
            ],
            [
                'schedule_id' => 1,
                'time' => '15:00',
            ],
            [
                'schedule_id' => 2,
                'time' => '09:00',
            ],
            [
                'schedule_id' => 2,
                'time' => '10:00',
            ],
            [
                'schedule_id' => 2,
                'time' => '11:00',
            ],
            [
                'schedule_id' => 2,
                'time' => '13:00',
            ],
            [
                'schedule_id' => 2,
                'time' => '14:00',
            ],
            [
                'schedule_id' => 2,
                'time' => '15:00',
            ],
            [
                'schedule_id' => 3,
                'time' => '09:00',
            ],
            [
                'schedule_id' => 3,
                'time' => '10:00',
            ],
            [
                'schedule_id' => 3,
                'time' => '11:00',
            ],
            [
                'schedule_id' => 3,
                'time' => '13:00',
            ],
            [
                'schedule_id' => 3,
                'time' => '14:00',
            ],
            [
                'schedule_id' => 3,
                'time' => '15:00',
            ],
            [
                'schedule_id' => 4,
                'time' => '09:00',
            ],
            [
                'schedule_id' => 4,
                'time' => '10:00',
            ],
            [
                'schedule_id' => 4,
                'time' => '11:00',
            ],
            [
                'schedule_id' => 4,
                'time' => '13:00',
            ],
            [
                'schedule_id' => 4,
                'time' => '14:00',
            ],
            [
                'schedule_id' => 4,
                'time' => '15:00',
            ],
            [
                'schedule_id' => 5,
                'time' => '09:00',
            ],
            [
                'schedule_id' => 5,
                'time' => '10:00',
            ],
            [
                'schedule_id' => 5,
                'time' => '11:00',
            ],
            [
                'schedule_id' => 5,
                'time' => '13:00',
            ],
            [
                'schedule_id' => 5,
                'time' => '14:00',
            ],
            [
                'schedule_id' => 5,
                'time' => '15:00',
            ],
            [
                'schedule_id' => 6,
                'time' => '09:00',
            ],
            [
                'schedule_id' => 6,
                'time' => '10:00',
            ],
            [
                'schedule_id' => 6,
                'time' => '11:00',
            ],
            [
                'schedule_id' => 6,
                'time' => '13:00',
            ],
            [
                'schedule_id' => 6,
                'time' => '14:00',
            ],
            [
                'schedule_id' => 6,
                'time' => '15:00',
            ],
        ]);
    }
}
