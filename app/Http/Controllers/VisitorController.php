<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerRequest;
use App\Models\Skill;
use App\Models\Specialist;
use App\Models\Worker;
use App\Models\WorkerKind;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
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
