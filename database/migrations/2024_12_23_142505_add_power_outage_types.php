<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $powerOutageTypes = [
            'Анхдагч хэлхээний тоноглолын засварын ажил',
            'Аянгын улиралд бэлтгэл хангах ажил',
            'Өвлийн бэлтгэл хангах ажил',
            'РХА-ийн их ба урсгал засварын ажил',
            'Хэмжилт туршилтын ажил',
            'Ашиглалтын түвшин дээшлүүлэх ажил',
            'Борлуулалтын засварын ажил',
            'Ажлын байрны тохижилтоор хийх ажил',
            'Их засвар',
            'ТЗБАХ',
            'Хэрэглэгчийн',
        ];

        foreach ($powerOutageTypes as $type) {
            DB::table('outage_schedule_types')->insert([
                'name' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('outage_schedule_types')
            ->whereIn('name', [
                'Анхдагч хэлхээний тоноглолын засварын ажил',
                'Аянгын улиралд бэлтгэл хангах ажил',
                'Өвлийн бэлтгэл хангах ажил',
                'РХА-ийн их ба урсгал засварын ажил',
                'Хэмжилт туршилтын ажил',
                'Ашиглалтын түвшин дээшлүүлэх ажил',
                'Борлуулалтын засварын ажил',
                'Ажлын байрны тохижилтоор хийх ажил',
                'Их засвар',
                'ТЗБАХ',
                'Хэрэглэгчийн',
            ])
            ->delete();
    }
};