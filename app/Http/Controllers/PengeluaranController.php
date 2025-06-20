<?php

namespace App\Http\Controllers;

use App\Models\DataBiaya;
use App\Models\Data;
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
        DataBiaya::updateOrCreate(
            ['id' => $request->idHidePengeluaran],
            [
                'data_id' => $request->tipes_id,
                'nama' => $request->nama_pengeluaran,
                'nominal' => $request->pengeluaran_nominal,
            ]);
            Data::where('id', $request->tipes_id)
                ->update([
                'harga' => DB::raw('harga + ' . (int) $request->pengeluaran_nominal)
            ]); 
        return response()->json('success', 200);
    }
    
    public function destroy($id) {
        DataBiaya::destroy($id);

        return response()->json('success', 200);
    }

    public function update(Request $request) {
        // dd($request->all());
        Data::where('id', $request->kendaraan_id)->update([
            'harga_terjual' => $request->penjualan_nominal,
            'bonus' => $request->bonus_nominal,
            'status' => $request->penjualan_nominal == 0 && $request->bonus_nominal == 0 ? 0 : 1,
        ]);

        return response()->json('success', 200);
    }
    
    public function terjual(Request $request) {
        // dd($request->all());
       $data = Data::with('tipe')->where(
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
                ->rawColumns(['nama']) // agar HTML tidak di-escape
                ->make(true);
        }
    }

    public function list($id) {
        $data = Data::find($id);

        return $data;
    }
}
