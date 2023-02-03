<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
</head>

<body class="bg-light">
    <main class="container">
        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <!-- TOMBOL TAMBAH DATA -->
            <div class="pb-3 d-flex gap-4">
                <a href='' class="btn btn-primary tombol-tambah">+ Tambah Data</a>
                <div class="dropdown d-flex">

                    <select id="filter_sumber_dana" class="form-select me-3">
                        <option value="">Select Sumber Dana</option>

                    </select>
                    <select id="filter-keterangan" class="form-select">
                        <option value="">Select Keterangan</option>
                        <option value="Ada">Ada</option>
                        <option value="Tidak Ada">Tidak Ada</option>
                    </select>
                </div>
            </div>
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-3">Sumber Dana</th>
                        <th class="col-md-3">Program</th>
                        <th class="col-md-2">Keterangan</th>
                        <th class="col-md-3">Aksi</th>
                    </tr>
                </thead>
            </table>
            <button class="btn btn-primary" id="button-reload">Reload Table</button>
        </div>
        <!-- AKHIR DATA -->
    </main>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- START FORM -->
                    <div class="alert alert-danger d-none"></div>
                    <div class="alert alert-success d-none"></div>

                    <div class="mb-3 row">
                        <label for="sumber_dana" class="col-sm-2 col-form-label">Sumber Dana</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name='sumber_dana' id="sumber_dana">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="program" class="col-sm-2 col-form-label">Program</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name='program' id="program">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class=" col-sm-10 ">
                            <select name="keterangan" class="form-select" id="keterangan">
                                <option value="Ada">Ada</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                            </select>
                        </div>
                    </div>
                    <!-- AKHIR FORM -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary tombol-simpan">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    @include('data.script')
</body>

</html>