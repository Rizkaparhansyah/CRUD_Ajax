@extends('data.index')

@section('title', 'Data Barang')

@section('content')
    
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formModal">
        Tambah Barang
    </button>

    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formModalKategori">
        Kategori
    </button>

    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formModalMerek">
        Merek
    </button>

    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formModalTipe">
        Tipe
    </button>

    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formModalSparepart">
        Saprepart
    </button>
    
    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#formModalPengeluaran">
        Pengeluaran
    </button>
    
    <a href="/fins" type="button" class="btn btn-primary mb-4">
        FINS
    </a>
    
        <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#formModalPenjualan">
            Tambah Penjualan
        </button>
    
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
                                <input type="number" class="form-control text-uppercase" name="bonus_nominal"  id="bonus_nominal" placeholder="1.000.000">
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
                                <input type="text" class="form-control text-uppercase" name="nama_pengeluaran"  id="nama_pengeluaran" placeholder="Solder">
                                <input type="hidden" class="form-control text-uppercase" name="idHidePengeluaran"  id="idHidePengeluaran" placeholder="Motor">
                            </div>
                            <div class="col-md-12">
                                <label for="pengeluaran_nominal" class="form-label">NOMINAL</label>
                                <input type="number" class="form-control text-uppercase" name="pengeluaran_nominal"  id="pengeluaran_nominal" placeholder="Solder">
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

    {{-- ENDMODALDETIAL --}}
        <!-- START DATA -->
        <!-- Tempat render semua card -->
    <div id="fotosContainer" class="row ">
            <!-- Card akan ditambahkan di sini -->
    </div>
    <!-- END DATA -->
    
    
   
@endsection
@push('js')
  @include('data.script')
@endpush