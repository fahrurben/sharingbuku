<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = 11;
        $end = 94;

        for ($start = 11; $start <= $end; $start++) {
            $filename = dirname(__FILE__) . '/../data/' . $start . '.json';
            if (file_exists($filename)) {
                $jsonString = file_get_contents($filename);

                $arrCity = json_decode($jsonString, true);

                foreach ($arrCity as $city) {
                    City::create([
                        'id' => $city['id'],
                        'province_id' => $start,
                        'name' => $city['nama'],
                    ]);
                }
            }

        }

    }
}
