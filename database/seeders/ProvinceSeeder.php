<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Province::create(['name' => 'Багануур', 'code' => 'БР']);
        Province::create(['name' => 'Дундговь', 'code' => 'ДУ']);
        Province::create(['name' => 'Дорноговь', 'code' => 'ДО']);
        Province::create(['name' => 'Хэнтий', 'code' => 'ХЭ']);
        Province::create(['name' => 'Говьсүмбэр', 'code' => 'ГО']);
    }
}
