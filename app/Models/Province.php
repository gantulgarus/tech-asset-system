<?php

namespace App\Models;

use App\Models\UserTierResearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    /**
     * Get the user tier researches for the province.
     */
    public function userTierResearches()
    {
        return $this->hasMany(UserTierResearch::class);
    }
}
