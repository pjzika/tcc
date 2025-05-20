<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feeding extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_id',
        'started_at',
        'ended_at',
        'duration',
        'quantity'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'duration' => 'integer',
        'quantity' => 'integer'
    ];

    protected $appends = [
        'formatted_duration'
    ];

    public function baby(): BelongsTo
    {
        return $this->belongsTo(Baby::class);
    }

    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $minutes);
        }
        
        return sprintf('%d min', $minutes);
    }
} 