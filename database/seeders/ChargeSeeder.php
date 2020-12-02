<?php

namespace Database\Seeders;

use App\Models\Charge;
use App\Models\ContractProject;
use App\Models\DailyProject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Charge::truncate();
        
        $contract_project = ContractProject::where('status', 'Onprogress')
                                            ->orWhere('status', 'Finished')
                                            ->where('process', 'deal')
                                            ->get(['id', 'project_value', 'start_date']);
        
        foreach ($contract_project as $project) {
            $percent = rand(1, 3) * 10 / 100;
            Charge::create([
                'project_id' => $project->id,
                'kind_project' => 'contract',
                'date' => date('Y-m-d', strtotime('+8 days')),
                'amount' => $project->project_value * $percent,
                'description' => 'Uang Makan 1'
            ]);
            $percent = rand(1, 4) * 10 / 100;
            Charge::create([
                'project_id' => $project->id,
                'kind_project' => 'contract',
                'date' => date('Y-m-d', strtotime('+15 days')),
                'amount' => $project->project_value * $percent,
                'description' => 'Uang Makan 2'
            ]);
        };

        $daily_project = DailyProject::where('status', 'Onprogress')
                                            ->orWhere('status', 'Finished')
                                            ->where('process', 'deal')
                                            ->get(['id', 'daily_value', 'start_date']);

        foreach ($daily_project as $project) {
            Charge::create([
                'project_id' => $project->id,
                'kind_project' => 'daily',
                'date' => date('Y-m-d', strtotime('+1 days')),
                'amount' => $project->daily_value * 20 / 100,
                'description' => 'Uang Makan 1'
            ]);
            Charge::create([
                'project_id' => $project->id,
                'kind_project' => 'daily',
                'date' => date('Y-m-d', strtotime('+3 days')),
                'amount' => $project->daily_value * 60 / 100,
                'description' => 'Uang Makan 2'
            ]);
        };
    }
}
