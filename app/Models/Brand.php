<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'logo', 'featured'];

    protected $casts = [
        'featured' => 'boolean',
    ];

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    /** Human-readable category labels (Russian) for grouping on the brands page */
    public static function categoryLabels(): array
    {
        return [
            'hypercar'        => 'Гиперкары',
            'supercar'        => 'Суперкары',
            'luxury'          => 'Люксовые автомобили',
            'luxury_suv'      => 'Люксовые внедорожники',
            'electric_luxury' => 'Электрические люкс',
            'performance'     => 'Производительные бренды',
        ];
    }
}