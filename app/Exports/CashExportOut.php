<?php

namespace App\Exports;

use App\Models\Cash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashExportOut implements FromView, ShouldAutoSize
{
    use RegistersEventListeners;

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
        $year = Carbon::create($this->month)->format('yy');
        $users = User::all();
        $cashs = Cash::whereIn('category', ['out', 'owe'])->whereMonth('date', $month)->whereYear('date', $year)->get();
        return view('admin.cashs.export-view-out', compact('cashs', 'users'));
    }

}
