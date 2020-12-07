<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Worker extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name', 'birth_place', 'birth_date', 'email', 'phone_number', 'address', 'rt', 'rw', 
        'province_id', 'city_id', 'district_id', 'village_id', 'worker_kind_id', 'specialist_id', 
        'experience', 'self_photo', 'id_card_photo',    
    ];
    
    public function getFullAddressAttribute() {
        // return \Indonesia::findVillage($this->village_id, 'district.city.province');
        $data = \Indonesia::findVillage($this->village_id, 'district.city.province');
        $village = Str::lower($data->name);
        $district = Str::lower($data->district->name);
        $city = Str::lower($data->district->city->name);
        $province = Str::lower($data->district->city->province->name);
        return $this->address . ' Rt.'.$this->rt .' Rw.'.$this->rw . ', '.$village.', '.$district.', '.$city.', '.$province ;
    }

    public function getDomicileAttribute() {
        $data = \Indonesia::findCity($this->city_id, 'province');
        $city = Str::ucfirst(Str::lower($data->name));
        $province = Str::ucfirst(Str::lower($data->province->name));
        return $city . ', '. $province;
    }

    public function getBirthInfoAttribute() {
        $birth_info = $this->birth_place . ', ' . date('d-M-Y', strtotime($this->birth_date));
        return $birth_info;
    }

    public function contractProjects() {
        return $this->hasMany(ContractProject::class, 'worker_id');
    }
    public function dailyProjects() {
        return $this->hasMany(DailyProject::class, 'worker_id');
    }

    public function workerKind() {
        return $this->belongsTo(WorkerKind::class, 'worker_kind_id', 'id');
    }

    public function specialist() {
        return $this->belongsTo(Specialist::class, 'specialist_id', 'id');
    }

    public function skills() {
        return $this->belongsToMany(Skill::class, 'skill_worker', 'worker_id', 'skill_id');
    }

    public function getProjectDoneAttribute() {
        $dailydone = DailyProject::withTrashed()->where('worker_id', $this->id)->count();
        $contractdone = ContractProject::withTrashed()->where('worker_id', $this->id)->count();
        return $dailydone + $contractdone;
    }
    
}
