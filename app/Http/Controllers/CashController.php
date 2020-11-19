<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use Illuminate\Http\Request;
use App\Http\Requests\CashRequest;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Cash::orderBy('created_at', 'desc')->get();
        $datas_in = Cash::where('money_out', 0)->orderBy('created_at', 'desc')->get();
        $datas_out = Cash::where('money_in', 0)->orderBy('created_at', 'desc')->get();
        // dd($datas_in);

        $in = Cash::pluck('money_in')->sum();
        $out = Cash::pluck('money_out')->sum();

        $total = $in - $out;

        return view('admin.cashs.index', compact('datas', 'datas_in', 'datas_out', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOut()
    {
        return view('admin.cashs.create-out');
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
    public function destroy($id)
    {
        Cash::find($id)->delete();
        
        return redirect()->back();
    }
}
