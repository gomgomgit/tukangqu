<?php

namespace Database\Seeders;

use App\Models\DailyProject;
use App\Models\Profit;
use Illuminate\Database\Seeder;

class ProfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profit::truncate();

        $daily_project = DailyProject::where('status', 'Onprogress')
                                            ->where('process', 'deal')
                                            ->get(['id', 'daily_value', 'daily_salary', 'start_date']);
        foreach ($daily_project as $project) {
            Profit::create([
                'project_id' => $project->id,
                'kind_project' => 'daily',
                'date' => date('Y-m-d', strtotime('+7 days')),
                'amount_worker' => $worker = $project->daily_salary * 7,
                'amount_cash' => $cash = ($project->daily_value - $project->daily_salary) * 7,
                'amount_total' => $cash + $worker,
            ]);
            Profit::create([
                'project_id' => $project->id,
                'kind_project' => 'daily',
                'date' => date('Y-m-d', strtotime('+14 days')),
                'amount_worker' => $worker = $project->daily_salary * 6,
                'amount_cash' => $cash = ($project->daily_value - $project->daily_salary) * 6,
                'amount_total' => $cash + $worker,
            ]);
        }

    }
}
