<?php

namespace App\Models;

use App\Models\Station;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Volt extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function stations()
    {
        return $this->belongsToMany(Station::class, 'station_volt');
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'equipment_volt');
    }
}
