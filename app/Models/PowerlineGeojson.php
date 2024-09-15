<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PowerlineGeojson extends Model
{
    use HasFactory;

    protected $fillable = [
        'powerline_id',
        'filename',
        'path',
    ];

    public function powerline()
    {
        return $this->belongsTo(Powerline::class);
    }
}