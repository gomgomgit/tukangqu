<?php

namespace Database\Seeders;

use App\Models\Profit;
use Illuminate\Database\Seeder;

class ProfitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profit::truncate();

        
    }
}
