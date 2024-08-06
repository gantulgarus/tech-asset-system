<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerFailure extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'equipment_id',
        'failure_date',
        'detector_name',
        'failure_detail',
        'notified_name',
        'action_taken',
        'fixer_name',
        'inspector_name',
        'user_id'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}