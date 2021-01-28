<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Models\City;
use App\Models\ContractProject;
use App\Models\DailyProject;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        $now = Carbon::now()->format('Y-m-d');
        $surveyCount = ContractProject::where('survey_date', $now)->count();

        $most_city = City::withCount(['dailyprojects', 'contractprojects', 'province'])->get();

        $most_city = $most_city->sortByDesc('countprojects');

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $month_income = (Cash::whereYear('date', $year)->whereMonth('date', $month)->sum('money_in'));
        $month_outcome = (Cash::whereYear('date', $year)->whereMonth('date', $month)->sum('money_out'));

        $in = Cash::where('category', 'in')->sum('money_in');
        $out = Cash::whereIn('category', ['out', 'pay', 'refund'])->sum('money_out');

        $total_cash = $in - $out;

        $projects = ContractProject::all()->count() + DailyProject::all()->count();
        $onprocess = ContractProject::where('status', 'OnProcess')->count() + DailyProject::where('status', 'OnProcess')->count();
        $onprogress = ContractProject::where('status', 'OnProgress')->count() + DailyProject::where('status', 'OnProgress')->count();

        return view('admin.report.index', compact(
            'surveyCount', 'most_city', 'projects', 'onprocess', 'onprogress', 'month_income', 'month_outcome', 'total_cash'
        ));
    }

    public function todaySurvey() {
        $now = Carbon::now()->format('Y-m-d');

        $todaySurveys = ContractProject::where('survey_date', $now)->get();

        return view('admin.report.today-survey', compact('todaySurveys'));
    }

    public function viewProjects($id) 
    {
        $contract = ContractProject::where('city_id', $id)->orderBy('order_date', 'desc')
            ->get(['id', 'address', 'city_id', 'order_date', 'kind_project', 'project_value', 'profit', 'status', 'description']);
        $daily = DailyProject::where('city_id', $id)->orderBy('order_date', 'desc')
            ->get(['id', 'address', 'city_id', 'order_date', 'kind_project', 'project_value', 'profit', 'status', 'description']);
        $datas = $contract->toBase()->merge($daily)->take(10);

        $city = City::where('id', $id)->first();

        return view('admin.report.view-projects', compact('datas', 'city'));
    }


}
