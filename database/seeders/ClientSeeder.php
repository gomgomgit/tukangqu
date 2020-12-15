<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::truncate();

        $faker = Factory::create('id_ID');

        $provinces = \Indonesia::allProvinces()->pluck('id')->toArray();
        $cities = \Indonesia::allCities()->pluck('province_id', 'id')->toArray();

        for ($i=0; $i < 22; $i++) { 
            $province = $provinces[array_rand($provinces,1)];
            $city = array_rand(array_filter($cities, function ($n) use($province) {
                return $n == $province;
            }));

            Client::create([
                'name' => $faker->firstName,
                'phone_number' => $faker->phoneNumber, 
                'address' => $faker->streetAddress,
                'province_id' => $province,
                'city_id' => $city,
            ]);
        }
    }
}
