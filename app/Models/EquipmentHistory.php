<?php

namespace App\Models;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EquipmentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'work_type',
        'task_date',
        'completed_task',
        'team_members',
    ];

    // Relationship with Equipment
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}