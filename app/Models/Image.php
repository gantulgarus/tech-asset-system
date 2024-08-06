<?php

namespace App\Models;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['equipment_id', 'file_path'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}