<?php

use Illuminate\Database\Seeder;

class SuperOrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('super_organizations')->insert([
            'name' => 'Test Company 1',
            'shortinfo' => $faker->sentence,
            'info' => $faker->paragraph,
            'website' => 'http://www.'.$faker->word.'.com',
            'primary_phone' => $faker->phoneNumber,
            'secondary_phone' => $faker->phoneNumber,
            'tariff_id' => 1
        ]);
    }
}
