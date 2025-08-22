<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HelpRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'help_category_id',
        'title',
        'description',
        'location',
        'is_remote',
        'scheduled_at',
        'ends_at',
        'is_recurring',
        'recurrence_pattern',
        'is_emergency',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_remote' => 'boolean',
        'scheduled_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_recurring' => 'boolean',
        'is_emergency' => 'boolean',
    ];

    /**
     * Get the user who created the help request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the help request.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(HelpCategory::class, 'help_category_id');
    }

    /**
     * Get the skills required for this help request.
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(HelpSkill::class, 'help_request_skill')
            ->withTimestamps();
    }

    /**
     * Get the offers for this help request.
     */
    public function offers(): HasMany
    {
        return $this->hasMany(HelpOffer::class);
    }

    /**
     * Get the accepted offer for this help request.
     */
    public function acceptedOffer()
    {
        return $this->offers()->where('status', 'accepted')->first();
    }

    /**
     * Get the helper who was assigned to this request.
     */
    public function helper()
    {
        $offer = $this->acceptedOffer();
        return $offer ? $offer->user : null;
    }

    /**
     * Get the messages for this help request.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(HelpMessage::class);
    }

    /**
     * Get the feedback for this help request.
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(HelpFeedback::class);
    }

    /**
     * Check if the request is open and can receive offers.
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Check if the request is assigned to a helper.
     */
    public function isAssigned(): bool
    {
        return $this->status === 'assigned';
    }

    /**
     * Check if the request is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if the request is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the request is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
