<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\DailyProject;
use App\Models\Worker;
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

        for ($i=0; $i < 72; $i++) { 
            $daily = rand(12, 17) * 10000;
            $processSelect = array('waiting', 'priced', 'deal', 'failed');
            $process = $faker->randomElement($processSelect);
            if ($process === 'deal') {
                $statuses = array('OnProgress', 'Finished');
                $status = $faker->randomElement($statuses);
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'daily_value' => $daily,
                    'worker_id' => $faker->randomElement($workers),
                    'daily_salary' => $dailySalary = $daily - (rand(2, 4) * 10000),
                    'finish_date' => $finishDate = $faker->date,
                    'start_date' => $faker->date('Y-m-d', $finishDate),
                    'project_value' => $daily * rand(3, 21),
                    'profit' => $daily - $dailySalary, 
                    'description' => $faker->sentence(8, true),
                    'process' => $process,
                    'status' => $status,
                ]);
            } elseif ($process === 'priced') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'daily_value' => $daily,
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'failed') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'Finished',
                ]);
            } elseif ($process === 'waiting') {
                DailyProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            }
        }  
        
    }
}
