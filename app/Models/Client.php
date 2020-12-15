<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name', 'phone_number', 'address', 'province_id', 'city_id'
    ];

    public function getCityAttribute() {
        $data = \Indonesia::findCity($this->city_id, 'province');
        $city = Str::ucfirst(Str::lower($data->name));
        $province = Str::ucfirst(Str::lower($data->province->name));
        return $city . ', '. $province;
    }

    public function getProjectsCountAttribute() {
        $contract = ContractProject::where('client_id', $this->id)->count();
        $daily = DailyProject::where('client_id', $this->id)->count();
        return $contract + $daily;
    }

    public function contractProjects() {
        $this->hasMany(ContractProject::class, 'client_id');
    }
    public function dailyProjects() {
        $this->hasMany(DailyProject::class, 'client_id');
    }
}
