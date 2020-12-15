<?php

namespace App\Http\Controllers;

use App\Exports\CashExportIn;
use App\Exports\CashExportOut;
use App\Models\Cash;
use Illuminate\Http\Request;
use App\Http\Requests\CashRequest;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas_in = Cash::where('category', 'in')->orderBy('date', 'desc')->get();
        $datas_out = Cash::where('category', 'out')->orderBy('date', 'desc')->get();
        // dd($datas_in);

        $in = Cash::pluck('money_in')->sum();
        $out = Cash::pluck('money_out')->sum();

        $total = $in - $out;

        return view('admin.cashs.index', compact('datas_in', 'datas_out', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOut()
    {
        $users = User::all();
        return view('admin.cashs.create-out', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOut(CashRequest $request)
    {
        $data = $request->all();

        Cash::create($data);

        return redirect()->route('admin.cashes.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeIn(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editout($id)
    {
        $data = Cash::find($id);
        $users = User::all();

        return view('admin.cashs.edit-out', compact('data', 'users'));
    }
    public function editin($id)
    {
        $data = Cash::find($id);
        $users = User::all();

        return view('admin.cashs.edit-in', compact('data', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatein(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'category' => 'required',
            'money_in' => 'required|numeric',
            'description' => 'nullable' 
        ]);

        $data = $request->all();
        $cash = Cash::find($id);
        
        $cash->update($data);
        // dd($cash);

        return redirect()->route('admin.cashes.index');
    }
    public function updateout(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'date' => 'required|date',
            'category' => 'required',
            'user_id' => 'required',
            'money_out' => 'required|numeric',
            'description' => 'nullable' 
        ]);

        $data = $request->all();
        $cash = Cash::find($id);
        
        $cash->update($data);

        return redirect()->route('admin.cashes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cash::find($id)->delete();
        
        return redirect()->back();
    }

    public function exportIn($month) 
    {
        $carbon = Carbon::create($month)->format('m-yy');
        return Excel::download(new CashExportIn($month), 'pemasukan-'. $carbon .'.xlsx');
    }

    public function exportOut($month) 
    {
        $carbon = Carbon::create($month)->format('m-yy');
        return Excel::download(new CashExportOut($month), 'pengeluaran-'. $carbon .'.xlsx');
    }

    public function exportViewOut() 
    {
        $cashs = Cash::where('category', 'out')->get();
        $users = User::all();
        return view('admin.cashs.export-view-out', compact('cashs', 'users'));
    }

    public function exportViewIn() 
    {
        $cashs = Cash::where('category', 'in')->get();
        $total_out = Cash::where('category', 'out')->sum('money_out');
        $users = User::all();
        return view('admin.cashs.export-view-in', compact('cashs', 'total_out', 'users'));
    }
}
