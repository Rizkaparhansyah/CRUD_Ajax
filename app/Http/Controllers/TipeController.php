<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Types;
use DataTables;

class TipeController extends Controller
{
    public function index(Request $request) {
         $data = Types::with(['kategori', 'merek'])->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('kategori', function ($row) {
                    return $row->kategori->nama ?? '-';
                })
                ->addColumn('merek', function ($row) {
                    return $row->merek->nama ?? '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '
                        <button type="button" class="btn btn-sm btn-primary editTipe"
                            data-id="'.$row->id.'"
                            data-nama="'.$row->nama.'"
                            data-kategori="'.$row->kategori_id.'"
                            data-merek="'.$row->merek_id.'">
                            Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-danger deleteTipe" data-id="'.$row->id.'">Hapus</button>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

    }
    public function store(Request $request) { 
        Types::updateOrCreate(
            ['id' => $request->id_nama_tipe]
            ,
            [
                'kategori_id' => $request->category_id,
                'merek_id' => $request->tipe_merek_motor,
                'nama' => $request->nama_tipe,
            ]);
        return response()->json('success', 200);
    }
    public function destroy($id) {
        Types::destroy($id);

        return response()->json('success', 200);
    }
}
