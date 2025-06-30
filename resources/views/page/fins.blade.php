@extends('data.index')

@section('title', 'Data Keuangan')

@section('content')
<div class="container mt-4 ">
    <a href="/" type="button" class="btn btn-outline-primary mb-4">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h1 class="mb-4 fw-bold">Dashboard Keuangan</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
        @foreach ($partnerList as $value)
            <div class="col">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body border-start border-{{$value['owner'] ? 'dark' : 'primary'}} border-4 bg-white rounded">
                        <h6 class="text-secondary"><i class="bi bi-info-circle me-1"></i> {{ $value['nama'] }}</h6>
                        <h4 class="fw-bold text-dark">Rp {{ number_format($value['total_diterima'], 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @php
            $cards = [
                ['Saldo Awal', $saldo_awal],
                ['Laba', $total_laba],
                ['Total Aset', $total_aset],
                ['Oprasional & Belanja', $oprasional],
                ['Uang Terpakai', $uang_terpakai],
                // ['Partner', $uang_partner],
                // ['Pemilik', $uang_pemilik],
                ['Sisa Modal', $sisa_saldo],
                ['Omset', $omset],
                ['Saldo Akhir', $saldo_akhir],
            ];
            @endphp
        
        
        @foreach ($cards as [$title, $value])
            <div class="col">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body border-start border-info border-4 bg-white rounded">
                        <h6 class="text-secondary"><i class="bi bi-info-circle me-1"></i> {{ $title }}</h6>
                        <h4 class="fw-bold text-dark">Rp {{ number_format($value, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row g-4 mt-4">
        <!-- Grafik Bar: Keuangan -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Analisis Keuangan</h5>
                </div>
                <div class="card-body">
                    <canvas id="keuanganChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik Pie: Proporsi Laba & Modal -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Proporsi Laba & Modal</h5>
                </div>
                <div class="card-body">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pieCtx = document.getElementById('pieChart');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Laba', 'Sisa Modal', 'Uang Terpakai', 'Pemilik', 'Omset'],
                datasets: [{
                    data: [{{ $total_laba }}, {{ $sisa_saldo }}, {{ $uang_terpakai }}],
                    backgroundColor: ['#0d6efd', '#198754','#dc3545',],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
  {{-- <script>
    const ctx = document.getElementById('keuanganChart').getContext('2d');
    const keuanganChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Saldo Awal', 'Total Aset', 'Operasional', 'Uang Terpakai',
                'Laba', 'Partner', 'Pemilik', 'Sisa Modal', 'Omset', 'Saldo Akhir'
            ],
            datasets: [{
                label: 'Jumlah (Rp)',
                data: [
                    {{ $saldo_awal }}, {{ $total_aset }}, {{ $oprasional }},
                    {{ $uang_terpakai }}, {{ $total_laba }}, {{ $uang_partner }},
                    {{ $uang_pemilik }}, {{ $sisa_saldo }}, {{ $omset }},
                    {{ $sisa_saldo + $uang_terpakai }}
                ],
                backgroundColor: [
                    '#0d6efd', '#6610f2', '#198754', '#dc3545',
                    '#ffc107', '#0dcaf0', '#6f42c1', '#20c997',
                    '#fd7e14', '#198754'
                ],
                borderRadius: 5,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Ringkasan Keuangan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
  </script> --}}
  @include('data.script')
@endpush
