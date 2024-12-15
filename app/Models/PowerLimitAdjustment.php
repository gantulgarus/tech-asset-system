<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PowerLimitAdjustment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'station_id',
        'output_name',
        'start_time',
        'end_time',
        'duration_minutes',
        'duration_hours',
        'voltage',
        'amper',
        'cosf',
        'power',
        'energy_not_supplied',
        'user_count',
    ];

    /**
     * Get the branch associated with the Power Limit Adjustment.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the station associated with the Power Limit Adjustment.
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}