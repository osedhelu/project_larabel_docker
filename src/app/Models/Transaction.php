<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank',
        'client_phone',
        'affiliate_phone',
        'amount',
        'date',
        'hour',
        'reference',
        'reason',
        'terminal_id',
    ];
}
