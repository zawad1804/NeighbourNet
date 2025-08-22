<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpFeedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'help_request_id',
        'user_id',
        'helper_id',
        'punctuality_rating',
        'communication_rating',
        'quality_rating',
        'friendliness_rating',
        'overall_rating',
        'comments',
        'is_anonymous',
        'helper_response',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'punctuality_rating' => 'integer',
        'communication_rating' => 'integer',
        'quality_rating' => 'integer',
        'friendliness_rating' => 'integer',
        'overall_rating' => 'integer',
        'is_anonymous' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the help request this feedback is for.
     */
    public function helpRequest(): BelongsTo
    {
        return $this->belongsTo(HelpRequest::class);
    }

    /**
     * Get the user who left the feedback.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the helper who received the feedback.
     */
    public function helper(): BelongsTo
    {
        return $this->belongsTo(User::class, 'helper_id');
    }

    /**
     * Calculate the average rating.
     */
    public function getAverageRating(): float
    {
        $ratings = array_filter([
            $this->punctuality_rating,
            $this->communication_rating,
            $this->quality_rating,
            $this->friendliness_rating,
            $this->overall_rating,
        ]);

        return count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
    }

    /**
     * Check if the helper has responded to the feedback.
     */
    public function hasHelperResponse(): bool
    {
        return !empty($this->helper_response);
    }
}
