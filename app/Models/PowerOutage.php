<?php

namespace App\Models;

use App\Models\User;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\Protection;
use App\Models\CauseOutage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PowerOutage extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'equipment_id',
        'protection_id',
        'start_time',
        'end_time',
        'duration',
        'weather',
        'cause_outage_id',
        'current_voltage',
        'current_amper',
        'cosf',
        'ude',
        'user_id'
    ];

    // Define relationships (if applicable)
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function protection()
    {
        return $this->belongsTo(Protection::class);
    }

    public function causeOutage()
    {
        return $this->belongsTo(CauseOutage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
