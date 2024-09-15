<?php

namespace App\Models;

use App\Models\Sum;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTierResearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id',
        'username',
        'user_tier',
        'source_con_schema',
        'diesel_generator',
        'motor',
        'backup_power',
        'backup_status',
        'contact',
        'sum_id'
    ];

    /**
     * Get the province that owns the user tier research.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function sum()
    {
        return $this->belongsTo(Sum::class);
    }
}