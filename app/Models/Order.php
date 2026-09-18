<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'subtotal', 'discount', 'total',
        'status', 'sale_date', 'delivery_date',
        'shipping_address', 'shipping_phone',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'discount'      => 'decimal:2',
        'total'         => 'decimal:2',
        'sale_date'     => 'date',
        'delivery_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function statusLabels(): array
    {
        return [
            'pending'    => 'Ожидает обработки',
            'processing' => 'В обработке',
            'shipped'    => 'Отправлен',
            'delivered'  => 'Доставлен',
            'cancelled'  => 'Отменён',
        ];
    }

    /** Human-readable label for this order's status */
    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    /** CSS color for this order's status */
    public function statusColor(): string
    {
        return match($this->status) {
            'pending'    => '#c9a86a',
            'processing' => '#00ccff',
            'shipped'    => '#8888ff',
            'delivered'  => '#44cc88',
            'cancelled'  => '#e2566b',
            default      => '#8d8a86',
        };
    }
}