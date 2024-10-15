<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WorkTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('work_types')->insert([
            ['name' => 'Их засвар', 'description' => ''],
            ['name' => 'ТЗБАХ', 'description' => ''],
            ['name' => 'Урсгал засвар', 'description' => ''],
            ['name' => 'Хэмжилт, туршилт', 'description' => ''],
        ]);
    }
}