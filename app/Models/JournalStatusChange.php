<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class JournalStatusChange extends Model
{
    protected $fillable = ['status_id', 'order_journal_id', 'comment', 'changed_by'];

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}