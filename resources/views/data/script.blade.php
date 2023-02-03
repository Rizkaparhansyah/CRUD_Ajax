<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            processing: true,
            serverside: true,
            ajax: "{{url('dataAjax')}}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'sumber_dana',
                    name: 'sumber_dana',
                },
                {
                    data: 'program',
                    name: 'program',
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                }
            ],
            initComplete: function() {
                var selectOptions = [];
                var columnData = table.column(1).data();

                $.each(columnData, function(index, value) {
                    if ($.inArray(value, selectOptions) === -1) {
                        selectOptions.push(value);
                    }
                });

                $.each(selectOptions, function(index, value) {
                    $('#filter_sumber_dana').append($('<option>', {
                        value: value,
                        text: value
                    }));
                });

            },
        });

        // reload page
        $(document).ready(function() {
            $("#button-reload").click(function() {
                location.reload();
            });
        });
        $('#filter-keterangan').change(function() {
            table.column(3).search($(this).val())
                .draw();
        })
        $('#filter_sumber_dana').on('change', function() {
            table.column(1).search(this.value).draw();
        });
    });


    // GLOBAL SETUP 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // 02_PROSES SIMPAN 
    $('body').on('click', '.tombol-tambah', function(e) {
        e.preventDefault();
        $('#exampleModal').modal('show');
        $('.tombol-simpan').click(function() {
            simpan();
        });
    });



    // proses edit
    $('body').on('click', '.tombol-edit', function(e) {
        var id = $(this).data('id');
        $.ajax({
            url: 'dataAjax/' + id + '/edit',
            type: 'GET',
            success: function(response) {
                $('#exampleModal').modal('show');
                $('#sumber_dana').val(response.result.sumber_dana);
                $('#program').val(response.result.program);
                $('#keterangan').val(response.result.keterangan);
                $('.tombol-simpan').click(function() {
                    simpan(id);
                })

            }
        })
    });


    // fungsi simpan dan update
    function simpan(id = '') {
        if (id == '') {
            var var_url = 'dataAjax';
            var var_type = 'POST';
        } else {
            var var_url = 'dataAjax/' + id;
            var var_type = 'PUT';
        }
        $.ajax({
            url: var_url,
            type: var_type,
            data: {
                sumber_dana: $('#sumber_dana').val(),
                program: $('#program').val(),
                keterangan: $('#keterangan').val()
            },
            success: function(response) {
                if (response.errors) {
                    console.log(response.errors);
                    $('.alert-danger').removeClass('d-none');
                    $('.alert-danger').html("<ul>");
                    $.each(response.errors, function(key, value) {
                        $('.alert-danger').find('ul').append("<li>" + value +
                            "</li>");
                    });
                    $('.alert-danger').append("</ul>");
                } else {
                    $('.alert-success').removeClass('d-none');
                    $('.alert-success').html(response.success);
                }
                $('#myTable').DataTable().ajax.reload();
            }
        });
    }




    // proses delete
    $('body').on('click', '.tombol-del', function(e) {
        if (confirm('Yakin mau hapus data ini?') == true) {
            var id = $(this).data('id');
            $.ajax({
                url: 'dataAjax/' + id,
                type: 'DELETE',
            });
            $('#myTable').DataTable().ajax.reload();
        } else {

        }
    });



    // get modal & value
    $('#exampleModal').on('hidden.bs.modal', function() {
        $('#sumber_dana').val('');
        $('#program').val('');
        $('#keterangan').val('');

        $('.alert-danger').addClass('d-none');
        $('.alert-danger').html('');

        $('.alert-success').addClass('d-none');
        $('.alert-success').html('');
    });
</script>