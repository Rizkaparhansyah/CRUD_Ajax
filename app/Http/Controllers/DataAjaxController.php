<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Merek;
use App\Models\Types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Data::with(['fotos', 'biayas', 'tipe'])->get();
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    // Fungsi bantu untuk konversi format rupiah ke angka
    function rupiahToNumber($rupiah)
    {
        return (int) preg_replace('/[^0-9]/', '', $rupiah);
    }

    // Validasi input
    $request->validate([
        'nopol' => 'required',
        'warna' => 'required',
        'tahun' => 'required',
        'harga' => 'required|numeric',
    ]);

    // Simpan atau update data utama
    $data = Data::updateOrCreate(
        ['id' => $request->id_barang],
        [
            'kategori_id' => $request->category_id,
            'type_id'    => $request->nama,
            'merek_id'   => $request->merk,
            'nopol'      => $request->nopol,
            'warna'      => $request->warna,
            'tahun'      => $request->tahun,
            'harga'      => $request->harga,
            'pajak'      => $request->pajak,
        ]
    );

    // Daftar biaya tetap
    $biayaTetap = [
        [
            'nama' => 'Harga Barang',
            'nominal' => rupiahToNumber($request->hargaBarang)
        ],
        [
            'nama' => 'Biaya Pajak',
            'nominal' => rupiahToNumber($request->biaya_pajak)
        ],
        [
            'nama' => 'Oprasional',
            'nominal' => rupiahToNumber($request->oprasional)
        ],
    ];

    // Simpan biaya tetap dengan updateOrCreate
    foreach ($biayaTetap as $biaya) {
        $data->biayas()->updateOrCreate(
            ['nama' => $biaya['nama']],
            ['nominal' => $biaya['nominal']]
        );
    }

    // Ambil sparepart dari request (format JSON string)
    $sparepart_list = $request->sparepart_list ?? '[]';
    $spareparts = json_decode($sparepart_list, true) ?? [];

    // Simpan sparepart juga pakai updateOrCreate (berdasarkan nama)
    foreach ($spareparts as $sp) {
        $data->biayas()->updateOrCreate(
            ['nama' => $sp['nama']],
            ['nominal' => $sp['nominal']]
        );
    }

    // Hapus biaya yang tidak ada di input (sinkronisasi)
    $semuaNamaBiaya = collect($biayaTetap)->pluck('nama')
        ->merge(collect($spareparts)->pluck('nama'))->all();

    $data->biayas()->whereNotIn('nama', $semuaNamaBiaya)->delete();

    // Upload dan simpan foto jika ada
    if ($request->hasFile('fotos')) {
        foreach ($request->file('fotos') as $file) {
            $path = $file->store('uploads/data', 'public');
            $data->fotos()->create(['path' => $path]);
        }
    }

    return response()->json(['success' => true]);
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Data::where('id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Data::where('id', $id)->delete();
    }
    public function getSelect($id, $params)
    {
        if ($params === 'merek') {
            $data = Merek::where('kategori_id', $id)->get();
        } elseif ($params === 'type') {
            $data = Types::where('merek_id', $id)->get();
        } else {
            return response()->json(['error' => 'Param tidak dikenali'], 400);
        }

        return response()->json($data);
    }

}
