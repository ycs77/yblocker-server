<?php

namespace App\Models;

use App\Models\Concerns\HasBatch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class History extends Model
{
    use HasFactory;
    use HasBatch;

    protected $fillable = [
        'url',
        'hostname',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeHiddenlist(Builder $query): void
    {
        if (Storage::exists('hiddenlist.txt')) {
            $domains = explode("\n", Storage::get('hiddenlist.txt', ''));

            $query->whereNotIn('hostname', $domains);
        }
    }
}
