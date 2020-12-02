<?php

namespace App\Http\Controllers;

use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workers = Worker::all();
        // $contract_projects_month = ContractProject::where('created_at', '3')->get();
        // $daily_projects_month = DailyProject::where('created_at', '3')->get();

        $contract_projects = ContractProject::get(['client_id', 'kind_project', 'order_date', 'process']);
        $daily_projects = DailyProject::get(['client_id', 'kind_project', 'order_date', 'process']);
        $recent_projects = $contract_projects->toBase()->merge($daily_projects)->take(10);

        $month = Carbon::now()->month;
        $month_project = (ContractProject::whereMonth('order_date', $month)->count()) + (DailyProject::whereMonth('order_date', $month)->count());
        // $month_project = $all_projects->whereMonth('order_date', $month)->count();

        // dd($recent_projects->first());
        $recent_workers = Worker::orderBy('created_at', 'desc')->take(5)->get();
        $schedules = ContractProject::where('process', 'scheduled')->take(5)->get();


        return view('admin.dashboard.dashboard', compact(
            'schedules', 'workers', 'month_project', 'recent_workers', 'recent_projects'
        ));
    }
}
