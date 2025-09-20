<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Utilisateures;
use App\Models\leave;



class LeavesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        leave::create([
    'employee_id' => 4,
    'employee_name' => 'Jalal Grini',
    'leave_reason' => 'Maladie',
    'start_date' => '2025-06-01',
    'end_date' => '2025-06-05',
    'status' => 'pending',
    'rejected_reason' => null,
]);

leave::create([
    'employee_id' => 5,
    'employee_name' => 'Mohamed Benzraidi',
    'leave_reason' => 'Vacances annuelles',
    'start_date' => '2025-07-10',
    'end_date' => '2025-07-24',
    'status' => 'pending',
    'rejected_reason' => null,
]);

leave::create([
    'employee_id' => 6,
    'employee_name' => 'Youssef El Amrani',
    'leave_reason' => 'Congé exceptionnel',
    'start_date' => '2025-08-15',
    'end_date' => '2025-08-17',
    'status' => 'pending',
    'rejected_reason' => null,
]);

leave::create([
    'employee_id' => 7,
    'employee_name' => 'Amina Benali',
    'leave_reason' => 'Naissance',
    'start_date' => '2025-09-20',
    'end_date' => '2025-10-04',
    'status' => 'pending',
    'rejected_reason' => null,
]);

leave::create([
    'employee_id' => 8,
    'employee_name' => 'Rachid Moujahid',
    'leave_reason' => 'Décès d’un proche',
    'start_date' => '2025-10-12',
    'end_date' => '2025-10-15',
    'status' => 'pending',
    'rejected_reason' => null,
]);

leave::create([
    'employee_id' => 9,
    'employee_name' => 'Khadija Zerhouni',
    'leave_reason' => 'Congé sans solde',
    'start_date' => '2025-11-01',
    'end_date' => '2025-11-10',
    'status' => 'pending',
    'rejected_reason' => null,
]);

leave::create([
    'employee_id' => 10,
    'employee_name' => 'Walid Bouzid',
    'leave_reason' => 'Mariage',
    'start_date' => '2025-06-25',
    'end_date' => '2025-07-05',
    'status' => 'pending',
    'rejected_reason' => null,
]);

    }
}
