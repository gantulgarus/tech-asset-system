<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\OutageScheduleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutageSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'substation_line_equipment',
        'task',
        'start_date',
        'end_date',
        'type',
        'affected_users',
        'responsible_officer',
        'created_user',
        'controlled_user',
        'approved_user',
        'outage_schedule_type_id'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function outageScheduleType()
    {
        return $this->belongsTo(OutageScheduleType::class);
    }
}