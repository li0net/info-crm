<?php

use Illuminate\Database\Seeder;
use App\Organization;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $org = Organization::first();
        $faker = Faker\Factory::create();

        DB::table('users')->insert([
            'organization_id' => $org->organization_id,
            'name' => 'Петр Тестеров',
            'email' => 'tilerhly71se@mail.ru',
            'password' => bcrypt('123'),
            'phone' => $faker->phoneNumber,
            'remember_token' => str_random(10)
        ]);

        DB::table('users')->insert([
            'organization_id' => $org->organization_id,
            'name' => 'Виктор Моков',
            'email' => 'rbaklanov@gmail.com',
            'password' => bcrypt('321'),
            'phone' => $faker->phoneNumber,
            'remember_token' => str_random(10)
        ]);
    }
}
