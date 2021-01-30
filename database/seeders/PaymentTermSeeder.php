<?php

namespace Database\Seeders;

use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\PaymentTerm;
use Illuminate\Database\Seeder;

class PaymentTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        PaymentTerm::truncate();
        
        $contract_project = ContractProject::where('status', 'Onprogress')
                                            ->orWhere('status', 'Finished')
                                            ->where('process', 'deal')
                                            ->get(['id', 'project_value', 'start_date']);
        foreach ($contract_project as $project) {
            $percent = rand(2, 5) * 10 / 100;
            PaymentTerm::create([
                'project_id' => $project->id,
                'kind_project' => 'contract',
                'date' => date('Y-m-d', strtotime('+8 days')),
                'amount' => $project->project_value * $percent,
                'evidence' => ' ',
            ]);
            $percent = rand(2, 5) * 10 / 100;
            PaymentTerm::create([
                'project_id' => $project->id,
                'kind_project' => 'contract',
                'date' => date('Y-m-d', strtotime('+15 days')),
                'amount' => $project->project_value * $percent,
                'evidence' => ' ',
            ]);
        }
        
        $daily_project = DailyProject::where('status', 'Onprogress')
                                            ->where('process', 'deal')
                                            ->get(['id', 'daily_value', 'start_date']);
        foreach ($daily_project as $project) {
            PaymentTerm::create([
                'project_id' => $project->id,
                'kind_project' => 'daily',
                'date' => date('Y-m-d', strtotime('+2 days')),
                'amount' => $project->daily_value * 14,
                'evidence' => ' ',
            ]);
            PaymentTerm::create([
                'project_id' => $project->id,
                'kind_project' => 'daily',
                'date' => date('Y-m-d', strtotime('+4 days')),
                'amount' => $project->daily_value * 7,
                'evidence' => ' ',
            ]);
        }
    }
}
