<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'phone',
        'city',
        'address',
        'post_code',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    /**
     * Get the posts for the user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    /**
     * Get the events created by the user.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    
    /**
     * Get the events the user is attending.
     */
    public function attendingEvents()
    {
        return $this->belongsToMany(Event::class, 'event_attendees')
                    ->withTimestamps();
    }
    
    /**
     * Get the marketplace items created by the user.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    /**
     * Get the help requests created by the user.
     */
    public function helpRequests()
    {
        return $this->hasMany(HelpRequest::class);
    }
    
    /**
     * Get the help offers made by the user.
     */
    public function helpOffers()
    {
        return $this->hasMany(HelpOffer::class);
    }
    
    /**
     * Get the help categories the user can help with.
     */
    public function helpCategories()
    {
        return $this->belongsToMany(HelpCategory::class, 'helper_category')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }
    
    /**
     * Get the skills the user has.
     */
    public function helpSkills()
    {
        return $this->belongsToMany(HelpSkill::class, 'helper_skill')
                    ->withPivot('is_verified', 'verified_at', 'notes')
                    ->withTimestamps();
    }
    
    /**
     * Get the user's help availability.
     */
    public function availability()
    {
        return $this->hasOne(HelperAvailability::class)->latest();
    }
    
    /**
     * Get the achievements earned by the user.
     */
    public function achievements()
    {
        return $this->belongsToMany(HelperAchievement::class, 'user_achievement')
                    ->withPivot('achieved_at', 'progress', 'is_featured')
                    ->withTimestamps();
    }
    
    /**
     * Get the feedback received by the user as a helper.
     */
    public function receivedFeedback()
    {
        return $this->hasMany(HelpFeedback::class, 'helper_id');
    }
    
    /**
     * Get the feedback given by the user.
     */
    public function givenFeedback()
    {
        return $this->hasMany(HelpFeedback::class, 'user_id');
    }
    
    /**
     * Calculate the user's average rating as a helper.
     */
    public function getAverageRating()
    {
        $feedbacks = $this->receivedFeedback;
        if ($feedbacks->isEmpty()) {
            return 0;
        }
        
        return $feedbacks->avg('overall_rating');
    }
    
    /**
     * Check if the user is available to help.
     */
    public function isAvailableToHelp()
    {
        $availability = $this->availability;
        return $availability ? $availability->isAvailable() : false;
    }
    
    /**
     * Check if the user is available for emergency help.
     */
    public function isAvailableForEmergency()
    {
        $availability = $this->availability;
        return $availability ? $availability->isAvailableForEmergency() : false;
    }
}
