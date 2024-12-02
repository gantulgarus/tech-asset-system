<?php

namespace App\Models;

use App\Models\Volt;
use App\Models\Branch;
use App\Models\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Station extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'branch_id', 'create_year', 'installed_capacity', 'desc', 'uuid', 'is_user_station', 'station_type', 'station_category'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }

    // public function toSearchableArray()
    // {
    //     $array = $this->toArray();

    //     return [
    //         'name' => $array['name'],
    //         'branch_id' => $array['branch_id'],
    //         'create_year' => $array['create_year'],
    //         'installed_capacity' => $array['installed_capacity'],
    //         'desc' => $array['desc'],
    //         'is_user_station' => $array['is_user_station']
    //     ];
    // }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function volts()
    {
        return $this->belongsToMany(Volt::class, 'station_volt')
            ->orderByRaw('CAST(name AS UNSIGNED) DESC');
    }

    public function schemas()
    {
        return $this->hasMany(Schema::class);
    }
}