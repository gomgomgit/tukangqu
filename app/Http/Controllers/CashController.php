<?php

namespace App\Http\Controllers;

use App\Exports\CashExportDebt;
use App\Exports\CashExportIn;
use App\Exports\CashExportOut;
use App\Models\Cash;
use Illuminate\Http\Request;
use App\Http\Requests\CashRequest;
use App\Imports\CashImportIn;
use App\Imports\CashImportOut;
use App\Models\User;
use Carbon\Carbon;
// use Maatwebsite\Excel\Excel;
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
        $datas_out = Cash::whereIn('category', ['out', 'owe'])->orderBy('date', 'desc')->get();
        // dd($datas_in);

        $in = Cash::pluck('money_in')->sum();
        $out = Cash::pluck('money_out')->sum();

        $total = $in - $out;

        return view('admin.cashs.index', compact('datas_in', 'datas_out', 'total'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function debt()
    {
        $users = User::all();

        return view('admin.cashs.debt', compact('users'));
    }
    public function debtDetail($id)
    {
        $user = User::where('id', $id)->first();
        $datas = Cash::where('user_id', $id)->whereIn('category', ['owe', 'pay'])->orderBy('date', 'desc')->get();
        $total = Cash::where('user_id', $id)->where('category', 'owe')->sum('money_out') - Cash::where('user_id', $id)->where('category', 'pay')->sum('money_out');

        return view('admin.cashs.debt-detail', compact('datas', 'total', 'user'));
    }
    public function debtPay(Request $request)
    {
        Cash::create([
            'name'=> 'Cicil ',
            'date'=> $request->date,
            'category'=> 'pay',
            'money_in'=> 0,
            'money_out'=> $request->amount,
            'description'=> null,
            'user_id'=> $request->user_id,
        ]);

        return redirect()->back();
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

    public function exportDebt($month) 
    {
        $carbon = Carbon::create($month)->format('m-yy');
        return Excel::download(new CashExportDebt($month), 'hutang-'. $carbon .'.xlsx');
    }

    public function exportViewOut ($m = null)
    {
        if (!$m) {
            $m = Carbon::now()->format('M-YY');
        };
        $month = Carbon::create($m)->format('m');
        $year = Carbon::create($m)->format('Y');
        $now = Carbon::create($m)->format('Y-m');

        $users = User::all();
        $cashs = Cash::whereIn('category', ['out', 'owe'])->whereMonth('date', $month)->whereYear('date', $year)->get();

        $total_in = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_in');
        $total_out = Cash::where('category', 'out')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');
        $total_pay = Cash::where('category', 'pay')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');

        $total_last = Cash::where('category', 'in')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_in') - Cash::where('category', 'out')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_out');

        return view('admin.cashs.export-view-out', compact('cashs', 'users', 'total_last', 'total_in', 'total_out'));
    }

    public function exportViewDebt ($m = null)
    {
        if (!$m) {
            $m = Carbon::now()->format('M-YY');
        };

        $month = Carbon::create($m)->format('m');
        $year = Carbon::create($m)->format('Y');
        $now = Carbon::create($m)->format('Y-m');

        $last_cashs = Cash::whereIn('category', ['pay', 'owe'])->whereDate('date', '<', $now . '-01 00:00:00')->get();

        $users = User::all();
        $cashs = Cash::whereIn('category', ['pay', 'owe'])->whereMonth('date', $month)->whereYear('date', $year)->get();

        $total_in = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_in');
        $total_out = Cash::where('category', 'out')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');
        $total_pay = Cash::where('category', 'pay')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');

        $total_last = Cash::where('category', 'in')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_in') - Cash::where('category', 'out')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_out');
        return view('admin.cashs.export-view-debt', compact('cashs','last_cashs','users', 'total_last', 'total_in', 'total_out'));
    }

    public function exportViewIn($m = null)
    {
        if (!$m) {
            $m = Carbon::now()->format('M-YY');
        };

        $month = Carbon::create($m)->format('m');
        $year = Carbon::create($m)->format('Y');
        $now = Carbon::create($m)->format('Y-m');
        $users = User::all();

        $cashs = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->get();

        $total_in = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_in');
        $total_out = Cash::where('category', 'out')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');
        $total_pay = Cash::where('category', 'pay')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');

        $total_last = Cash::where('category', 'in')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_in') - Cash::where('category', 'out')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_out');

        return view('admin.cashs.export-view-in', compact('users', 'cashs', 'total_last', 'total_in', 'total_out'));
    }

    public function importIn (Request $request)
    {
        Excel::import(new CashImportIn, $request->file('import-in'));
        return redirect()->route('admin.cashes.index');
    }
    public function importOut (Request $request)
    {
        Excel::import(new CashImportOut, $request->file('import-out'));
        return redirect()->route('admin.cashes.index');
    }
}
