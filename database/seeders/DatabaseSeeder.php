<?php

namespace Database\Seeders;

use App\Models\DailyProject;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            SkillSeeder::class,
            WorkerKindSeeder::class,
            SpecialistSeeder::class,
            WorkerSeeder::class,
            ClientSeeder::class,
            DailyProjectSeeder::class,
            ContractProjectSeeder::class,
            CashSeeder::class,
            ChargeSeeder::class,
            PaymentTermSeeder::class,
        ]);
    }
}
