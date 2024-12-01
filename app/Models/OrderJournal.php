<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\Station;
use App\Models\Equipment;
use App\Models\OrderType;
use App\Models\OrderStatus;
use App\Models\JournalStatusChange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderJournal extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'order_type_id',
        'order_number',
        'received_at',
        'station_id',
        'equipment_id',
        'content',
        'start_date',
        'end_date',
        'created_user_id',
        'received_user_id',
        'approved_user_id',
        'order_status_id',
        'real_start_date',
        'real_end_date',
        'approved_at',
        'canceled_at',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function orderType()
    {
        return $this->belongsTo(OrderType::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function approvedUser()
    {
        return $this->belongsTo(User::class);
    }

    public function receivedUser()
    {
        return $this->belongsTo(User::class);
    }

    public function statusChanges()
    {
        return $this->hasMany(JournalStatusChange::class);
    }
}