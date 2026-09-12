<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            // Hypercars
            ['name' => 'Bugatti',    'category' => 'hypercar', 'featured' => true],
            ['name' => 'Koenigsegg', 'category' => 'hypercar', 'featured' => true],
            ['name' => 'Pagani',     'category' => 'hypercar', 'featured' => true],
            ['name' => 'Rimac',      'category' => 'hypercar', 'featured' => true],

            // Supercars
            ['name' => 'Ferrari',     'category' => 'supercar', 'featured' => true],
            ['name' => 'Lamborghini', 'category' => 'supercar', 'featured' => true],
            ['name' => 'McLaren',     'category' => 'supercar', 'featured' => true],
            ['name' => 'Maserati',    'category' => 'supercar', 'featured' => true],
            ['name' => 'Aston Martin','category' => 'supercar', 'featured' => true],
            ['name' => 'Porsche',     'category' => 'supercar', 'featured' => true],
            ['name' => 'Lotus',       'category' => 'supercar', 'featured' => true],

            // Luxury Cars
            ['name' => 'Rolls-Royce',   'category' => 'luxury', 'featured' => true],
            ['name' => 'Bentley',       'category' => 'luxury', 'featured' => true],
            ['name' => 'Mercedes-Benz', 'category' => 'luxury', 'featured' => true],
            ['name' => 'BMW',           'category' => 'luxury', 'featured' => true],
            ['name' => 'Audi',          'category' => 'luxury', 'featured' => true],
            ['name' => 'Lexus',         'category' => 'luxury', 'featured' => true],
            ['name' => 'Genesis',       'category' => 'luxury', 'featured' => true],
            ['name' => 'Jaguar',        'category' => 'luxury', 'featured' => true],

            // Luxury SUVs
            ['name' => 'Land Rover',  'category' => 'luxury_suv', 'featured' => true],
            ['name' => 'Range Rover', 'category' => 'luxury_suv', 'featured' => true],
            ['name' => 'Cadillac',    'category' => 'luxury_suv', 'featured' => true],

            // Electric Luxury
            ['name' => 'Tesla', 'category' => 'electric_luxury', 'featured' => true],
            ['name' => 'Lucid', 'category' => 'electric_luxury', 'featured' => true],

            // Performance Brands
            ['name' => 'Alfa Romeo', 'category' => 'performance', 'featured' => false],
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'name'     => $brand['name'],
                'slug'     => str()->slug($brand['name']),
                'category' => $brand['category'],
                'featured' => $brand['featured'],
            ]);
        }
    }
}