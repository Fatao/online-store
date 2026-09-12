<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            ['brand' => 'Ferrari',     'model' => '488 Pista',      'price' => 32500000, 'year' => 2023, 'hp' => 720, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Купе',        'color' => 'Россо Корса', 'mileage' => 1200],
            ['brand' => 'Lamborghini', 'model' => 'Huracán EVO',     'price' => 29800000, 'year' => 2023, 'hp' => 640, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Купе',        'color' => 'Жёлтый',      'mileage' => 800],
            ['brand' => 'Porsche',     'model' => '911 Turbo S',     'price' => 18900000, 'year' => 2024, 'hp' => 650, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Купе',        'color' => 'Чёрный',      'mileage' => 500],
            ['brand' => 'Rolls-Royce', 'model' => 'Phantom',         'price' => 65000000, 'year' => 2023, 'hp' => 571, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Седан',       'color' => 'Тёмно-синий', 'mileage' => 300],
            ['brand' => 'Bentley',     'model' => 'Continental GT',  'price' => 24500000, 'year' => 2023, 'hp' => 626, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Купе',        'color' => 'Серебристый', 'mileage' => 1100],
            ['brand' => 'Mercedes-Benz','model' => 'S-Class S680',  'price' => 21900000, 'year' => 2024, 'hp' => 612, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Седан',       'color' => 'Чёрный',      'mileage' => 200],
            ['brand' => 'BMW',         'model' => 'M8 Competition',  'price' => 16800000, 'year' => 2023, 'hp' => 625, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Купе',        'color' => 'Белый',       'mileage' => 1500],
            ['brand' => 'Audi',        'model' => 'RS Q8',           'price' => 17400000, 'year' => 2024, 'hp' => 600, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Внедорожник', 'color' => 'Серый',       'mileage' => 400],
            ['brand' => 'Aston Martin','model' => 'DBS Superleggera','price' => 31200000,'year' => 2023, 'hp' => 715, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Купе',        'color' => 'Зелёный',     'mileage' => 600],
            ['brand' => 'McLaren',     'model' => '720S',            'price' => 28900000, 'year' => 2023, 'hp' => 720, 'fuel' => 'Бензин', 'trans' => 'Автомат',  'body' => 'Купе',        'color' => 'Оранжевый',   'mileage' => 900],
            ['brand' => 'Bugatti',     'model' => 'Chiron',           'price' => 320000000,'year' => 2022, 'hp' => 1500,'fuel' => 'Бензин', 'trans' => 'Автомат', 'body' => 'Купе',        'color' => 'Голубой',     'mileage' => 100],
            ['brand' => 'Range Rover', 'model' => 'Autobiography',    'price' => 19500000, 'year' => 2024, 'hp' => 530, 'fuel' => 'Бензин', 'trans' => 'Автомат', 'body' => 'Внедорожник', 'color' => 'Чёрный',      'mileage' => 700],
            ['brand' => 'Tesla',       'model' => 'Model S Plaid',    'price' => 14200000, 'year' => 2024, 'hp' => 1020,'fuel' => 'Электро','trans' => 'Автомат', 'body' => 'Седан',       'color' => 'Белый',       'mileage' => 300],
            ['brand' => 'Lexus',       'model' => 'LC 500',            'price' => 13800000, 'year' => 2023, 'hp' => 471, 'fuel' => 'Бензин', 'trans' => 'Автомат', 'body' => 'Купе',        'color' => 'Красный',     'mileage' => 1300],
            ['brand' => 'Maserati',    'model' => 'MC20',               'price' => 26700000, 'year' => 2023, 'hp' => 630, 'fuel' => 'Бензин', 'trans' => 'Автомат', 'body' => 'Купе',        'color' => 'Синий',       'mileage' => 500],
            ['brand' => 'Cadillac',    'model' => 'Escalade Platinum', 'price' => 15600000,  'year' => 2024, 'hp' => 420, 'fuel' => 'Бензин', 'trans' => 'Автомат', 'body' => 'Внедорожник', 'color' => 'Чёрный',      'mileage' => 600],
        ];

        foreach ($cars as $c) {
            $brand = Brand::where('name', $c['brand'])->first();
            if (!$brand) continue;

            Car::create([
                'brand_id'     => $brand->id,
                'model'        => $c['model'],
                'name'         => $c['brand'] . ' ' . $c['model'],
                'price'        => $c['price'],
                'unit'         => 'шт.',
                'year'         => $c['year'],
                'mileage'      => $c['mileage'],
                'horsepower'   => $c['hp'],
                'fuel_type'    => $c['fuel'],
                'transmission' => $c['trans'],
                'body_type'    => $c['body'],
                'color'        => $c['color'],
                'description'  => "Эксклюзивный {$c['brand']} {$c['model']} {$c['year']} года выпуска. Безупречное состояние, полная история обслуживания.",
                'features'     => 'Кожаный салон, Климат-контроль, Навигация, Премиальная аудиосистема, Адаптивный круиз-контроль',
                'stock'        => 1,
                'is_active'    => true,
                'is_featured'  => true,
            ]);
        }
    }
}