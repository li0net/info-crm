<?php

use Illuminate\Database\Seeder;
use App\SuperOrganization;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $so = SuperOrganization::first();

        DB::table('organizations')->insert([
            'super_organization_id' => $so->super_organization_id,
            'name' => 'Test Company 1 - Branch 1',
            'shortinfo' => $faker->sentence,
            'info' => $faker->paragraph,
            'website' => $so->website,
            'primary_phone' => $faker->phoneNumber,
            'secondary_phone' => $faker->phoneNumber,
            'email' => $faker->word.'@gmail.com',
            'country' => $faker->country,
            'city' => $faker->city,
            'timezone' => 'Europe/Moscow',
            'address' => $faker->address,
            'post_index' => $faker->postcode
        ]);

        DB::table('organizations')->insert([
            'super_organization_id' => $so->super_organization_id,
            'name' => 'Test Company 1 - Branch 2',
            'shortinfo' => $faker->sentence,
            'info' => $faker->paragraph,
            'website' => $so->website,
            'primary_phone' => $faker->phoneNumber,
            'secondary_phone' => $faker->phoneNumber,
            'email' => $faker->word.'@gmail.com',
            'country' => $faker->country,
            'city' => $faker->city,
            'timezone' => 'Europe/Moscow',
            'address' => $faker->address,
            'post_index' => $faker->postcode
        ]);

    }
}
