<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'indonesia_cities';

    public function dailyprojects()
    {
        return $this->hasMany(DailyProject::class, 'city_id');
    }

    public function contractprojects()
    {
        return $this->hasMany(ContractProject::class, 'city_id');
    }

    public function province()
    {
        return $this->belongsTo('Laravolt\Indonesia\Models\Province', 'province_id');
    }

    public function getCountProjectsAttribute()
    {
        return $this->dailyprojects_count + $this->contractprojects_count;
    }
}
