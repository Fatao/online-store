<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand_id', 'model', 'name', 'price', 'unit',
        'year', 'mileage', 'horsepower', 'fuel_type', 'transmission',
        'body_type', 'color', 'description', 'features',
        'image', 'gallery', 'stock', 'is_active', 'is_featured',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'gallery'     => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'car_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'car_id');
    }

    public function averageRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    /** Features stored as comma-separated string, returned as array */
    public function featuresList(): array
    {
        return $this->features
            ? array_map('trim', explode(',', $this->features))
            : [];
    }
}