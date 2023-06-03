<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'connected',
    ];

    protected $casts = [
        'connected' => 'boolean',
    ];

    public function histories()
    {
        return $this->hasMany(History::class);
    }
}
