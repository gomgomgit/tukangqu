<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkerRequest;
use App\Models\ContractProject;
use App\Models\DailyProject;
use App\Models\Skill;
use App\Models\Specialist;
use App\Models\Worker;
use App\Models\WorkerKind;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Spatie\Activitylog\Models\Activity;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Paginator::useBootstrap();
        // dd(\Indonesia::findVillage(7604030008));
        // $datas = Worker::with('locations')->get();
        $datas = Worker::orderBy('created_at', 'desc')->get();
        // dd($datas->first());
        return view('admin.workers.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skills = Skill::all();
        $kinds = WorkerKind::all();
        $specialists = Specialist::all();

        return view('admin.workers.create', compact('skills', 'kinds', 'specialists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkerRequest $request)
    {
        // dd($request->birth_date);
        $data = $request->all();
        $data['self_photo'] = $request->file('self_photo')->store('assets/images/worker', 'public');
        $data['id_card_photo'] = $request->file('id_card_photo')->store('assets/images/workeridcard', 'public');

        // dd($request->file('self_photo'));

        $worker_id = Worker::create($data);
        $worker_id->skills()->sync($request->skill);
        return redirect()->route('admin.workers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Worker::with('skills')->find($id);

        return view('admin.workers.show', compact('data'));
    }

    public function viewProjects($id)
    {
        $contract = ContractProject::where('worker_id', $id)->orderBy('order_date', 'desc')
                    ->get(['id', 'address', 'city_id', 'order_date', 'kind_project', 'project_value', 'profit', 'status', 'description']);
        $daily = DailyProject::where('worker_id', $id)->orderBy('order_date', 'desc')
                    ->get(['id', 'address', 'city_id', 'order_date', 'kind_project', 'project_value', 'profit', 'status', 'description']);
        $datas = $contract->toBase()->merge($daily)->take(10);

        // dd($datas->first());

        return view('admin.workers.view-projects', compact('datas'));
    }
    
    public function projectShow($id, $kind) {
        if ($kind === 'borongan') {
            $data = ContractProject::find($id);
            $activities = Activity::where('subject_type', 'App\Models\ContractProject')->where('subject_id', $id)->orderBy('created_at', 'desc')->get();
            // dd($activities);
        }
        if ($kind === 'harian') {
            $data = DailyProject::find($id);
            $activities = Activity::where('subject_type', 'App\Models\DailyProject')->where('subject_id', $id)->orderBy('created_at', 'desc')->get();
        }
        return view('admin.workers.project-show', compact('data', 'kind', 'activities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Worker::with('skills')->find($id);
        $selectedSkills = $data->skills->pluck('id')->toArray();
        $skills = Skill::all();
        $kinds = WorkerKind::all();
        $specialists = Specialist::all();
        
        return view('admin.workers.edit', compact('data', 'selectedSkills', 'skills', 'kinds', 'specialists'));
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
        $request->validate([
            'name' => 'required',
            'birth_place' => 'required',
            'birth_date' => 'required|date',
            'email' => 'required|email',
            'phone_number' => 'required|unique:workers,phone_number,'. $id,
            'address' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'village_id' => 'required',
            'worker_kind_id' => 'required',
            'specialist_id' => 'required',
            'experience' => 'required',
            'skill' => 'required|array'
        ]);
        $data = $request->all();
        if($data['self_photo']) {
            $data['self_photo'] = $request->file('self_photo')->store('assets/images/worker', 'public');
        } else {
            $data['self_photo'] = $data['old_self_photo'];
        }
        
        if($data['id_card_photo']) {
            $data['id_card_photo'] = $request->file('id_card_photo')->store('assets/images/workeridcard', 'public');
        } else {
            $data['id_card_photo'] = $data['old_id_card_photo'];
        }
        

        $worker = Worker::find($id);
        $worker->update($data);
        $worker->skills()->sync($request->skill);
        return redirect()->route('admin.workers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Worker::find($id)->delete();
        return redirect()->back();
    }
}
