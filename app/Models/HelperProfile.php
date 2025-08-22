<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelperProfile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'helper_availabilities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
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
     * @var array
     */
    protected $casts = [
        'available_from' => 'datetime',
        'available_until' => 'datetime',
        'available_for_emergency' => 'boolean',
        'recurring_schedule' => 'array',
    ];

    /**
     * Get the user that owns the helper profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
