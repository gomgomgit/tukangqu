<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ContractProject;
use App\Models\Worker;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContractProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractProject::truncate();

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

            $processSelect = array('waiting', 'scheduled', 'surveyed', 'deal', 'done', 'finish', 'failed');
            $process = $faker->randomElement($processSelect);
            if ($process === 'finish' ) {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-7 month', '-4 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'survey_date' => $faker->date,
                    'survey_time' => $faker->time,
                    'surveyer_id' => $worker,
                    'approximate_value' => $approx = rand(20, 30) * 1000000,
                    'project_value' => $projectValue = $approx + (rand(1, 5) * 1000000),
                    'worker_id' => $faker->randomElement($workers),
                    'start_date' => $start_date = $faker->dateTimeBetween('-5 month', '-3 month'), 
                    'finish_date' => $faker->dateTimeBetween($start_date, '0 month'),
                    'profit' => $projectValue * 5/100, 
                    'description' => $faker->sentence(8, true),
                    'process' => $process,
                    'status' => 'Finished',
                ]);
            } elseif ($process === 'deal' || $process === 'done') {
                $worker = $faker->randomElement($workers);
                $start_date = $faker->dateTimeBetween('-2 month', '-1 week');

                $approx = rand(20, 30) * 1000000;
                $projectValue = $approx + (rand(1, 5) * 1000000);
                if ($process === 'done') {
                    $finish_date = $faker->dateTimeBetween($start_date, '0 week');
                    $profit = $projectValue * 5/100;
                } else {
                    $finish_date = NULL;
                    $profit = 0;
                }
                
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-5 month', '-1 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'survey_date' => $faker->date,
                    'survey_time' => $faker->time,
                    'surveyer_id' => $worker,
                    'approximate_value' => $approx,
                    'project_value' => $projectValue,
                    'worker_id' => $faker->randomElement($workers),
                    'start_date' => $start_date, 
                    'finish_date' => $finish_date,
                    'profit' => $profit, 
                    'description' => $faker->sentence(8, true),
                    'process' => $process,
                    'status' => 'OnProgress',
                ]);
            } elseif ($process === 'surveyed') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-5 week', '-2 week'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'survey_date' => $faker->date,
                    'survey_time' => $faker->time,
                    'surveyer_id' => $worker,
                    'approximate_value' => $approx = rand(20, 30) * 1000000,
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'scheduled') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 month', '-1 week'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'survey_date' => $faker->dateTimeBetween('0 week', '+1 week'),
                    'survey_time' => $faker->time,
                    'surveyer_id' => $worker,
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'waiting') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-3 week', '0 week'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'failed') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->streetAddress,
                    'province_id' => $province,
                    'city_id' => $city,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'Finished',
                ]);
            }
        } 
    }
}
