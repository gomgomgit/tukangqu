<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('specialists')->delete();
        Specialist::truncate();

        $specialists = [
            ['name' => 'TA Sipil'],
            ['name' => 'TA Mekanikal'],
            ['name' => 'TA Arsitektur'],
            ['name' => 'TA Elektrikal'],
            ['name' => 'TA Plumbing'],
            ['name' => 'Drafter Sipil'],
            ['name' => 'Drafter Mekanikal'],
            ['name' => 'Drafter Arsitektur'],
            ['name' => 'Drafter Elektrikal'],
            ['name' => 'Drafter Plumbing'],
            ['name' => 'Lainnya'],
        ];

        Specialist::insert($specialists);
    }
}
