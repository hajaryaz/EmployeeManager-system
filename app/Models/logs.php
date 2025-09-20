<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utilisateures;

class logs extends Model
{
    protected $fillable = ['user_id', 'action', 'details', 'status'];
    use HasFactory;

    public function user()
{
    return $this->belongsTo(Utilisateures::class, 'user_id');
}
}
