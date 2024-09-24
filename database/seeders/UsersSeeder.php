<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = \Faker\Factory::create();
        // for ($i = 0; $i < 15; $i++)
        //     User::create([
        //         "name" => $faker->firstName(),
        //         "lastname" => $faker->lastName(),
        //         "totem" => $faker->company(),
        //         "email" => $faker->email(),
        //         "phone" => $faker->e164PhoneNumber(),
        //         "email_verified_at" => Carbon::now(),
        //     ]);
    }
}
