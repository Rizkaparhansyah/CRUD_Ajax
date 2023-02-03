<?php

namespace App\Http\Controllers;

use App\Models\Data;
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


        $data = Data::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($data) {
                return view('data.tombol')->with('data', $data);
            })
            ->make(true);
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
        $validasi = Validator::make($request->all(), [
            'sumber_dana' => 'required',
            'program' => 'required',
            'keterangan' => 'required',
        ], [
            'sumber_dana.required' => ' Sumber Dana Wajib Di Isi',
            'program.required' => ' Program Wajib Di Isi',
            'keterangan.required' => 'Keterangan Wajib Di Isi',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'sumber_dana' => $request->sumber_dana,
                'program' => $request->program,
                'keterangan' => $request->keterangan,
            ];
            Data::create($data);
            return response()->json(['success' => "Berhasil menyimpan data"]);
        }
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
        $validasi = Validator::make($request->all(), [
            'sumber_dana' => 'required',
            'program' => 'required',
            'keterangan' => 'required',
        ], [
            'sumber Dana.required' => ' Sumber Dana Wajib Di Isi',
            'program.required' => ' Program Wajib Di Isi',
            'keterangan.required' => 'Keterangan Wajib Di Isi',
        ]);

        if ($validasi->fails()) {
            return response()->json(['errors' => $validasi->errors()]);
        } else {
            $data = [
                'sumber_dana' => $request->sumber_dana,
                'program' => $request->program,
                'keterangan' => $request->keterangan,
            ];
            Data::where('id', $id)->update($data);
            return response()->json(['success' => "Berhasil Melakukan Update Data"]);
        }
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
    public function ajax()
    {
    }
}
