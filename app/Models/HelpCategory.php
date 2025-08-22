<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HelpCategory extends Model
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
        'icon',
        'description',
        'requires_verification',
        'allows_emergency_requests',
        'is_active',
        'display_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requires_verification' => 'boolean',
        'allows_emergency_requests' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the skills associated with this category.
     */
    public function skills(): HasMany
    {
        return $this->hasMany(HelpSkill::class);
    }

    /**
     * Get the help requests in this category.
     */
    public function helpRequests(): HasMany
    {
        return $this->hasMany(HelpRequest::class);
    }

    /**
     * Get the helpers who can help in this category.
     */
    public function helpers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'helper_category')
            ->withPivot('is_primary')
            ->withTimestamps();
    }
}
