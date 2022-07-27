<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial',
        'password',
        'vuelto',
        'reversoc2p',
        'status',
        'model_id',
        'mark_id',
        'branch_id',
        'affiliate_id',
        'deleted_at'
    ];
}
