<?php

namespace Database\Seeders;

use App\Models\OrderType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderTypes = [
            'Төлөвлөгөөт',
            'Төлөвлөгөөт бус',
            'Аваарын',
            'Хэрэглэгчийн',
        ];

        foreach ($orderTypes as $type) {
            OrderType::create(['name' => $type]);
        }
    }
}
