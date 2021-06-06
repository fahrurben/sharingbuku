<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province_json = dirname(__FILE__) . '/../data/propinsi.json';
        $jsonString = file_get_contents($province_json);

        $arrProvince = json_decode($jsonString, true);

        foreach ($arrProvince as $province) {
            Province::create(['id' => $province['id'], 'name' => $province['nama']]);
        }
    }
}
