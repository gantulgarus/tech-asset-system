<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientOrganization extends Model
{
    protected $fillable = ['name', 'branch_id', 'station_id', 'reduction_capacity', 'output_name'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }
}