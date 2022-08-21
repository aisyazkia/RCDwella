<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Province;
use App\Models\City;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daftarProvinsi = RajaOngkir::provinsi()->all();
        foreach($daftarProvinsi as $profinceRow){
            Province::create([
                'province_id' => $profinceRow['province_id'],
                'title' => $profinceRow['province']
            ]);
            $daftarKota = RajaOngkir::kota()->dariProvinsi($profinceRow['province_id'])->get();
            foreach($daftarKota as $cityRow){
                City::create([
                    'province_id' => $profinceRow['province_id'],
                    'city_id' => $cityRow['city_id'],
                    'title' => $cityRow['city_name']
                ]);
            }
        }
    }
}
