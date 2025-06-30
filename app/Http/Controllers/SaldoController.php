<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaldoAwal;
use DataTables;

class SaldoController extends Controller
{
    public function index(Request $request) {
         $data = SaldoAwal::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function store(Request $request) {
        
        $validated = $request->validate([
            'modal_awal' => 'required|numeric|min:0',
        ]);

        // Ambil data saldo pertama (karena hanya boleh satu)
        $saldo = SaldoAwal::first();

        if ($saldo) {
            $saldo->update(['nominal' => $validated['modal_awal']]);
            $message = 'Saldo berhasil diperbarui.';
        } else {
            $saldo = SaldoAwal::create(['nominal' => $validated['modal_awal']]);
            $message = 'Saldo berhasil dibuat.';
        }

        return response()->json([
            'message' => $message,
            'data' => $saldo,
        ]);
    }
}
