<?php

use Illuminate\Database\Seeder;
use App\Organization;

class ServiceCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $org = Organization::first();

        DB::table('service_categories')->insert([
            'organization_id' => $org->organization_id,
            'name' => 'Стрижки мужские',
            'online_reservation_name' => 'Мужские стрижки',
            'gender' => 1
        ]);

        DB::table('service_categories')->insert([
            'organization_id' => $org->organization_id,
            'name' => 'Стрижки женские',
            'online_reservation_name' => 'Женские стрижки',
            'gender' => 0
        ]);

        DB::table('service_categories')->insert([
            'organization_id' => $org->organization_id,
            'name' => 'Уход за ногтями',
            'online_reservation_name' => 'Уход за ногтями',
            'gender' => NULL
        ]);

        DB::table('service_categories')->insert([
            'organization_id' => $org->organization_id,
            'name' => 'Массаж ног',
            'online_reservation_name' => 'Массаж ног',
            'gender' => NULL
        ]);

        DB::table('service_categories')->insert([
            'organization_id' => $org->organization_id,
            'name' => 'Макияж',
            'online_reservation_name' => 'Макияж и грим',
            'gender' => NULL
        ]);
    }
}
