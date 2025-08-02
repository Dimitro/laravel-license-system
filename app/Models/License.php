<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'serial_number',
        'name',
        'quantity',
        'state',
        'type',
    ];
}
