<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparepart;
use DataTables;

class SparepartController extends Controller
{
     public function index(Request $request) {
         $data = Sparepart::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editBtn = '<button type="button" class="btn btn-sm btn-primary editSparepart" data-id="'.$row->id.'" data-nama="'.$row->nama.'">Edit</button>';
                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger deleteSparepart" data-id="'.$row->id.'">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi']) // agar HTML tidak di-escape
                ->make(true);
        }
    }
    public function store(Request $request) { 
        Sparepart::updateOrCreate(['id' => $request->id_nama_sparepart],['nama' => $request->nama_sparepart]);
        return response()->json('success', 200);
    }
    public function destroy($id) {
        Sparepart::destroy($id);

        return response()->json('success', 200);
    }
}
