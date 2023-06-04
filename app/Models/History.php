<?php

namespace App\Models;

use App\Models\Concerns\HasBatch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    use HasBatch;

    protected $fillable = [
        'url',
        'hostname',
        'blocked',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'blocked' => 'boolean',
        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
