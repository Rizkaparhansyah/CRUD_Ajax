@extends('data.index')

@section('title', 'Data Barang')

@section('content')
   <!-- Tombol Hamburger (hanya muncul di layar kecil) -->
    <nav class="navbar bg-light d-md-none">
        <div class="container-fluid">
            <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                <i class="bi bi-list fs-3"></i>
            </button>
            <span class="navbar-brand mb-0 h1">Menu</span>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar: Offcanvas untuk mobile, visible tetap untuk desktop -->
        <div class="offcanvas-md offcanvas-start bg-light p-3 border-end" tabindex="-1" id="sidebarMenu" style="width: 250px;">
            <div class="offcanvas-header d-md-none">
                <h5 class="offcanvas-title">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body p-3">
                <div class="d-flex flex-column gap-2">
                    <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#formModalPenjualan">
                        <i class="bi bi-cart-plus"></i> Entry Penjualan & Set Bonus
                    </button>
                    
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#formModal">
                        <i class="bi bi-box-seam"></i> Entry Unit
                    </button>

                    <a href="/fins" class="btn btn-outline-dark d-flex align-items-center gap-2">
                        <i class="bi bi-journal-text"></i> FINS
                    </a>

                    <button type="button" class="btn btn-outline-warning d-flex align-items-center gap-2 text-dark" data-bs-toggle="modal" data-bs-target="#formModalPengeluaran">
                        <i class="bi bi-cash-stack"></i> Pengeluaran
                    </button>

                    <button type="button" class="btn btn-outline-info d-flex align-items-center gap-2 text-dark" data-bs-toggle="modal" data-bs-target="#formModalSetmodal">
                        <i class="bi bi-gear"></i> Set modal
                    </button>

                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#formModalPartner">
                        <i class="bi bi-people"></i> Partner
                    </button>

                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#formModalKategori">
                        <i class="bi bi-tags"></i> Kategori
                    </button>
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#formModalMerek">
                        <i class="bi bi-building"></i> Merek
                    </button>

                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#formModalTipe">
                        <i class="bi bi-car-front-fill"></i> Tipe
                    </button>

                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#formModalSparepart">
                        <i class="bi bi-tools"></i> Sparepart
                    </button>

                    
                </div>
            </div>

        </div>

        <!-- Konten Utama -->
        <div class="flex-grow-1 p-4">
            <h1 class="mb-4">Selamat Datang</h1>

            <!-- Konten data card -->
            <div id="fotosContainer" class="row">
                <!-- Card akan ditambahkan di sini -->
            </div>
        </div>
    </div>


    {{-- MODAL AWAL --}}
    <div class="modal fade" id="formModalSetmodal" tabindex="-1" aria-labelledby="formModalSetmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="formSaldoAwal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalSetmodalLabel">Form Modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            
                            <div class="col-md-12">
                                <label for="modal_awal" class="form-label">Nominal</label>
                                <input type="number" class="form-control" name="modal_awal"  id="modal_awal" placeholder="3200000">
                            </div>
                            
                        </div>
                        <table id="saldoAwalTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END MODAL AWAL --}}
    

    {{-- MODAL PARTNER --}}
    <div class="modal fade" id="formModalPartner" tabindex="-1" aria-labelledby="formModalPartnerLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formPartner">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalPartnerLabel">Form Partner</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            
                            <div class="col-md-12">
                                <label for="nama_partner" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama_partner"  id="nama_partner" placeholder="Dian">
                                <input type="hidden" class="form-control" name="id_partner"  id="id_partner" placeholder="0">
                            </div>
                            <div class="col-md-12">
                                <label for="persentase" class="form-label">Persentase</label>
                                <input type="number" class="form-control text-uppercase" name="persentase"  id="persentase" placeholder="10">
                            </div>
                        </div>
                        <table id="partnerTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Persentase</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END MODAL PARTNER --}}
    
    {{-- MODAL PENJUALAN --}}
    <div class="modal fade" id="formModalPenjualan" tabindex="-1" aria-labelledby="formModalPenjualanLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formPenjualan">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalPenjualanLabel">Form Penjualan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="kendaraan_id" class="form-label">Untuk Kendaraan</label>
                                <select name="kendaraan_id" class="form-select" id="kendaraan_id">
                                    <option value="">-- PILIH KENDARAAN --</option>
                                    
                                    @foreach ($tipes as $item)
                                    <option value="{{$item->id}}">{{$item->nama}} - {{$item->nopol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-12">
                                <label for="penjualan_nominal" class="form-label">NOMINAL</label>
                                <input type="number" class="form-control text-uppercase" name="penjualan_nominal"  id="penjualan_nominal" placeholder="1.000.000">
                            </div>
                            
                            <div class="col-md-12">
                                <label for="bonus_nominal" class="form-label">BONUS (jika ada)</label>
                                {{-- <input type="number" class="form-control text-uppercase" name="bonus_nominal"  id="bonus_nominal" placeholder="1.000.000"> --}}
                               @foreach ($partner as $item)
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-12 col-md-6">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-people fs-4"></i>
                                                <div class="fw-bold">{{ $item->nama }}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <!-- Tambahkan input hidden untuk id partner -->
                                            <input type="hidden" name="id_partner[]" value="{{ $item->id }}">
                                            <input 
                                                type="number" 
                                                class="form-control text-uppercase" 
                                                name="bonus_nominal[]" 
                                                placeholder="1.000.000"
                                            >
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <table id="penjualanTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga Modal</th>
                                    <th>Bonus Partner</th>
                                    <th>Nominal</th>
                                    <th>Laba</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END MODAL PENJUALAN --}}
    
    {{-- MODAL PENGELUARAN --}}
    <div class="modal fade" id="formModalPengeluaran" tabindex="-1" aria-labelledby="formModalPengeluaranLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="formPengeluaran">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalPengeluaranLabel">Form Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="tipes_id" class="form-label">Untuk Kendaraan</label>
                                <select name="tipes_id" class="form-select" id="tipes_id">
                                    <option value="">-- PILIH KENDARAAN --</option>
                                    
                                    @foreach ($tipes as $item)
                                    <option value="{{$item->id}}">{{$item->nama}} - {{$item->nopol}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="nama_pengeluaran" class="form-label">Nama</label>
                                <input type="text" class="form-control text-uppercase" name="nama_pengeluaran"  id="nama_pengeluaran" placeholder="Kunci Shock">
                                <input type="hidden" class="form-control text-uppercase" name="idHidePengeluaran"  id="idHidePengeluaran" placeholder="Motor">
                            </div>
                            <div class="col-md-12">
                                <label for="pengeluaran_nominal" class="form-label">NOMINAL</label>
                                <input type="number" class="form-control text-uppercase" name="pengeluaran_nominal"  id="pengeluaran_nominal" placeholder="20000">
                            </div>
                        </div>
                        <table id="pengeluaranTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END MODAL PENGELUARAN --}}

    {{-- MODAL KATEGORI --}}
    <div class="modal fade" id="formModalKategori" tabindex="-1" aria-labelledby="formModalKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="formKategori">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalKategoriLabel">Form Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="nama_kategori" class="form-label">Nama</label>
                                <input type="text" class="form-control text-uppercase" name="nama_kategori"  id="nama_kategori" placeholder="Motor">
                                <input type="hidden" class="form-control text-uppercase" name="idHideKategori"  id="idHideKategori" placeholder="Motor">
                            </div>
                        </div>
                        <table id="kategoriTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END MODAL KATEGORI --}}
    
    {{-- MODAL MEREK --}}
    <div class="modal fade" id="formModalMerek" tabindex="-1" aria-labelledby="formModalMerekLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="formMerek">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalMerekLabel">Form Merek</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="nama_merek" class="form-label">Nama</label>
                                <input type="text" class="form-control text-uppercase" name="nama_merek"  id="nama_merek" placeholder="Honda">
                                <input type="hidden" class="form-control text-uppercase" name="id_nama_merek"  id="id_nama_merek" placeholder="Honda">
                            </div>
                        </div>
                        <table id="merekTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END MODAL MEREK --}}

    {{-- MODAL TIPE --}}
    <div class="modal fade" id="formModalTipe" tabindex="-1" aria-labelledby="formModalTipeLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="formTipe">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalTipeLabel">Form Tipe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="category_id" class="form-label">Kategori Barang</label>
                                <select name="category_id" class="form-select" id="category_id">
                                    <option value="">-- PILIH KATEGORI --</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="tipe_merek_motor" class="form-label">Merek Barang</label>
                                <select name="tipe_merek_motor" class="form-select" id="tipe_merek_motor">
                                    <option value="">-- PILIH --</option>
                                    @foreach ($merek as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="nama_tipe" class="form-label">Nama</label>
                                <input type="text" class="form-control text-uppercase" name="nama_tipe"  id="nama_tipe" placeholder="VARIO KZR 125">
                                <input type="hidden" class="form-control text-uppercase" name="id_nama_tipe"  id="id_nama_tipe" placeholder="Honda">
                            </div>
                        </div>
                        <table id="tipeTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Merek</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END TIPE --}}

    {{-- MODAL SPAREPARTS --}}
    <div class="modal fade" id="formModalSparepart" tabindex="-1" aria-labelledby="formModalSparepartLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="formSparepart">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalSparepartLabel">Form Spareparts</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="nama_sparepart" class="form-label">Nama</label>
                                <input type="text" class="form-control text-uppercase" name="nama_sparepart"  id="nama_sparepart" placeholder="Oli">
                                <input type="hidden" class="form-control text-uppercase" name="id_nama_sparepart"  id="id_nama_sparepart" placeholder="Honda">
                            </div>
                        </div>
                        <table id="sparepartTable" class="w-100 table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- END SPAREPARTS --}}

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form id="formBarang" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Form Unit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" class="form-control" name="id_barang"  id="id_barang">

                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Kategori Barang</label>
                                <select name="category_id" class="form-select" id="category_id">
                                    <option value="">-- PILIH KATEGORI --</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="merk" class="form-label">Merk</label>
                                <select name="merk" id="merkmotor" class="form-select">
                                    <option value="">-- PILIH --</option>
                                    <!-- <option value="1">Yamaha</option> -->
                                    @foreach ($merek as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="nama" class="form-label">Tipe</label>
                                <select name="nama" id="type" class="form-select">
                                    <option value="">-- PILIH --</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="nopol" class="form-label">Nopol</label>
                                <input type="text" class="form-control text-uppercase" name="nopol"  id="nopol" placeholder="Z 9999 XXX">
                            </div>

                            <div class="col-md-6">
                                <label for="warna" class="form-label">Warna</label>
                                <input type="text" class="form-control text-uppercase" name="warna" id="warna"  placeholder="Hitam">
                            </div>

                            <div class="col-md-6">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="text" class="form-control" name="tahun" id="tahun" placeholder="2000">
                            </div>

                            <div class="col-md-6">
                                <label for="harga" class="form-label">Harga Beli</label>
                                <input type="text" class="form-control rupiah" name="hargaBarang" id="hargaBarang" placeholder="1200000">
                            </div>

                            <div class="col-md-6">
                                <label for="biaya_pajak" class="form-label">Biaya Pajak (jika ada)</label>
                                <input type="text" class="form-control rupiah" id="biaya_pajak" name="biaya_pajak" placeholder="1200000">
                            </div>

                            <div class="col-md-6">
                                <label for="pajak" class="form-label">Tanggal Pajak</label>
                                <input type="date" class="form-control" id="pajak" name="pajak" placeholder="12-30-2000">
                            </div>

                            <!-- Sparepart section -->
                            <div class="col-md-12">
                                <label for="sparepart" class="form-label">Sparepart</label>
                                <div class="d-flex gap-2">
                                    <select class="form-select" id="sparepart">
                                        <option value="">-- PILIH Sparepart --</option>
                                        @foreach ($sparepart as $item)
                                        <option value="{{$item->id}}">{{$item->nama}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control rupiah" id="hargaSparepart" placeholder="Harga Sparepart">
                                    <button type="button" class="btn btn-success" id="addBtn">+</button>
                                </div>
                                <div class="list mt-2 ms-5"></div>
                            </div>
                            <input type="hidden" name="sparepart_list" id="inputSpareparts">
                            <!-- end Sparepart section -->
                            
                            <div class="col-md-6">
                                <label for="oprasional" class="form-label">Oprasional</label>
                                <input type="text" class="form-control rupiah" id="oprasional" name="oprasional" placeholder="1200000">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="fotos" class="form-label">Foto</label>
                                <input type="file" class="form-control" name="fotos[]" id="fotos" placeholder="Upload file" multiple>
                            </div>

                            {{-- <div class="col-md-6"> --}}
                                <label for="harga" class="form-label">Harga Total</label>
                                <div id="totalHarga" class="fw-bold" style="font-size: 100px"></div>
                                <input type="hidden" class="form-control" name="harga" id="harga" placeholder="Total Harga">
                            {{-- </div> --}}
                            
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="hitung()">hitung</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END MODAL TAMBAH -->
    
    <!-- MODAL DETAIL -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body ">
                {{-- <div class="row"> --}}
                <div class="col-md-12 mb-5">
                    <!-- Carousel -->
                    <div id="fotoCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carouselFotoContainer">
                            <!-- Carousel items injected here -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#fotoCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#fotoCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>

            {{-- </div> --}}
                <div class="col-md-12">
                    <ul class="list-group" id="detailList">
                    <!-- Data detail kendaraan -->
                    </ul>
                    <ul class=" ms-5" id="detailHarga">
                    <!-- Data detail kendaraan -->
                    </ul>
                </div>
            </div>

            </div>
        </div>
    </div>

   
    
    
   
@endsection
@push('js')
  @include('data.script')
@endpush