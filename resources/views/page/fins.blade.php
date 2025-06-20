@extends('data.index')

@section('title', 'Data Keuangan')

@section('content')
    <a href="/" type="button" class="btn btn-primary mb-4">
        Back
    </a>
    <h1>DATA KEUANGAN</h1>
    <div class="row mt-5">
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Saldo Awal</h5>
            <h1 class="fw-bold">Rp {{ number_format($saldo_awal, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Total aset</h5>
            <h1 class="fw-bold">Rp {{ number_format($total_aset, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Biaya Oprasional dan belanjaan</h5>
            <h1 class="fw-bold">Rp {{ number_format($oprasional, 0, ',', '.') }}</h1>
            </div>
        </div>
        {{-- <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Oprasional</h5>
            <h1 class="fw-bold">Rp {{ number_format($oprasional1, 0, ',', '.') }}</h1>
            </div>
        </div> --}}
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Uang terpakai</h5>
            <h1 class="fw-bold">Rp {{ number_format($uang_terpakai, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Laba</h5>
            <h1 class="fw-bold">Rp {{ number_format($total_laba, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Partner</h5>
            <h1 class="fw-bold">Rp {{ number_format($uang_partner, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Pemilik  </h5>
            <h1 class="fw-bold">Rp {{ number_format($uang_pemilik, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
                <h5><i class="bi bi-info-circle me-1"></i> Sisa Modal</h5>
                <h1 class="fw-bold">Rp {{ number_format($sisa_saldo, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Omset</h5>
            <h1 class="fw-bold">Rp {{ number_format($omset, 0, ',', '.') }}</h1>
            </div>
        </div>
        <div class="col-4 sol-sm-12">
            <div class="p-3 mb-3 border-start border-info border-4 bg-white rounded">
            <h5><i class="bi bi-info-circle me-1"></i> Saldo Akhir</h5>
            <h1 class="fw-bold">Rp {{ number_format($sisa_saldo+$uang_terpakai, 0, ',', '.') }}</h1>
            </div>
        </div>
    </div>

@endsection
@push('js')
  @include('data.script')
@endpush