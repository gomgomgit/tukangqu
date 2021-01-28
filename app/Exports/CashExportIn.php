<?php

namespace App\Exports;

use App\Models\Cash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CashExportIn implements FromView, ShouldAutoSize
{
    
    protected $month;

    function __construct($month) {
        $this->month = $month;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Tanggal',
            'Jumlah'
        ];
    }

    public function view(): View
    {
        $month = Carbon::create($this->month)->format('m');
        $year = Carbon::create($this->month)->format('Y');
        $now = Carbon::create($this->month)->format('Y-m');
        $users = User::all();

        $cashs = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->get();

        $total_in = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_in');
        $total_out = Cash::whereIn('category', ['out', 'refund'])->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');
        $total_pay = Cash::where('category', 'pay')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');

        $total_last = Cash::where('category', 'in')->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_in') - Cash::whereIn('category', ['out', 'refund'])->whereDate('date', '<', $now . '-01 00:00:00')->sum('money_out');

        return view('admin.cashs.export-view-in', compact('users', 'cashs', 'total_last', 'total_in', 'total_out'));
    }

}
