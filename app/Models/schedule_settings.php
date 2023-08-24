<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule_settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'n',
        'e',
        'nn',
        'ee',
        'ne',
        'nne',
        'nee',
        'nnn',
        'eee',
        'folytonos'
    ];
}
