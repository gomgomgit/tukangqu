<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Client;
use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\Worker;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function onProcess($kind = 'borongan')
    {
        // $daily_datas = DailyProject::with('client')
        // ->where('status', 'OnProcess')->orderBy('created_at', 'desc')->get();
        $daily_datas = DailyProject::with('client')->where('status', 'OnProcess')
        ->orderByRaw("FIELD(process, \"waiting\", \"priced\", \"deal\", \"failed\")")
        ->orderBy('created_at', 'desc')->get();
        $contract_datas = ContractProject::where('status', 'OnProcess')
            ->with('client', 'surveyer')
            ->orderByRaw("FIELD(process, \"waiting\", \"scheduled\", \"surveyed\", \"deal\", \"failed\")")
            ->orderBy('created_at', 'desc')->get();
        $workers = Worker::all();
        // $workers = Worker::groupBy('city_id')->having()->get();
        // dd($workers);
        return view('admin.projects.on-process', compact('daily_datas', 'contract_datas', 'kind', 'workers'));
    }
    public function scheduling(Request $request, $id, $kind = 'borongan') {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
            $data->process = 'scheduled';
            $data->survey_date = $request->survey_date;
            $data->survey_time = $request->survey_time;
            $data->surveyer_id = $request->surveyer_id;
            $data->save();
        }
        return redirect()->route('admin.projects.onProcess', $kind);
    }
    public function pricing(Request $request, $id, $kind = 'borongan') {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
            $data->process = 'surveyed';
            $data->approximate_value = $request->approximate_value;
            $data->save();
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
            $data->process = 'priced';
            $data->daily_value = $request->daily_value;
            $data->save();
        }
        return redirect()->route('admin.projects.onProcess', $kind);
    }
    public function dealing($id, $kind = 'borongan') {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
            $workers = Worker::all();

            return view('admin.projects.dealing-contract', compact('data', 'workers'));
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
            $workers = Worker::all();
            
            return view('admin.projects.dealing-daily', compact('data', 'workers'));
        }
    }
    public function deal(Request $request, $id, $kind = 'borongan') {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
            $data->status = 'OnProgress';
            $data->project_value = $request->project_value;
            $data->worker_id = $request->worker_id;
            $data->start_date = $request->start_date;
            $data->save();
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
            $data->status = 'OnProgress';
            $data->daily_salary = $request->daily_salary;
            $data->worker_id = $request->worker_id;
            $data->start_date = $request->start_date;
            $data->save();
        }
        return redirect()->route('admin.projects.onProgress', $kind);
    }
    public function failed($id, $kind = 'borongan') {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
        }
        $data->status = 'Finished';
        $data->process = 'failed';
        $data->save();

        return redirect()->route('admin.projects.finished', $kind);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function onProgress($kind = 'borongan')
    {
        $daily_datas = DailyProject::with('client', 'worker')
            ->where('status', 'OnProgress')
            ->orderBy('updated_at', 'desc')->get();
        $contract_datas = ContractProject::where('status', 'OnProgress')
            ->with('client', 'worker')
            ->orderBy('created_at', 'desc')->get();
        // dd($contract_datas->first());

        return view('admin.projects.on-progress', compact('daily_datas', 'contract_datas', 'kind'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished()
    {
        $daily_datas = DailyProject::with('client', 'worker')
            ->where('status', 'Finished')->orderBy('created_at', 'desc')->get();
        $contract_datas = ContractProject::where('status', 'Finished')
            ->with('client', 'worker')
            ->orderBy('created_at', 'desc')->get();
        // dd($contract_datas->first());

        return view('admin.projects.finished', compact('daily_datas', 'contract_datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->all();
        
        $client_id = Client::create($data)->id;
        
        // array_push( $data, ['client_id' => $client_id]);
        $data['client_id'] = $client_id;
        // dd($data);
        $kind = $data['kind_work'];
        if ($kind === 'borongan') {
            ContractProject::create($data);
        }; 
        if ($kind === 'harian') {
            DailyProject::create($data);
        };

        return redirect()->route('admin.projects.onProcess', $kind);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function onProcessShow($id, $kind)
    {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
        }
        return view('admin.projects.on-process-show', compact('data', 'kind'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $kind = 'borongan')
    {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
        }
        $data->delete();

        return redirect()->back();
    }
}
