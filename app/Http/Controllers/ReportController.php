<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ContractProject;
use App\Models\DailyProject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        $most_city = City::withCount(['dailyprojects', 'contractprojects', 'province'])->get();

        $most_city = $most_city->sortByDesc('countprojects');

        // $contract_projects = ContractProject::get(['client_id', 'kind_project', 'order_date', 'process']);
        // $daily_projects = DailyProject::get(['client_id', 'kind_project', 'order_date', 'process']);
        // $all_projects = $contract_projects->toBase()->merge($daily_projects);


		
        // for ($i=0; $i <= 4; $i++) { 
        //     $listmonth[] = Carbon::now()->subMonths($i)->format('F'); 
        //     $formatmonth = Carbon::now()->subMonths($i)->format('m');
        //     $listmonthProjects[] = (ContractProject::whereMonth('order_date', $formatmonth)->sum()) + (DailyProject::whereMonth('order_date', $formatmonth)->sum());
        // };


        return view('admin.report.index', compact(
            'most_city'
        ));
    }
}
