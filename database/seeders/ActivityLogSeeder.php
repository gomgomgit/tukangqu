<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Spatie\Activitylog\Models\Activity;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::truncate();
    }
}
