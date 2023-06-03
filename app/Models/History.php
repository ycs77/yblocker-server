<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'hostname',
        'blocked',
        'client_id',
    ];

    protected $casts = [
        'blocked' => 'boolean',
        'client_id' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
