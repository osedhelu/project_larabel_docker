<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilesHasPermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile_id',
        'permission_id',
        'deleted_at'
    ];
}
