<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'rif',
        'email',
        'phone',
        'password',
        'user_id',
        'deleted_at'
    ];
}
