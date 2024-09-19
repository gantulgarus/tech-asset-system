<?php

namespace App\Models;

use App\Models\Volt;
use App\Models\Branch;
use App\Models\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Station extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'branch_id', 'create_year', 'installed_capacity', 'desc', 'uuid', 'is_user_station'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function volts()
    {
        return $this->belongsToMany(Volt::class, 'station_volt');
    }

    public function schemas()
    {
        return $this->hasMany(Schema::class);
    }
}