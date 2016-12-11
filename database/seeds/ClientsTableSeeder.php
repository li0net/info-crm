<?php

use Illuminate\Database\Seeder;
use App\Organization;

class ClientsTableSeeder extends Seeder
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
        $genders = array(1, 0, NULL);

        for ($i = 0; $i<20; $i++) {
            DB::table('clients')->insert([
                'organization_id' => $org->organization_id,
                'name' => $faker->firstName.' '.$faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'password' => bcrypt('111'),
                'gender' => $genders[mt_rand(0, count($genders)-1)],
                'discount' => mt_rand(0, 20),
                'birthday' => $faker->date('Y-m-d', '-18 years ago'),
                'comment' => $faker->paragraph,
                'do_not_send_sms' => mt_rand(0, 1),
                'birthday_sms' => mt_rand(0, 1),
                'online_reservation_available' => mt_rand(0, 1)
            ]);
        }
    }
}
