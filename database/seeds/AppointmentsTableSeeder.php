<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\Client;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all()->toArray();
        $clients = Client::all()->toArray();
        $faker = Faker\Factory::create();

        for ($i = 0; $i<50; $i++) {
            $appointmentLengths = [900, 1800, 3600, 5400, 7200];
            $start = $faker->dateTimeThisMonth->format('Y-m-d H:i:s');;
            $end = strtotime($start) + $appointmentLengths[mt_rand(0, count($appointmentLengths)-1)];
            $end = date('Y-m-d H:i:s', $end);
            $remindTimesInMinutes = [10, 30, 60, 90, 120, 180, 240, NULL];

            DB::table('appointments')->insert([
                'employee_id' => $employees[mt_rand(0, count($employees)-1)]['employee_id'],
                'client_id' => $clients[mt_rand(0, count($clients)-1)]['client_id'],
                'start' => $start,
                'end' => $end,
                'remind_by_email_in' => $remindTimesInMinutes[mt_rand(0, count($remindTimesInMinutes)-1)],
                'remind_by_sms_in' => $remindTimesInMinutes[mt_rand(0, count($remindTimesInMinutes)-1)],
                'remind_by_phone_in' => $remindTimesInMinutes[mt_rand(0, count($remindTimesInMinutes)-1)],
                'is_confirmed' => mt_rand(0, 1),
            ]);
        }

    }
}
