<?php

namespace App\Models;

use App\Models\Volt;
use App\Models\Station;
use App\Models\PowerlineGeojson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Powerline extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'name',
        'volt_id',
        'create_year',
        'line_mark',
        'tower_mark',
        'tower_count',
        'line_length',
        'isolation_mark',
        'line_type',
        'muft_count'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function volt()
    {
        return $this->belongsTo(Volt::class);
    }

    public function geojson()
    {
        return $this->hasOne(PowerlineGeojson::class);
    }
}
