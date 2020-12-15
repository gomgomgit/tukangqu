<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ContractProject;
use App\Models\DailyProject;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Client::orderBy('created_at', 'desc')->get();
        // dd($datas->first());
        return view('admin.clients.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->birth_date);
        $data = $request->all();

        Client::create($data);

        return redirect()->route('admin.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Client::find($id);

        return view('admin.clients.show', compact('data'));
    }

    public function viewProjects($id)
    {
        $contract = ContractProject::where('client_id', $id)->orderBy('order_date', 'desc')
                    ->get(['id', 'address', 'city_id', 'order_date', 'kind_project', 'project_value', 'profit', 'status', 'description']);
        $daily = DailyProject::where('client_id', $id)->orderBy('order_date', 'desc')
                    ->get(['id', 'address', 'city_id', 'order_date', 'kind_project', 'project_value', 'profit', 'status', 'description']);
        $datas = $contract->toBase()->merge($daily)->take(10);

        // dd($datas->first());

        return view('admin.clients.view-projects', compact('datas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Client::find($id);
        
        return view('admin.clients.edit', compact('data'));
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
        $data = $request->all();

        $worker = Client::find($id);
        $worker->update($data);
        return redirect()->route('admin.clients.index');
    }

    public function destroy($id)
    {
        Client::find($id)->delete();
        return redirect()->back();
    }
}
