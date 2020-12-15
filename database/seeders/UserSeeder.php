<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'Admin1',
            'email' => 'adminsatu@email.com',
            'password' => bcrypt('masuk'),
        ]);

        User::create([
            'name' => 'Admin2',
            'email' => 'admindua@email.com',
            'password' => bcrypt('masuk'),
        ]);
    }
}
