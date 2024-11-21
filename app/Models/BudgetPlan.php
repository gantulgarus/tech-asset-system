<?php

namespace App\Models;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BudgetPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch_id',
        'year',
        'file_path',
    ];

    // Define relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}