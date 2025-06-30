<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use DataTables;

class PartnerController extends Controller
{
    public function index(Request $request) {
         $data = Partner::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                        $ownerLabel = $row->owner ? 'Owner' : 'Set sbg Owner';
                        $ownerBG = $row->owner ? 'info' : 'success';
                       
                        $ownerBtn = '<button type="button" class="btn btn-sm btn-'.$ownerBG.' text-white ownwerPartner" data-id="' . $row->id . '">' . $ownerLabel . '</button>';

                        $editBtn = '<button type="button" class="btn btn-sm btn-primary editPartner" data-persentase="' . $row->persentase . '" data-id="' . $row->id . '" data-nama="' . $row->nama . '">Edit</button>';

                        $deleteBtn = '<button type="button" class="btn btn-sm btn-danger deletePartner" data-persentase="' . $row->persentase . '" data-id="' . $row->id . '">Hapus</button>';
                        return  $row->kas ? $editBtn : $ownerBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                    })

                ->rawColumns(['aksi']) // agar HTML tidak di-escape
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'nama_partner' => 'required|string',
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        // Hitung total persentase semua partner KECUALI yang sedang diedit (jika ada)
        $totalPersentase = Partner::where('id', '!=', $request->id_partner)->sum('persentase');

        // Tambahkan persentase yang dikirim user
        $totalPersentase += $request->persentase;

        // Cek apakah total melebihi 100
        if ($totalPersentase > 100) {
            return response()->json([
                'error' => 'Total persentase partner tidak boleh melebihi 100%. Saat ini: ' . $totalPersentase . '%'
            ], 422);
        }

        Partner::updateOrCreate(
            ['id' => $request->id_partner],
            ['nama' => $request->nama_partner, 'persentase' => $request->persentase]
        );

        return response()->json('success', 200);
    }

    public function update($id, Request $request) {
          // Set semua partner menjadi bukan owner (false)
        Partner::where('owner', 1)->update(['owner' => 0]);

        // Set partner dengan ID yang dimaksud sebagai owner
        $partner = Partner::findOrFail($id);
        $partner->owner = 1;
        $partner->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Partner telah diatur sebagai owner.'
        ]);
    }
    public function kas() {
      Partner::updateOrCreate(
                ['kas' => 1], // kondisi unik (partner dengan kas = 1 sudah ada)
                [
                    'nama' => 'KAS',
                    'persentase' => 10,
                    'kas' => 1
                ]
            );

            return response()->json(['message' => 'Data kas berhasil disimpan.']);
    }

    public function destroy($id) {
        Partner::destroy($id);

        return response()->json('success', 200);
    }

}
