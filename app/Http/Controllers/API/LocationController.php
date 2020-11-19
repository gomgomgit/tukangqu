<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function provinces() {
        return \Indonesia::allProvinces();
    }

    public function cities($province_id) {
        // return \Indonesia::allCities();
        $provinces = \Indonesia::findProvince($province_id, 'cities');
        return $provinces->cities;
    }

    public function districts($city_id) {
        // return \Indonesia::allDistricts();
        $cities = \Indonesia::findCity($city_id, 'districts');
        return $cities->districts;
    }

    public function villages($district_id) {
        // return \Indonesia::allVillages();
        $districts = \Indonesia::findDistrict($district_id, 'villages');
        return $districts->villages;
    }
}
