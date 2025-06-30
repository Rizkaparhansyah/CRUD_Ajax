<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Types;
use App\Models\Sparepart;
use App\Models\Partner;
use App\Models\Data;
use App\Models\SaldoAwal;

class SeedData extends Seeder
{
    public function run(): void
    {
        // Insert kategori
        Kategori::create(['nama' => 'MOBIL']);
        Kategori::create(['nama' => 'MOTOR']);

        // Insert merek
        Merek::create(['nama' => 'TOYOTA']);
        Merek::create(['nama' => 'HONDA']);
        Merek::create(['nama' => 'YAMAHA']);

        // Insert jenis (dulu bernama type)
        Types::create(['nama' => 'MIO', 'kategori_id' => 2, 'merek_id' => 3]);
        Types::create(['nama' => 'XRIDE 115', 'kategori_id' => 2, 'merek_id' => 3]);
        Types::create(['nama' => 'BEAT KARBU', 'kategori_id' => 2, 'merek_id' => 2]);
        Types::create(['nama' => 'BEAT STARTER HALUS', 'kategori_id' => 2, 'merek_id' => 2]);
        Types::create(['nama' => 'VARIO KZR 125', 'kategori_id' => 2, 'merek_id' => 2]);
        Types::create(['nama' => 'VARIO LED NEW 125', 'kategori_id' => 2, 'merek_id' => 2]);

        // Insert sparepart
        Sparepart::create(['nama' => 'KAMPAS REM DEPAN',]);
        Sparepart::create(['nama' => 'KAMPAS REM BELAKANG',]);
        Sparepart::create(['nama' => 'OLI MESIN',]);
        Sparepart::create(['nama' => 'OLI GARDAN',]);
        Sparepart::create(['nama' => 'AKI',]);
        Sparepart::create(['nama' => 'SPION',]);
        Sparepart::create(['nama' => 'COVER BODY',]);
        Sparepart::create(['nama' => 'STRIPING',]);
        Sparepart::create(['nama' => 'REPAINT',]);
        Sparepart::create(['nama' => 'ANGKER DINAMO',]);
        Sparepart::create(['nama' => 'SPEEDO METER',]);
        Sparepart::create(['nama' => 'JARUM SPEEDO METER',]);
        Sparepart::create(['nama' => 'MINYAK REM',]);
        
        // Saldo awal
        SaldoAwal::create(['nominal' => 32000000,]);

        //PARTNER
        Partner::create(['nama' => "DIAN HADY ALI NURDIN", 'persentase' => 60, 'owner' => 1,]);
        Partner::create(['nama' => "ROBBY FIRMANSYAH", 'persentase' => 40, 'owner' => 0,]);
        
        // Insert data
        // $data = Data::create([
        //     'kategori_id' => 1,
        //     'merek_id' => 1,
        //     'type_id' => 1,
        //     'nopol' => 'B1234XYZ',
        //     'warna' => 'Hitam',
        //     'tahun' => 2020,
        //     'pajak' => '2025-12',
        //     'harga' => 2000000,
        //     'status' => 0,
        // ]);

        // Menyimpan foto-fotonya
        // $data->fotos()->createMany([
        //     ['path' => 'uploads/foto1.jpg'],
        //     ['path' => 'uploads/foto2.jpg'],
        //     ['path' => 'uploads/foto3.jpg'],
        // ]);
        // Menyimpan foto-fotonya
        // $data->biayas()->createMany([
        //     ['nama' => 'Oprasinal', 'nominal' => 20000],
        //     ['nama' => 'Oli', 'nominal' => 30000],
        //     ['nama' => 'Kampas', 'nominal' => 20000],
        // ]);

 // Kampas Rem
    }
}
