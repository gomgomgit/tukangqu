<?php

namespace App\Exports;

use App\Models\Cash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

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

     public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
    public function view(): View
    {
        $month = Carbon::create($this->month)->format('m');
        $lastmonth = Carbon::create($this->month)->subMonth()->format('m');
        $year = Carbon::create($this->month)->format('yy');
        $lastyear = Carbon::create($this->month)->subMonth()->format('yy');
        $users = User::all();

        $cashs = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->get();
        
        $total_in = Cash::where('category', 'in')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_in');
        $total_out = Cash::where('category', 'out')->whereMonth('date', $month)->whereYear('date', $year)->sum('money_out');

        // $total_all = Cash::where('category', 'in')->sum('money_in') - Cash::where('category', 'out')->sum('money_out');
        // $total_month = $total_in - $total_out;

        $nowmonth = Carbon::create('01 ' . $this->month);
        $lasttotal = Cash::where('category', 'in')->whereDate('date', '<', $nowmonth)->sum('money_in') - Cash::where('category', 'out')->whereDate('date', '<', $nowmonth)->sum('money_out');
        // $lasttotal = $total_all - $total_month;
        // $test = Cash::where('category', 'in')->whereDate('date', '<', $nowmonth)->pluck('date');
        // dd($test);

        return view('admin.cashs.export-view-in', compact('users', 'cashs', 'lasttotal', 'total_out'));
    }

}
