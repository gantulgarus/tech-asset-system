<?php

namespace App\Models;

use App\Models\Volt;
use App\Models\Image;
use App\Models\Branch;
use App\Models\Station;
use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch_id',
        'station_id',
        'equipment_type_id',
        'mark',
        'production_date',
        'description'
    ];

    public function volts()
    {
        return $this->belongsToMany(Volt::class, 'equipment_volt')
            ->orderByRaw('CAST(name AS UNSIGNED) DESC');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}