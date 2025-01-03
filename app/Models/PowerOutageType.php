<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerOutageType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
}
