<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'hostname',
        'blocked',
    ];

    protected $casts = [
        'blocked' => 'boolean',
    ];
}
