<?php

use Illuminate\Database\Seeder;
use App\ServiceCategory;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $sc = ServiceCategory::all()->toArray();
        $pricesMin = [200, 300, 400, 500, 1000, 2000];
        $pricesMax = [350, 400, 600, 800, 1500, 4500];
        $durations = ['00:20:00', '00:30:00', '00:45:00', '01:00:00', '01:30:00', '02:00:00', '03:00:00'];

        for ($i=0; $i<20; $i++)
        {
            $k = mt_rand(0, count($pricesMin)-1);
            DB::table('services')->insert([
                'service_category_id' => $sc[mt_rand(0, count($sc) - 1)]['service_category_id'],
                'name' => $faker->word,
                'description' => $faker->paragraph,
                'price_min' => $pricesMin[$k],
                'price_max' => $pricesMax[$k],
                'duration' => $durations[mt_rand(0, count($durations)-1)]
            ]);
        }
    }
}
