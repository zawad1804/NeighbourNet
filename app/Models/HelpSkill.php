<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HelpSkill extends Model
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
        'requires_verification',
        'help_category_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requires_verification' => 'boolean',
    ];

    /**
     * Get the category that this skill belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(HelpCategory::class, 'help_category_id');
    }

    /**
     * Get the help requests that require this skill.
     */
    public function helpRequests(): BelongsToMany
    {
        return $this->belongsToMany(HelpRequest::class, 'help_request_skill')
            ->withTimestamps();
    }

    /**
     * Get the users who have this skill.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'helper_skill')
            ->withPivot('is_verified', 'verified_at', 'notes')
            ->withTimestamps();
    }
}
