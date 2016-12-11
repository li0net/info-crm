<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SuperOrganizationsTableSeeder::class);
        $this->call(OrganizationsTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(AppointmentsTableSeeder::class);
        $this->call(SchedulesTableSeeder::class);
        $this->call(ServiceCategoriesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(EmployeeProvidesServiceTableSeeder::class);
    }
}
