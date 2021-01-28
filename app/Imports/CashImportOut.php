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
        if ($row[3] == 'pengeluaran') {
            $category = 'out';
        } elseif ($row[3] == 'hutang') {
            $category = 'owe';
        } elseif ($row[3] == 'cicil') {
            $category = 'pay';
        } elseif ($row[3] == 'refund') {
            $category = 'refund';
        }

        return new Cash([
            'name' => $row[0],
            'date' => Carbon::create($row[1])->format('Y-m-d'),
            'user_id' => $row[2],
            'category' => $category,
            'money_out' => $row[4],
            'description' => $row[5]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
