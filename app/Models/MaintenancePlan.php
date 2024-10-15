<?php

namespace App\Models;

use App\Models\WorkType;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenancePlan extends Model
{
    use HasFactory;

    protected $fillable = ['equipment_id', 'year', 'work_type_id'];

    // Relationships
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }
}