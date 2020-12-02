<?php

namespace Database\Seeders;

use App\Models\Cash;
use App\Models\ContractProject;
use App\Models\DailyProject;
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

        for ($i=0; $i < $daily->count(); $i++) { 
            Cash::create([
                'name' => 'profit harian ',
                'date' => $daily[$i]->finish_date,
                'category' => 'Profit harian',
                'money_in' => $daily[$i]->profit,
                'money_out' => 0,
                'description' => $daily[$i]->kind_project,
            ]);
        };

        for ($i=0; $i < $contract->count(); $i++) { 
            Cash::create([
                'name' => 'profit borongan ',
                'date' => $contract[$i]->finish_date,
                'category' => 'Profit borongan',
                'money_in' => $contract[$i]->profit,
                'money_out' => 0,
                'description' => $contract[$i]->kind_project,
            ]);
        };

        for ($i=0; $i < 10; $i++) { 
            $x = $faker->word;
            Cash::create([
                'name' => 'Biaya '. $x,
                'date' => $faker->date,
                'category' => 'Belanja Umum',
                'money_in' => 0,
                'money_out' => rand(10, 200) * 10000,
                'description' => 'Belanja ' . $x,
            ]);
        };
    }
}
