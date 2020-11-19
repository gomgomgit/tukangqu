<?php

namespace App\Http\Controllers;

use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\Worker;
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
        $recent_workers = Worker::orderBy('created_at', 'desc')->take(5)->get();
        $schedules = ContractProject::where('process', 'scheduled')->take(5)->get();

        return view('admin.dashboard.dashboard', compact(
            'schedules', 'recent_workers'
        ));
    }
}
