<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Cash;
use App\Models\Charge;
use App\Models\Client;
use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\PaymentTerm;
use App\Models\Profit;
use App\Models\Worker;
use Carbon\Carbon;
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
        // dd(date('D, d-m-y H-i'));
        // $daily_datas = DailyProject::with('client')
        // ->where('status', 'OnProcess')->orderBy('created_at', 'desc')->get();
        $daily_datas = DailyProject::with('client')->where('status', 'OnProcess')
        ->orderBy('process')
        ->orderBy('order_date', 'desc')->get();
        $contract_datas = ContractProject::where('status', 'OnProcess')
            ->with('client', 'surveyer')
            ->orderBy('process')
            ->orderBy('order_date', 'desc')->get();
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
            $data->process = 'deal';
            $data->project_value = $request->project_value;
            $data->worker_id = $request->worker_id;
            $data->start_date = $request->start_date;
            $data->save();
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
            $data->status = 'OnProgress';
            $data->process = 'deal';
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
        // $now = Carbon::now();
        // dd($now);
        $daily_datas = DailyProject::with('client', 'worker')
            ->where('status', 'OnProgress')
            ->orderBy('process')
            ->orderBy('start_date', 'desc')->get();
            // dd($daily_datas->first()->chargeweek);
        $contract_datas = ContractProject::where('status', 'OnProgress')
            ->with('client', 'worker')
            ->orderBy('process')
            ->orderBy('start_date', 'desc')->get();
        // dd(Profit::where('project_id', 20)->where('kind_project', 'daily')->sum('amount_total'));

        return view('admin.projects.on-progress', compact('daily_datas', 'contract_datas', 'kind'));
    }
    
    public function addBilling(Request $request, $projectId, $kind = 'borongan') {
        if ($kind ==='borongan') {
            Charge::create([
                'project_id' => $projectId,
                'kind_project' => 'contract',
                'date' => $request->date,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
        }
        if ($kind ==='harian') {
            Charge::create([
                'project_id' => $projectId,
                'kind_project' => 'daily',
                'date' => $request->date,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);
        }

        return redirect()->route('admin.projects.onProgress', $kind);
    }
    
    public function addTermin(Request $request, $projectId, $kind = 'borongan') {
        if ($kind ==='borongan') {
            PaymentTerm::create([
                'project_id' => $projectId,
                'kind_project' => 'contract',
                'date' => $request->date,
                'amount' => $request->amount,
            ]);
        }
        if ($kind ==='harian') {
            PaymentTerm::create([
                'project_id' => $projectId,
                'kind_project' => 'daily',
                'date' => $request->date,
                'amount' => $request->amount,
            ]);
        }

        return redirect()->route('admin.projects.onProgress', $kind);
    }
    
    public function addProfit(Request $request, $projectId, $kind = 'borongan') {
        if ($kind ==='borongan') {
            Profit::create([
                'project_id' => $projectId,
                'kind_project' => 'contract',
                'date' => $request->date,
                'amount_cash' => $cash = $request->amount_cash,
                'amount_worker' => $worker = $request->amount_worker,
                'amount_total' => $cash + $worker,
            ]);
        }
        if ($kind ==='harian') {
            Profit::create([
                'project_id' => $projectId,
                'kind_project' => 'daily',
                'date' => $request->date,
                'amount_cash' => $cash = $request->amount_cash,
                'amount_worker' => $worker = $request->amount_worker,
                'amount_total' => $cash + $worker, 
            ]);
        }

        return redirect()->route('admin.projects.onProgress', $kind);
    }

    public function done(Request $request, $id, $kind = 'borongan') {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
        }
        $data->finish_date = $request->finish_date;
        $data->process = 'done';
        // dd($data);
        $data->save();

        return redirect()->route('admin.projects.onProgress', $kind);
    }

    public function finish($id, $kind = 'borongan') {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
            $data->profit = $data->totalprofit;
            $data->process = 'finish';
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
            $data->profit = $data->totalprofit;
            $data->finish_date = Carbon::now()->format('y-m-d');
            $data->process = 'finish';
        }
        // dd($data);
        $data->status = 'Finished';
        Cash::create([
            'project_id' => $id,
            'name' => $data->client->name,
            'date' => Carbon::now()->format('Y-m-d'),
            'category' => 'in',
            'money_in' => $data->totalprofit,
            'description' => $kind,
        ]);
        $data->save();

        return redirect()->route('admin.projects.finished', $kind);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function finished($kind = 'borongan')
    {
        $daily_datas = DailyProject::with('client', 'worker')
            ->where('status', 'Finished')
            ->orderBy('finish_date', 'desc')->get();
        $contract_datas = ContractProject::where('status', 'Finished')
            ->with('client', 'worker')
            ->orderBy('finish_date', 'desc')->get();
        // dd($contract_datas->first());

        return view('admin.projects.finished', compact('daily_datas', 'contract_datas', 'kind'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        return view('admin.projects.create', compact('clients'));
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

        // dd($request->name_old_client);
        if ($request->client == 1) {
            $client_id = Client::create([
                'name' => $request->name_new_client,
                'phone_number' => $request->phone_number,
                'address' => $request->client_address,
                'province_id' => $request->client_province_id,
                'city_id' => $request->client_city_id,
            ])->id;
        } else {
            $client_id = $request->name_old_client;
        }
            
            // dd($request);
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
            // dd($data);
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
        }
        return view('admin.projects.on-process-show', compact('data', 'kind'));
    }

    public function onProgressShow($id, $kind)
    {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
        }
        return view('admin.projects.on-progress-show', compact('data', 'kind'));
    }

    public function finishedShow($id, $kind)
    {
        if ($kind ==='borongan') {
            $data = ContractProject::find($id);
        }
        if ($kind ==='harian') {
            $data = DailyProject::find($id);
        }
        return view('admin.projects.finished-show', compact('data', 'kind'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $kind)
    {
        $workers = Worker::all();

        if ($kind == 'borongan') {
            $data = ContractProject::find($id); 

            return view('admin.projects.edit-contract', compact('data', 'workers'));
        }
        if ($kind == 'harian') {
            $data = DailyProject::find($id);

            return view('admin.projects.edit-daily', compact('data', 'workers'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $kind)
    {
        // dd($id);

        if ($kind == 'borongan') {
            $data = ContractProject::find($id);
            // dd($data);
            $client = Client::find($data->client_id);
            $data->update($request->all());
            $client->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->client_address,
                'province_id' => $request->client_province_id,
                'city_id' => $request->client_city_id,
            ]);

            if ($data->status == 'OnProcess') {
                return redirect()->route('admin.projects.onProcess', 'borongan');
            } 
            if ($data->status == 'OnProgress') {
                return redirect()->route('admin.projects.onProgress', 'borongan');
            } 
            if ($data->status == 'Finished') {
                return redirect()->route('admin.projects.finished', 'borongan');
            } 
        }
        if ($kind == 'harian') {
            $data = DailyProject::find($id);
            $client = Client::find($data->client_id);
            $data->update($request->all());
            $client->update($request->only('name', 'phone_number'));

            if ($data->status == 'OnProcess') {
                return redirect()->route('admin.projects.onProcess', 'harian');
            } 
            if ($data->status == 'OnProgress') {
                return redirect()->route('admin.projects.onProgress', 'harian');
            } 
            if ($data->status == 'Finished') {
                return redirect()->route('admin.projects.finished', 'harian');
            } 
        }
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
