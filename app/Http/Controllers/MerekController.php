<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merek;
use DataTables;

class MerekController extends Controller
{
    public function index(Request $request) {
         $data = Merek::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editBtn = '<button type="button" class="btn btn-sm btn-primary editMerek" data-id="'.$row->id.'" data-nama="'.$row->nama.'">Edit</button>';
                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger deleteMerek" data-id="'.$row->id.'">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi']) // agar HTML tidak di-escape
                ->make(true);
        }
    }
    public function store(Request $request) { 
        Merek::updateOrCreate(['id' => $request->id_nama_merek],['nama' => $request->nama_merek]);
        return response()->json('success', 200);
    }
    public function destroy($id) {
        Merek::destroy($id);

        return response()->json('success', 200);
    }

}
