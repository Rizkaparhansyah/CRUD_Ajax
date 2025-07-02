<?php

namespace App\Http\Controllers;

use App\Models\DataBiaya;
use App\Models\Bonus;
use App\Models\Data;
use App\Models\Partner;
use App\Models\SaldoAwal;
use Illuminate\Http\Request;
use DataTables;
use DB;

class PengeluaranController extends Controller
{
    public function index(Request $request) {
         $data = DataBiaya::whereRaw('data_id is null')->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editBtn = '<button type="button" class="btn btn-sm btn-primary editPengeluaran" data-id="'.$row->id.'" data-nama="'.$row->nama.'" data-nominal="'.$row->nominal.'">Edit</button>';
                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger deletePengeluaran" data-id="'.$row->id.'">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi']) // agar HTML tidak di-escape
                ->make(true);
        }
    }
    public function store(Request $request) { 
        $saldo_awal = SaldoAwal::first();
        $labaOwner = 0;
       // total oprasional
        (int) $oprasional = DataBiaya::where('nama', '!=', 'Harga Barang')->sum('nominal');
        // end total oprasional

        // harga modal
        (int) $harga_modal = DataBiaya::whereIn('data_id', Data::where('status', 0)->pluck('id'))
            ->where('nama', 'Harga Barang')
            ->sum('nominal');

        (int) $total_bonus = Bonus::sum('nominal');

        // uang terpakai
        (int) $uang_terpakai = ($harga_modal + $oprasional) + $total_bonus;
        $sisa_modal = (int) $saldo_awal->nominal - $uang_terpakai;

        
        // dd($labaOwner);
        if((int) $request->pengeluaran_nominal > $sisa_modal){
            $semuaData = Data::whereNotNull('harga_terjual')->where('status', 1)->get();
    
            $totalLaba = 0;
            foreach ($semuaData as $data) {
                $labaPerItem = $data->harga_terjual - $data->harga;
                $totalLaba += $labaPerItem;
            }
    
            $owner = Partner::where('owner', 1)->first();
            $labaOwner = ($totalLaba * ($owner->persentase / 100)) - Bonus::sum('nominal');
            // cek laba si owner
            if((int) $request->pengeluaran_nominal > $labaOwner){
                return response()->json(["message" => 'Saldo tidak cukup!']);
            }
        }
        // jika ambil dari kass
        // elseif(){
            
        // } 
        // jika ambil dari laba owr
        // elseif (){

        // }
        // dd('cukup');
        if($request->pengeluaran_nominal == null || $request->pengeluaran_nominal == '' ){
            return response()->json(["message" => 'Tolong isi nominal!']);
        }
        if($request->nama_pengeluaran == null || $request->nama_pengeluaran == '' ){
            return response()->json(["message" => 'Tolong isi nama pengeluaran!']);
        }
            DataBiaya::updateOrCreate(
                ['id' => $request->idHidePengeluaran],
                [
                    'data_id' => $request->tipes_id,
                    'nama' => $request->nama_pengeluaran,
                    'nominal' => $request->pengeluaran_nominal,
                    'from' =>  $request->pengeluaran_nominal > $labaOwner ? 0 : 1,
                ]);
            Data::where('id', $request->tipes_id)
                ->update([
                'harga' => DB::raw('harga + ' . (int) $request->pengeluaran_nominal)
            ]); 
        return response()->json(['message' => 'Berhasil'], 200);
    }
    
    public function destroy($id)
        {
            // Ambil data pengeluaran yang akan dihapus
            $biaya = DataBiaya::find($id);

            if (!$biaya) {
                return response()->json(['error' => 'Data pengeluaran tidak ditemukan.'], 404);
            }

            // Ambil saldo kas (asumsi hanya ada 1 data)
            $saldo = SaldoAwal::first();

            if ($saldo) {
                // Tambahkan kembali nominal pengeluaran ke saldo kas
                $saldo->update([
                    'saldo_kas' => $saldo->saldo_kas + $biaya->nominal
                ]);
            }

            // Hapus data pengeluaran
            $biaya->delete();

            return response()->json('success', 200);
        }


    public function update(Request $request)
    {
         $saldo_awal = SaldoAwal::first();
        // total oprasional
        (int) $oprasional = DataBiaya::where('nama', '!=', 'Harga Barang')->sum('nominal');
        // end total oprasional

        // harga modal
        (int) $harga_modal = DataBiaya::whereIn('data_id', Data::where('status', 0)->pluck('id'))
            ->where('nama', 'Harga Barang')
            ->sum('nominal');

        (int) $total_bonus = Bonus::sum('nominal');

        // uang terpakai
        (int) $uang_terpakai = ($harga_modal + $oprasional) + $total_bonus;
        (int) $sisa_modal = $saldo_awal->nominal - $uang_terpakai;

        
        (int) $bonus = collect($request->bonus_nominal)->sum();
        // hitung saldo owner;
        if( $bonus > $sisa_modal){
            $semuaData = Data::whereNotNull('harga_terjual')->where('status', 1)->get();
            
            $totalLaba = 0;
            foreach ($semuaData as $data) {
                $labaPerItem = $data->harga_terjual - $data->harga;
                $totalLaba += $labaPerItem;
            }
    
            $owner = Partner::where('owner', 1)->first();
            (int) $labaOwner = ($totalLaba * ($owner->persentase / 100)) - Bonus::sum('nominal');
            // cek laba si owner
            if((int) $bonus > $labaOwner){
                // dd('Saldo TIdak cukup');
                return response()->json(["message" => 'Saldo tidak cukup!']);
            }
        }
        // dd('Saldo cukup');

        $data = Data::where('id', $request->kendaraan_id)->first();

        if (!$data) {
            return response()->json(['error' => 'Data kendaraan tidak ditemukan.'], 404);
        }
        
        Data::where('id', $request->kendaraan_id)->update([
            'harga_terjual' => $request->penjualan_nominal,
            'status' => ($request->penjualan_nominal == 0 && collect($request->bonus_nominal)->sum() == 0) ? 0 : 1,
        ]);


// dd($request->bonus_nominal );
// dd($request->kendaraan_id);
    
        foreach ($request->id_partner as $index => $partner_id) {

            $nominal = (int) $request->bonus_nominal[$index];
            // $total_bonus = array_sum($request->bonus_nominal);
            
            
            // if ($nominal > 0) {
                Bonus::updateOrCreate(
                    ['data_id' => $request->kendaraan_id, 'partner_id' => $partner_id],
                    ['nominal' => $nominal]
                );
                // return 'sukses';
            // }else{
            //     Bonus::where('data_id', $request->kendaraan_id)->delete();

            // }
        }

        // hitung laba
        // $laba = 0;
        // $semuaData = Data::whereNotNull('harga_terjual')->where('status', 1)->get();
        // foreach ($semuaData as $data) {
        //     $labaPerItem = $data->harga_terjual - $data->harga;
        //     $laba += $labaPerItem;
        // }
        
        // (int) $total_bonus = Bonus::sum('nominal');
        // $total_laba = $laba;
        // // end hitung laba

        // //persentase saldo
        // $persentaseKas = Partner::where('kas', 1)->first();
        // //endpersentase saldo
        // $saldo_baru = $total_laba * ($persentaseKas->persentase / 100);
        // // dd($saldo_baru);
        // $saldo_awal->update(['saldo_kas' => $saldo_baru]);

        return response()->json(["message" => 'Berhasil']);
    }
    
    public function terjual(Request $request) {
        // dd($request->all());
       $data = Data::with(['tipe', 'bonus.partners'])->where(
            'status', 1
        )->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                   return $row->tipe->nama;
                })
                ->addColumn('laba', function ($row) {
                   return ($row->harga_terjual - $row->harga);
                })
                ->addColumn('bonus', function ($row) {
                    return  $row->nominal;
                    // return $row->bonus->map(function ($bonus) {
                    //     return [
                    //         'nama' => $bonus->partner->nama ?? 'Unknown',
                    //         'bonus' => $bonus->nominal
                    //     ];
                    // })->values();
                })

                ->rawColumns(['nama', 'bonus', 'laba']) // agar HTML tidak di-escape
                ->make(true);
        }
    }

    public function list($id) {
        $data = Data::with('bonus')->find($id);

        return $data;
    }
}
