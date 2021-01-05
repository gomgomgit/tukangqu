<?php

namespace App\Exports;

use App\Models\Cash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CashExportDebt implements FromView, ShouldAutoSize
{
    use RegistersEventListeners;

    protected $month;

    function __construct($month)
    {
        $this->month = $month;
    }
    public function view(): View
    {
        $month = Carbon::create($this->month)->format('m');
        $year = Carbon::create($this->month)->format('Y');
        $now = Carbon::create($this->month)->format('Y-m');

        $last_cashs = Cash::whereIn('category', ['pay', 'owe'])->whereDate('date', '<', $now . '-01 00:00:00')->get();

        $users = User::all();
        $cashs = Cash::whereIn('category', ['pay', 'owe'])->whereMonth('date', $month)->whereYear('date', $year)->get();

        $total_in = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_in');
        $total_out = Cash::where('category', 'out')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');
        $total_pay = Cash::where('category', 'pay')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');

        $total_last = Cash::where('category', 'in')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_in') - Cash::where('category', 'out')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_out');
        return view('admin.cashs.export-view-debt', compact('cashs', 'last_cashs', 'users', 'total_last', 'total_in', 'total_out'));
    }
}
