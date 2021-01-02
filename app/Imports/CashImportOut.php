<?php

namespace App\Imports;

use App\Models\Cash;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CashImportOut implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        return new Cash([
            'name' => $row[0],
            'date' => Carbon::create($row[1])->format('Y-m-d'),
            'category' => 'out',
            'money_out' => $row[2],
            'description' => $row[3]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
