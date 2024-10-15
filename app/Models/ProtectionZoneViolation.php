<?php

namespace App\Models;

use App\Models\Sum;
use App\Models\Branch;
use App\Models\Station;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProtectionZoneViolation extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'province_id',
        'sum_id',
        'station_id',
        'output_name',
        'customer_name',
        'address',
        'certificate_number',
        'action_taken',
    ];

    /**
     * Get the branch that owns the violation.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the province that owns the violation.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the sum that owns the violation.
     */
    public function sum()
    {
        return $this->belongsTo(Sum::class);
    }

    /**
     * Get the station that owns the violation.
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}