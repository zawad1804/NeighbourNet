<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'category',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'location',
        'location_details',
        'image',
        'max_attendees',
        'is_public',
        'rsvp_enabled',
        'user_id',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_public' => 'boolean',
        'rsvp_enabled' => 'boolean',
        'max_attendees' => 'integer',
    ];
    
    /**
     * Get the user who created the event.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the users attending this event.
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_attendees')
                    ->withTimestamps();
    }
}
