<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Merek;
use App\Models\Types;
use App\Models\Sparepart;
use App\Models\Data;
use App\Models\SaldoAwal;

class SeedData extends Seeder
{
    public function run(): void
    {
        // Insert kategori
        Kategori::create(['nama' => 'Mobil']);
        Kategori::create(['nama' => 'Motor']);

        // Insert merek
        Merek::create(['nama' => 'Toyota']);
        Merek::create(['nama' => 'Honda']);
        Merek::create(['nama' => 'Yamaha']);

        // Insert jenis (dulu bernama type)
        Types::create(['nama' => 'Avanza', 'kategori_id' => 1, 'merek_id' => 1]);
        Types::create(['nama' => 'Mio Smile', 'kategori_id' => 2, 'merek_id' => 3]);
        Types::create(['nama' => 'XRIDE 115', 'kategori_id' => 2, 'merek_id' => 3]);
        Types::create(['nama' => 'Beat', 'kategori_id' => 2, 'merek_id' => 2]);
        Types::create(['nama' => 'VARIO KZR 125', 'kategori_id' => 2, 'merek_id' => 2]);
        Types::create(['nama' => 'VARIO LED NEW 125', 'kategori_id' => 2, 'merek_id' => 2]);

        // Insert sparepart
        Sparepart::create(['nama' => 'KAMPAS REM DEPAN',]);
        Sparepart::create(['nama' => 'KAMPAS REM BELAKANG',]);
        Sparepart::create(['nama' => 'OLI MESIN',]);
        Sparepart::create(['nama' => 'Oli GARDAN',]);
        Sparepart::create(['nama' => 'MINYAK REM',]);
        
        // Saldo awal
        SaldoAwal::create(['nominal' => 32000000,]);
        
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
