<?php

namespace App\Models;

use App\Models\User;
use App\Models\Station;
use App\Models\CauseCut;
use App\Models\Equipment;
use App\Models\OrderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PowerCut extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'equipment_id',
        'cause_cut_id',
        'current_voltage',
        'current_amper',
        'current_power',
        'start_time',
        'end_time',
        'duration',
        'ude',
        'approved_by',
        'created_by',
        'user_id',
        'order_number',
        'order_type_id',
        'cause_cut'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function causeCut()
    {
        return $this->belongsTo(CauseCut::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }
}