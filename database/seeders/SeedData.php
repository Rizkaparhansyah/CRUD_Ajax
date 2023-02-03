<?php

namespace Database\Seeders;

use App\Models\Data;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeedData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $keterangan = ['Ada', 'Tidak Ada'];
        $sumber_dana = ['Zakat', 'Infaq Shodaqoh Terikat', 'Infaq Shodaqoh Tidak Terikat'];
        for ($i = 0; $i < 300; $i++) {
            DB::table('data')->insert([
                'sumber_dana' =>  $sumber_dana[array_rand($sumber_dana)],
                'program' => $faker->name,
                'keterangan' => $keterangan[array_rand($keterangan)],
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }
    }
}
