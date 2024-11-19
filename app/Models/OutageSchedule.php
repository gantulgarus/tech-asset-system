<?php

namespace App\Models;

use App\Models\Branch;
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
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
