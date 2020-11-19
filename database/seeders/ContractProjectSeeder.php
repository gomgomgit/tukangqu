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

        for ($i=0; $i < 72; $i++) { 
            $processSelect = array('waiting', 'scheduled', 'surveyed', 'deal', 'failed');
            $process = $faker->randomElement($processSelect);
            if ($process === 'deal') {
                $statuses = array('OnProgress', 'Finished');
                $status = $faker->randomElement($statuses);
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'survey_date' => $faker->date,
                    'survey_time' => $faker->time,
                    'surveyer_id' => $worker,
                    'approximate_value' => $approx = rand(15, 4200) * 100000,
                    'project_value' => $projectValue = $approx + (rand(5, 50) * 100000),
                    'worker_id' => $faker->randomElement($workers),
                    'start_date' => $start_date = $faker->dateTimeBetween('+1 week', '+1 month'),
                    'finish_date' => $faker->dateTimeBetween($start_date, '+3 month'),
                    'profit' => $projectValue * 5/100, 
                    'description' => $faker->sentence(8, true),
                    'process' => $process,
                    'status' => $status,
                ]);
            } elseif ($process === 'surveyed') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'survey_date' => $faker->date,
                    'survey_time' => $faker->time,
                    'surveyer_id' => $worker,
                    'approximate_value' => $approx = rand(15, 4200) * 100000,
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'scheduled') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'survey_date' => $faker->date,
                    'survey_time' => $faker->time,
                    'surveyer_id' => $worker,
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'waiting') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'OnProcess',
                ]);
            } elseif ($process === 'failed') {
                $worker = $faker->randomElement($workers);
                ContractProject::create([
                    'client_id' => $faker->randomElement($clients),
                    'order_date' => $faker->dateTimeBetween('-1 year', '-1 month'),
                    'address' => $faker->address,
                    'kind_project' => 'Renovasi Rumah',
                    'process' => $process,
                    'status' => 'Finished',
                ]);
            }
        } 
    }
}
