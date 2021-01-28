<?php

namespace App\Exports;

use App\Models\Cash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CashExportTemplateIn implements FromView, ShouldAutoSize
{
    use RegistersEventListeners;

    public function view(): View
    {
        return view('admin.cashs.export-template-view-in');
    }
}
