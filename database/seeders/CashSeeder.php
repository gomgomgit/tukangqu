<?php

namespace Database\Seeders;

use App\Models\Cash;
use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');
        
        Cash::truncate();

        $daily = DailyProject::where('status', 'Finished')->where('process', 'finish')->get();
        $contract = ContractProject::where('status', 'Finished')->where('process', 'finish')->get();

        foreach ($daily as $daily) {
            Cash::create([
                'project_id' => $daily->id,
                'name' => 'profit '. $daily->client->name,
                'date' => $daily->finish_date,
                'category' => 'in',
                'money_in' => $daily->profit,
                'money_out' => 0,
                'description' => 'harian',
            ]);
        }
        foreach ($contract as $contract) {
            Cash::create([
                'project_id' => $contract->id,
                'name' => 'profit '. $contract->client->name,
                'date' => $contract->finish_date,
                'category' => 'in',
                'money_in' => $contract->profit,
                'money_out' => 0,
                'description' => 'borongan',
            ]);
        }

        $users = User::pluck('id');

        for ($i=0; $i < 15; $i++) { 
            $x = $faker->word;
            Cash::create([
                'name' => 'Biaya '. $x,
                'date' => $faker->dateTimeBetween('-3 month', '0 month'),
                'category' => 'out',
                'money_in' => 0,
                'money_out' => rand(10, 200) * 10000,
                'description' => 'Belanja ' . $x,
                'user_id' => $faker->randomElement($users),
            ]);
        };
    }
}
