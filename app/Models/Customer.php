<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';

    protected $fillable = [
        'name', 'email', 'password', 'phone',
        'address', 'role', 'is_regular', 'total_spent',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_regular'  => 'boolean',
        'total_spent' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Threshold for becoming a "regular customer" (project spec: 5000 RUB).
     */
    public const REGULAR_THRESHOLD = 5000;

    /**
     * Discount rate for regular customers (project spec: 2%).
     */
    public const REGULAR_DISCOUNT = 0.02;

    /**
     * After an order is placed, add to total_spent and update regular status.
     */
    public function addSpending(float $amount): void
    {
        $this->total_spent += $amount;

        if ($this->total_spent >= self::REGULAR_THRESHOLD) {
            $this->is_regular = true;
        }

        $this->save();
    }

    /**
     * Returns the discount multiplier for this customer.
     */
    public function discountRate(): float
    {
        return $this->is_regular ? self::REGULAR_DISCOUNT : 0.0;
    }
}