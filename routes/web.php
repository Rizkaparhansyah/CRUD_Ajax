<?php

use App\Http\Controllers\DataAjaxController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TipeController;
use App\Http\Controllers\PengeluaranController;
use App\Models\Merek;
use App\Models\Kategori;
use App\Models\Sparepart;
use App\Models\SaldoAwal;
use App\Models\DataBiaya;
use App\Models\Types;
use App\Models\Data;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $kategori = Kategori::get();
    $sparepart = Sparepart::get();
    $merek = Merek::get();
    $tipes = Types::join('data','data.type_id', '=', 'types.id')->get();
    return view('page.barang', compact('kategori','sparepart', 'merek', 'tipes'));
});

Route::get('/fins', function () {
    $saldo_awal = SaldoAwal::first()->nominal;

    // Ambil semua kendaraan terjual (status = 1)
    $total_aset = 0;
    
    
    $total_aset = DB::table('data_biayas')
    ->join('data', 'data.id', '=', 'data_biayas.data_id')
    ->where('data.status', 0) // hanya barang terjual
    ->where('data_biayas.nama', 'Harga Barang')
    ->sum('data_biayas.nominal');
    
    // Biaya operasional (selain harga barang)
    $oprasional1 = DataBiaya::where('nama', '=', 'Oprasional')->sum('nominal');
    $oprasional = DataBiaya::where('nama', '!=', 'Harga Barang')->sum('nominal');
    $uang_terpakai = $total_aset + $oprasional;
    $total_laba = 0;
    $bonus = 0;
    $barangTerjual = Data::where('status', 1)->get();

    foreach ($barangTerjual as $item) {
        $harga_terjual = (int) $item->harga_terjual;
        $harga = (int) $item->harga;
        // Cari harga beli dari data_biayas (nama = 'Harga Barang' dan data_id = id)
        // $harga_beli = DataBiaya::where('data_id', $item->id)
        //                 ->where('nama', 'Harga Barang')
        //                 ->value('nominal') ?? 0;
        
        $laba_per_item = ($harga_terjual - $harga);
        $total_laba += $laba_per_item;
        $bonus += $item->bonus;
    }
    // dd($total_laba);

    // Total uang keluar
   

    // Hitung sisa kas awal dikurangi uang keluar
    $saldo_akhir = $saldo_awal - $uang_terpakai;

    // Misalnya uang ke partner adalah 40% dari laba
    $sisa_saldo = ($saldo_awal - $uang_terpakai);
    $total_laba =  ($total_laba) ;
    $uang_partner = ($total_laba * 0.4) + $bonus;
    $uang_pemilik = ($total_laba * 0.6) - $bonus;
    $omset = Data::where('status', 1)->sum('harga_terjual');
    
    return view('page.fins', compact(
        'omset',
        'saldo_awal',
        'total_aset',
        'oprasional',
        'oprasional1',
        'uang_terpakai',
        'total_laba',
        'uang_partner',
        'uang_pemilik',
        'sisa_saldo'
    ));
});

Route::get('merek/{id}/{params}', [DataAjaxController::class, 'getSelect']);

Route::resource('dataAjax', DataAjaxController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('merek', MerekController::class);
Route::resource('tipe', TipeController::class);
Route::resource('sparepart', SparepartController::class);
Route::resource('pengeluaran', PengeluaranController::class);
Route::post('jual-unit', [PengeluaranController::class, 'update']);
Route::get('list-terjual', [PengeluaranController::class, 'terjual']);
Route::get('list-terjual/{id}', [PengeluaranController::class, 'list']);
