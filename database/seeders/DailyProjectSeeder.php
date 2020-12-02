<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\DailyProject;
use App\Models\Worker;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DailyProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DailyProject::truncate();

        $faker = Factory::create('id_ID');
        $workers = Worker::pluck('id');
        $clients = Client::pluck('id');

        $provinces = \Indonesia::allProvinces()->pluck('id')->toArray();
        $cities = \Indonesia::allCities()->pluck('province_id', 'id')->toArray();

        for ($i=0; $i < 72; $i++) { 

            $province = $provinces[array_rand($provinces,1)];
            $city = array_rand(array_filter($cities, function ($n) use($province) {
                return $n == $province;
            }));

            $daily = rand(12, 17) * 10000;
            $processSelect = array('waiting', 'priced', 'deal', 'finish', 'failed');
            $process = $faker->randomElement($processSelect);
            if ($process === 'finish') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '0 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'daily_value' => $daily,
                    'worker_id' => $faker->randomElement($workers),
                    'daily_salary' => $dailySalary = $daily - (rand(2, 5) * 10000),
                    'start_date' => $start_date = $faker->dateTimeBetween('+1 week', '+1 month'),
                    'finish_date' => $faker->dateTimeBetween($start_date, '+3 month'),
                    'project_value' => $daily * rand(3, 21),
                    'profit' => ($daily - $dailySalary) * rand(7, 34), 
                    'description' => $faker->sentence(8, true),
                    'process' => $process,
                    'status' => 'Finished',
                ]);
            } elseif ($process === 'deal') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'daily_value' => $daily,
                    'worker_id' => $faker->randomElement($workers),
                    'daily_salary' => $dailySalary = $daily - (rand(2, 5) * 10000),
                    'start_date' => $start_date = $faker->dateTimeBetween('+1 week', '+1 month'),
                    'description' => $faker->sentence(8, true),
                    'process' => $process,
                    'status' => 'OnProgress',
                ]);
            } elseif ($process === 'priced') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'daily_value' => $daily,
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'failed') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'Finished',
                ]);
            } elseif ($process === 'waiting') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            }
        }  
        
    }
}
