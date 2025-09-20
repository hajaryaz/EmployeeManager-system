<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateures;

class leave extends Model
{
    protected $fillable = [
        'employee_id',
        'employee_name',
        'processed_at',
        'processed_by',
        'leave_reason',
        'start_date',
        'end_date',
        'status',
        'rejected_reason',
    ];

    public function employee()
{
    return $this->belongsTo(Utilisateures::class, 'employee_id');
}
    use HasFactory;
}
