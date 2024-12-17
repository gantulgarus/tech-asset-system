<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Station;
use App\Models\ClientOrganization;
use Illuminate\Database\Eloquent\Model;

class LoadReductionProgram extends Model
{
    protected $table = 'load_reduction_programs';

    // Fillable attributes
    protected $fillable = [
        'branch_id',
        'station_id',
        'client_organization_id',
        'company_name',
        'output_name',
        'reduction_capacity',
        'pre_reduction_capacity',
        'reduction_time',
        'reduced_capacity',
        'post_reduction_capacity',
        'restoration_time',
        'energy_not_supplied',
        'remarks',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
    public function clientOrganization()
    {
        return $this->belongsTo(ClientOrganization::class);
    }
}