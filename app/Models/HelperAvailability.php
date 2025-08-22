<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelperAvailability extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'available_from',
        'available_until',
        'available_for_emergency',
        'recurring_schedule',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'available_for_emergency' => 'boolean',
        'recurring_schedule' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user this availability belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the user is currently available.
     */
    public function isAvailable(): bool
    {
        if ($this->status === 'available_now') {
            return true;
        }

        if ($this->status === 'available_today' && now()->isSameDay($this->available_from)) {
            return true;
        }

        if ($this->available_from && $this->available_until) {
            $now = now();
            return $now->greaterThanOrEqualTo($this->available_from) && 
                   $now->lessThanOrEqualTo($this->available_until);
        }

        return false;
    }

    /**
     * Check if the user is available for emergency requests.
     */
    public function isAvailableForEmergency(): bool
    {
        return $this->available_for_emergency;
    }

    /**
     * Get the days of the week when the user is available from the recurring schedule.
     */
    public function getAvailableDays(): array
    {
        return array_keys($this->recurring_schedule ?? []);
    }
}
