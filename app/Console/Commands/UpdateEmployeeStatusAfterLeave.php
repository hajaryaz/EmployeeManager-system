<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Leave;
use App\Models\Utilisateures;
use App\Models\logs;
use Carbon\Carbon;

class ActivateUsersAfterLeave extends Command
{
    protected $signature = 'leaves:activate-users';
    protected $description = 'Set users to active if their leave ended yesterday';

    public function handle()
    {
        $yesterday = Carbon::yesterday()->toDateString();

        $leaves = Leave::where('status', 'approved')
                      ->whereDate('end_date', $yesterday)
                      ->get();

        foreach ($leaves as $leave) {
            $user = Utilisateures::find($leave->employee_id);
            if ($user && $user->etat !== 'Actif') {
                $user->etat = 'Actif';
                $user->save();

                logs::create([
                    'user_id' => $user->id,
                    'action' => 'Etat changed to Actif after leave',
                    'details' => "Leave ended on $yesterday",
                    'status' => 'success',
                ]);
            }
        }

        $this->info('Users reactivated if leave ended yesterday.');
    }
}
