<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\WorkerRequest;
use App\Models\Client;
use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\Skill;
use App\Models\Specialist;
use App\Models\Worker;
use App\Models\WorkerKind;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function createProject()
    {
        $clients = Client::all();
        return view('visitor.create-project', compact('clients'));
    }

    public function createProjectProcess(ProjectRequest $request)
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

        return redirect()->route('createProjectSucess');
    }
    public function createProjectSucess()
    {
        return view('visitor.create-project-sucess');
    }

    public function workerRegister() 
    {
        $skills = Skill::all();
        $kinds = WorkerKind::all();
        $specialists = Specialist::all();

        return view('visitor.worker-register', compact('skills', 'kinds', 'specialists'));
    }

    public function workerRegisterProcess(WorkerRequest $request)
    {
        // dd($request->birth_date);
        $data = $request->all();
        $data['self_photo'] = $request->file('self_photo')->store('assets/images/worker', 'public');
        $data['id_card_photo'] = $request->file('id_card_photo')->store('assets/images/workeridcard', 'public');

        $worker_id = Worker::create($data);
        $worker_id->skills()->sync($request->skill);
        return redirect()->route('workerRegisterSucess');
    }

    public function workerRegisterSucess()
    {
        return view('visitor.worker-register-sucess');
    }
}
