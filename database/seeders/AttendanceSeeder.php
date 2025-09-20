<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = 3;

        $attendances = [
            ['date' => Carbon::parse('2025-05-13'), 'status' => 'present'],
            ['date' => Carbon::parse('2025-05-14'), 'status' => 'present'],
            ['date' => Carbon::parse('2025-05-15'), 'status' => 'late'],
            ['date' => Carbon::parse('2025-05-16'), 'status' => 'absent'],
            ['date' => Carbon::parse('2025-05-17'), 'status' => 'present'],
        ];

        foreach ($attendances as $attendance) {
            Attendance::create([
                'user_id' => $userId,
                'date' => $attendance['date'],
                'status' => $attendance['status'],
            ]);
        }
    }
}
