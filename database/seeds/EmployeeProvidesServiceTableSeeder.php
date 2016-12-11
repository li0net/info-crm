<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\Service;

class EmployeeProvidesServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = Employee::all()->toArray();
        $services = Service::all()->toArray();

        $usedIdsCombinations = array();

        for ($i=0; $i<25; $i++)
        {
            $employeeId = $employees[mt_rand(0, count($employees)-1)]['employee_id'];
            $serviceId = $services[mt_rand(0, count($services)-1)]['service_id'];
            if (isset($usedIdsCombinations[$employeeId.'_'.$serviceId])) {
                continue;
            }

            DB::table('employee_provides_service')->insert([
                'employee_id' => $employeeId,
                'service_id' => $serviceId,
            ]);

            $usedIdsCombinations[$employeeId.'_'.$serviceId] = 1;
        }
    }
}
