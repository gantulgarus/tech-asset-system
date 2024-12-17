<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Station;
use Illuminate\Database\Eloquent\Model;

class ClientRestriction extends Model
{
    protected $fillable = ['branch_id', 'station_id', 'output_name'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }
}