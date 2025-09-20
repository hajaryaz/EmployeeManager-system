<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Utilisateures;
use App\Models\Document;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DocumentSeeder extends Seeder
{
    public function run()
    {
        Document::create([
    'employee_id' => 3,
    'employee_name' => 'Tarik Boukaidi',
    'document_title' => 'Work Certificate',
    'description' => 'Requested for visa application',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(4),
    'updated_at' => Carbon::now()->subDays(2),
]);

Document::create([
    'employee_id' => 4,
    'employee_name' => 'Jalal Grini',
    'document_title' => 'Salary Slip',
    'description' => 'Required for daycare registration',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(7),
    'updated_at' => Carbon::now()->subDays(1),
]);

Document::create([
    'employee_id' => 5,
    'employee_name' => 'Mohamed Benzraidi',
    'document_title' => 'Recommendation Letter',
    'description' => 'For Master’s program application',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(6),
    'updated_at' => Carbon::now()->subDays(1),
]);

Document::create([
    'employee_id' => 6,
    'employee_name' => 'Youssef El Amrani',
    'document_title' => 'Attendance Certificate',
    'description' => 'Requested for internship application',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(3),
    'updated_at' => Carbon::now()->subDays(1),
]);

Document::create([
    'employee_id' => 7,
    'employee_name' => 'Amina Benali',
    'document_title' => 'Salary Slip',
    'description' => 'Needed for bank file',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(8),
    'updated_at' => Carbon::now()->subDays(1),
]);

Document::create([
    'employee_id' => 8,
    'employee_name' => 'Rachid Moujahid',
    'document_title' => 'Transfer Request',
    'description' => 'Team change request',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(5),
    'updated_at' => Carbon::now()->subDays(1),
]);

Document::create([
    'employee_id' => 9,
    'employee_name' => 'Khadija Zerhouni',
    'document_title' => 'Certificate Request',
    'description' => 'For university enrollment',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(4),
    'updated_at' => Carbon::now()->subDays(1),
]);

Document::create([
    'employee_id' => 10,
    'employee_name' => 'Walid Bouzid',
    'document_title' => 'Recommendation Letter',
    'description' => 'For scholarship application',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(9),
    'updated_at' => Carbon::now()->subDays(2),
]);


Document::create([
    'employee_id' => 12,
    'employee_name' => 'Hicham Bennis',
    'document_title' => 'Salary Slip',
    'description' => 'For personal loan application',
    'status' => 'pending',
    'created_at' => Carbon::now()->subDays(5),
    'updated_at' => Carbon::now()->subDays(1),
]);


    }
}