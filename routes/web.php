<?php

use App\Http\Controllers\DataAjaxController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MerekController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\TipeController;
use App\Http\Controllers\PengeluaranController;
use App\Models\Merek;
use App\Models\Kategori;
use App\Models\Sparepart;
use App\Models\SaldoAwal;
use App\Models\DataBiaya;
use App\Models\Partner;
use App\Models\Types;
use App\Models\Data;
use App\Models\Bonus;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

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
    $partner = Partner::where('owner', 0)->where('kas', 0)->get();
    $kas = Partner::get();
    $tipes = Types::join('data','data.type_id', '=', 'types.id')->get();
    return view('page.barang', compact('kategori','sparepart', 'merek', 'tipes', 'partner', 'kas'));
});

Route::get('/fins', function () {
    (int) $saldo_awal = SaldoAwal::first()->nominal ?? 0;

    // laba
    $laba = 0;
    $semuaData = Data::whereNotNull('harga_terjual')->where('status', 1)->get();
    foreach ($semuaData as $data) {
        $labaPerItem = $data->harga_terjual - $data->harga;
        $laba += $labaPerItem;
    }
    
    (int) $total_bonus = Bonus::sum('nominal');
    $total_laba = $laba;
    // end laba

    // total oprasional
    (int) $oprasional = DataBiaya::where('nama', '!=', 'Harga Barang')->where('from', '!=', 1)->sum('nominal');
    // end total oprasional

    // harga modal
    (int) $harga_modal = DataBiaya::whereIn('data_id', Data::where('status', 0)->pluck('id'))
        ->where('nama', 'Harga Barang')
        ->sum('nominal');


    // uang terpakai
    (int) $uang_terpakai = ($harga_modal + $oprasional);
    
    // sisa saldo (harus dihitung sebelum total_aset)
    (int) $sisa_saldo = $saldo_awal - $uang_terpakai;

    // total aset
    (int) $total_aset = $harga_modal + $sisa_saldo;

    // BAGI HASIL
    $partnerList = [];
    $partners = Partner::all();
    foreach ($partners as $partner) {
        $persentase = $partner->persentase;
        $bagiHasil = $partner->owner ? (($total_laba * $persentase) / 100) - Bonus::sum('nominal') - DataBiaya::where('from', 1)->sum('nominal') : (($total_laba * $persentase) / 100) + Bonus::where('partner_id', $partner->id)->sum('nominal');

        $partnerList[] = [
            'nama' => $partner->nama,
            'owner' => $partner->owner,
            'persentase' => $persentase,
            'total_diterima' => $bagiHasil,
        ];
    }
    // END BAGI HASIL

    // total omset
    (int) $omset = Data::where('status', 1)->sum('harga_terjual');

    // saldo akhir
    (int) $saldo_akhir = $uang_terpakai + $sisa_saldo;

    return view('page.fins', compact(
        'partnerList',
        'saldo_awal',
        'total_aset',
        'oprasional',
        'uang_terpakai',
        'total_laba',
        'sisa_saldo',
        'omset',
        'saldo_akhir'
    ));
});


Route::get('merek/{id}/{params}', [DataAjaxController::class, 'getSelect']);

Route::resource('dataAjax', DataAjaxController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('merek', MerekController::class);
Route::resource('tipe', TipeController::class);
Route::resource('sparepart', SparepartController::class);
Route::resource('pengeluaran', PengeluaranController::class);
Route::resource('saldo-modal', SaldoController::class);
Route::resource('partner', PartnerController::class);
Route::post('partner/kas', [PartnerController::class, 'kas']);
Route::post('jual-unit', [PengeluaranController::class, 'update']);
Route::get('list-terjual', [PengeluaranController::class, 'terjual']);
Route::get('list-terjual/{id}', [PengeluaranController::class, 'list']);
Route::get('/migrate', function () {
    Artisan::call('migrate:fresh', [
        '--force' => true,
        '--seed' => true,
    ]);

    return '✅ Migrasi dan seeder berhasil dijalankan!';
});
Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return '✅ Storage link berhasil dibuat!';
});
Route::get('/test', function () {
    return 'test';
});