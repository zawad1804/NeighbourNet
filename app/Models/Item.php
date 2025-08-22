<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'category',
        'type',
        'price',
        'condition',
        'brand',
        'image',
        'location',
        'status',
        'hide_location',
        'contact_message',
        'contact_phone',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gallery' => 'array',
        'price' => 'float',
        'hide_location' => 'boolean',
        'contact_message' => 'boolean',
        'contact_phone' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the user that owns the item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Format the price for display.
     */
    public function formattedPrice()
    {
        if ($this->type === 'free') {
            return 'Free';
        } else if ($this->type === 'wanted') {
            return 'Budget: $' . number_format($this->price, 2);
        } else if ($this->type === 'rent') {
            return '$' . number_format($this->price, 2) . '/day';
        } else {
            return '$' . number_format($this->price, 2);
        }
    }
    
    /**
     * Get a badge class based on the item type.
     */
    public function getTypeBadgeClass()
    {
        switch ($this->type) {
            case 'for-sale':
                return 'badge-primary';
            case 'free':
                return 'badge-success';
            case 'rent':
                return 'badge-info';
            case 'wanted':
                return 'badge-warning';
            default:
                return 'badge-secondary';
        }
    }
    
    /**
     * Get a human-readable status label.
     */
    public function getStatusLabel()
    {
        switch ($this->status) {
            case 'available':
                return 'Available';
            case 'pending':
                return 'Pending Sale/Pickup';
            case 'sold':
                return 'Sold/No Longer Available';
            default:
                return 'Unknown';
        }
    }
}
