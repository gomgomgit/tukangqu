<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::truncate();

        $skills = [
            ['name' => 'Tukang Batu'],
            ['name' => 'Tukang Bobok'],
            ['name' => 'Tukang Plafond'],
            ['name' => 'Tukang Pipa'],
            ['name' => 'Tukang Erection Power'],
            ['name' => 'Tukang Kaca'],
            ['name' => 'Tukang Kenek'],
            ['name' => 'Tukang Las'],
            ['name' => 'Tukang Gali'],
            ['name' => 'Tukang Cat'],
            ['name' => 'Tukang Baja'],
            ['name' => 'Tukang Mebel'],
            ['name' => 'Tukang ACP'],
            ['name' => 'Tukang Besi'],
            ['name' => 'Tukang Keramik'],
            ['name' => 'Tukang Listrik'],
            ['name' => 'Tukang AC'],
            ['name' => 'Tukang Aluminium'],
            ['name' => 'Tukang Taman'],
            ['name' => 'Desain Interior'],
            ['name' => 'Pembantu Tukang'],
            ['name' => 'Buruh Tukang'],
            ['name' => 'Lainnya'],
        ];

        Skill::insert($skills);
    }
}
