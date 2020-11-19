<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkerKindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('worker_kinds')->delete();

        $kinds = [
            ['name' => 'Mandor'],
            ['name' => 'Wakil Mandor'],
            ['name' => 'Kepala Tukang'],
            ['name' => 'Tukang'],
            ['name' => 'Buruh Tukang'],
            ['name' => 'Kenek'],
            ['name' => 'Lainnya'],
        ];

        DB::table('worker_kinds')->insert($kinds);
    }
}
