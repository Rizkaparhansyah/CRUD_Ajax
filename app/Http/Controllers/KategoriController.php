<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Kategori::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    $editBtn = '<button type="button" class="btn btn-sm btn-primary editKategori" data-id="'.$row->id.'" data-nama="'.$row->nama.'">Edit</button>';
                    $deleteBtn = '<button type="button" class="btn btn-sm btn-danger deleteKategori" data-id="'.$row->id.'">Hapus</button>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['aksi']) // agar HTML tidak di-escape
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        // return view('data.barang');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Kategori::updateOrCreate(['id' => $request->idHideKategori],['nama' => $request->nama_kategori]);
        return response()->json('success', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $Kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $Kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resouKategorie.
     *
     * @param  \App\Models\Kategori  $Kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $Kategori)
    {
        //
    }

    /**
     * Update the specified resouKategorie in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $Kategori
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        dd($id, $request);
    }

    /**
     * Remove the specified resouKategorie from storage.
     *
     * @param  \App\Models\Kategori  $Kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kategori::destroy($id);

        return response()->json('success', 200);

    }
}
