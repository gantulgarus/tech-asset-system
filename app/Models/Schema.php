<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'station_id', 'image'];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}