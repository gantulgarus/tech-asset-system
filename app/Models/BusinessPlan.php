<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_type',
        'branch_id',
        'infrastructure_name',
        'task_name',
        'unit',
        'quantity',
        'budget_without_vat',
        'performance_amount',
        'variance_amount',
        'desc',
        'performance_percentage',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}