<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::truncate();

        $faker = Factory::create('id_ID');

        for ($i=0; $i < 22; $i++) { 
            Client::create([
                'name' => $faker->firstName,
                'phone_number' => $faker->phoneNumber, 
            ]);
        }
    }
}
