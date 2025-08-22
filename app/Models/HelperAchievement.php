<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HelperAchievement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'badge_image',
        'achievement_type',
        'threshold',
        'criteria',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'threshold' => 'integer',
        'criteria' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the users who have earned this achievement.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievement')
                    ->withPivot('achieved_at', 'progress', 'is_featured')
                    ->withTimestamps();
    }

    /**
     * Check if the achievement is a milestone based on the number of completed helps.
     */
    public function isMilestone(): bool
    {
        return $this->achievement_type === 'milestone';
    }

    /**
     * Check if the achievement is category-specific.
     */
    public function isCategorySpecific(): bool
    {
        return $this->achievement_type === 'category_specialist';
    }

    /**
     * Check if the achievement is streak-based.
     */
    public function isStreak(): bool
    {
        return $this->achievement_type === 'streak';
    }

    /**
     * Check if the achievement is for emergency responses.
     */
    public function isEmergencyResponse(): bool
    {
        return $this->achievement_type === 'emergency_response';
    }
}
