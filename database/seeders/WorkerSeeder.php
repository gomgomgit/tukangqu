<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Worker;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Worker::truncate();
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public/assets/images');

        $faker = Factory::create('id_ID');
        $provinces = \Indonesia::allProvinces()->pluck('id')->toArray();
        $cities = \Indonesia::allCities()->pluck('province_id', 'id')->toArray();
        $districts = \Indonesia::allDistricts()->pluck('city_id', 'id')->toArray();
        $villages = \Indonesia::allVillages()->pluck('district_id', 'id')->toArray();
        $kinds = DB::table('worker_kinds')->pluck('id')->toArray();
        $specialists = DB::table('specialists')->pluck('id')->toArray();

        for ($i=0; $i < 100 ; $i++) {
            $province = $provinces[array_rand($provinces,1)];
            $city = array_rand(array_filter($cities, function ($n) use($province) {
                return $n == $province;
            }));
            // print_r($districts);    
            // print_r($city);    

            $district = array_rand(array_filter($districts, function ($n) use($city) {
                return $n == $city;
            }));
            $village = array_rand(array_filter($villages, function ($n) use($district) {
                return $n == $district;
            }));
            $kind = $kinds[array_rand($kinds, 1)];
            $specialist = $specialists[array_rand($specialists, 1)];
            $name = $faker->name;
            $workerId = Worker::create([
                'name' => $name,
                'birth_place' => $faker->city,
                'birth_date' => $faker->date,
                'email' => $name . '@email.com',
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->streetAddress,
                'rt' => rand(1, 9),
                'rw' => rand(1, 19),
                'province_id' => $province,
                'city_id' => $city,
                'district_id' => $district,
                'village_id' => $village,
                'worker_kind_id' => $kind,
                'specialist_id' => $specialist,
                'experience' => rand(1, 7) . ' Tahun',
                'self_photo' => $name . '-photo.jpg',
                'id_card_photo' => $name . '-idcard.jpg',
            ]);

            $skills = Skill::pluck('id')->toArray();
            $skills = array_rand($skills, 3);
            $workerId->skills()->sync($skills);
        }
    }
}
