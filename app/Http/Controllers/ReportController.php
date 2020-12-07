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
        $now = Carbon::now()->format('yy-m-d');
        $surveyCount = ContractProject::where('survey_date', $now)->count();

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
        // dd($now);

        $projects = ContractProject::all()->count() + DailyProject::all()->count();
        $onprocess = ContractProject::where('status', 'OnProcess')->count() + DailyProject::where('status', 'OnProcess')->count();
        $onprogress = ContractProject::where('status', 'OnProgress')->count() + DailyProject::where('status', 'OnProgress')->count();

        return view('admin.report.index', compact(
            'surveyCount', 'most_city', 'projects', 'onprocess', 'onprogress'
        ));
    }

    public function todaySurvey() {
        $now = Carbon::now()->format('yy-m-d');

        $todaySurveys = ContractProject::where('survey_date', $now)->get();

        return view('admin.report.today-survey', compact('todaySurveys'));
    }


}
