<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Baby extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birth_date'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    /**
     * Get the user that owns the baby.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the feedings for the baby.
     */
    public function feedings(): HasMany
    {
        return $this->hasMany(Feeding::class);
    }

    /**
     * Get the alarms for the baby.
     */
    public function alarms(): HasMany
    {
        return $this->hasMany(Alarm::class);
    }

    /**
     * Get the baby's age in months.
     */
    public function getAgeInMonthsAttribute(): int
    {
        return $this->birth_date->diffInMonths(Carbon::now());
    }
} 