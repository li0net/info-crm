<?php

use Illuminate\Database\Seeder;
use App\Organization;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $org = Organization::first();

        DB::table('positions')->insert([
            'organization_id' => $org->organization_id,
            'title' => 'Парикмахер',
            'description' => 'Выполняет мужские и женские стрижки'
        ]);

        DB::table('positions')->insert([
            'organization_id' => $org->organization_id,
            'title' => 'Мастер маникюра',
            'description' => 'Выполняет маникюр и процедуры ухода за ногтями'
        ]);

        DB::table('positions')->insert([
            'organization_id' => $org->organization_id,
            'title' => 'Визажист',
            'description' => 'Накладывает макияж и грим'
        ]);
    }
}
