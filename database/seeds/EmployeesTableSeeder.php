<?php

use Illuminate\Database\Seeder;
use App\Organization;
use App\Position;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $org = Organization::first();
        $positions = Position::all()->toArray();
        $faker = Faker\Factory::create();

        for ($i = 0; $i<10; $i++) {
            DB::table('employees')->insert([
                'organization_id' => $org->organization_id,
                'position_id' => $positions[mt_rand(0, count($positions)-1)]['position_id'],
                'name' => $faker->firstName.' '.$faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber
            ]);
        }
    }
}
