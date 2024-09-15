<?php

namespace Database\Seeders;

use App\Models\Sum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dundgovi = 2
        Sum::create([
            'province_id' => 2,
            'name' => 'Луус'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Хулд'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Дэлгэрцогт'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Эрдэнэдалай'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Гурвансайхан'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Дэлгэрхангай'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Адаацаг'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Өлзийт'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Цогт-Овоо'
        ]);
        Sum::create([
            'province_id' => 2,
            'name' => 'Дэрэн'
        ]);

        // Khentii = 4
        Sum::create([
            'province_id' => 4,
            'name' => 'Мөрөн'
        ]);
        Sum::create([
            'province_id' => 4,
            'name' => 'Дадал'
        ]);
        Sum::create([
            'province_id' => 4,
            'name' => 'Баян-Адарга'
        ]);
        Sum::create([
            'province_id' => 4,
            'name' => 'Батширээт'
        ]);
        Sum::create([
            'province_id' => 4,
            'name' => 'Биндэр'
        ]);
        Sum::create([
            'province_id' => 4,
            'name' => 'Бэрх'
        ]);
        Sum::create([
            'province_id' => 4,
            'name' => 'Өмнөдэлгэр'
        ]);
        Sum::create([
            'province_id' => 4,
            'name' => 'Түмэнцогт'
        ]);

        // Govisumber = 5
        Sum::create([
            'province_id' => 5,
            'name' => 'Сүмбэр'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Шивээговь'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Баянтал'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Бор-Өндөр'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Дархан'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Цагаандэлгэр'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Говь-Угтаал'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Баянжаргалан'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Өндөршил'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Иххэт'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Даланжаргалан'
        ]);
        Sum::create([
            'province_id' => 5,
            'name' => 'Айраг'
        ]);
    }
}