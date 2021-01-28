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
            'role' => 'admin',
            'email' => 'adminsatu@email.com',
            'password' => bcrypt('masukaja'),
        ]);

        User::create([
            'name' => 'Admin2',
            'role' => 'admin',
            'email' => 'admindua@email.com',
            'password' => bcrypt('masukaja'),
        ]);

        User::create([
            'name' => 'Operator1',
            'role' => 'operator',
            'email' => 'operatorsatu@email.com',
            'password' => bcrypt('masukaja'),
        ]);

        User::create([
            'name' => 'Operator2',
            'role' => 'operator',
            'email' => 'operatordua@email.com',
            'password' => bcrypt('masukaja'),
        ]);
    }
}
