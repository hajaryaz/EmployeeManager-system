<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'published_at',
        'author',
        'author_id',
    ];
    use HasFactory;
}
