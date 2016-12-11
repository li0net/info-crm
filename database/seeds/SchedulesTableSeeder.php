<?php

use Illuminate\Database\Seeder;
use App\Employee;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all()->toArray();

        foreach ($employees AS $employee) {
            $workStartTimes = ['08:00:00', '09:00:00', '10:00:00', '11:00:00'];
            $breakStartTimes = ['12:00:00', '13:00:00', '14:00:00', '15:00:00'];
            $breakEndTimes = ['13:00:00', '14:00:00', '15:00:00', '16:00:00'];
            $workEndTimes = ['17:00:00', '18:00:00', '19:00:00', '20:00:00'];

            $k = mt_rand(0, count($workStartTimes)-1);
            // создаем по 2 записи на день в течение 30 дней (2016-12-11 09:00:00 - 2016-12-11 13:00:00 и 2016-12-11 14:00:00 - 2016-12-11 18:00:00)
            for ($i=0; $i<30; $i++) {
                $workStart = date('Y-m-d', time()+$i*86400).' '.$workStartTimes[$k];
                $workEnd = date('Y-m-d', time()+$i*86400).' '.$breakStartTimes[$k];

                DB::table('schedules')->insert([
                    'employee_id' => $employee['employee_id'],
                    'work_start' => $workStart,
                    'work_end' => $workEnd,

                ]);

                $workStart = date('Y-m-d', time()+$i*86400).' '.$breakEndTimes[$k];
                $workEnd = date('Y-m-d', time()+$i*86400).' '.$workEndTimes[$k];
                DB::table('schedules')->insert([
                    'employee_id' => $employee['employee_id'],
                    'work_start' => $workStart,
                    'work_end' => $workEnd,

                ]);
            }

        }
    }
}
