
<script>
    const formatRupiahToNumber = (str) => {
    return parseInt(str.replace(/[^0-9]/g, ''), 10) || 0;
    };
    const formatNumberToRupiah = (angka) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(angka);
    };

    let sparepartList = [];
    function hitung() {
        const pajak = formatRupiahToNumber($('#biaya_pajak').val()) || 0;
        const oprasional = formatRupiahToNumber($('#oprasional').val()) || 0;
        const hargabeli = formatRupiahToNumber($('#hargaBarang').val()) || 0;
        
        let totalSparepart = 0;
        sparepartList.forEach(item => {
            totalSparepart += parseInt(item.nominal);
        });
        const total = hargabeli + pajak + oprasional + totalSparepart;
        $('#totalHarga').html(formatNumberToRupiah(total));
        $('#harga').val(total);
    }

    function renderList() {
        let html = '';
        sparepartList.forEach((item, index) => {
       html += `
        <div class="d-flex justify-content-between fw-bold align-items-center border p-2 rounded mb-2">
            <div>${item.nama} - ${formatNumberToRupiah(item.nominal)}</div>
            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-index="${index}">
                <i class="bi bi-trash text-white"></i>
            </button>
        </div>
        `;

        });

        $('.list').html(html);
        $('#inputSpareparts').val(JSON.stringify(sparepartList));
    }

  
    $(document).on('click', '.btn-hapus', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const index = $(this).data('index');
        sparepartList.splice(index, 1);
        renderList();
    });

    function getAPI(url) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    resolve(response);
                },
                error: function (xhr) {
                    reject(xhr);
                }
            });
        });
    }
    function postAPI(url, data, method = 'POST') {
        return new Promise(function(resolve, reject) {
            $.ajax({
            url: url, // ganti sesuai route Laravel kamu
            type: method,
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                resolve(response);
            },
            error: function (xhr) {
                reject(xhr);
            }
            });
        });
    }
    function showDetailModal(data) {
        // Kosongkan isi sebelumnya
        $('#carouselFotoContainer').empty();
        $('#detailList').empty();

        // Isi carousel foto
        if (data.fotos && data.fotos.length > 0) {
            data.fotos.forEach((foto, index) => {
            const activeClass = index === 0 ? 'active' : '';
            const item = `
                <div class="carousel-item ${activeClass}">
                <img src="/storage/${foto.path}" class="d-block w-100" style="object-fit:cover; height:500px;" alt="Foto ${index + 1}">
                </div>
            `;
            $('#carouselFotoContainer').append(item);
            });
        } else {
            $('#carouselFotoContainer').html(`
            <div class="carousel-item active">
                <img src="https://via.placeholder.com/600x300?text=No+Image" class="d-block w-100" alt="No Image">
            </div>
            `);
        }
      
        // Isi detail kendaraan
        const detailHtml = `
            <li class="list-group-item text-uppercase fw-bold">JENIS/NOPOL: ${data.tipe.nama ?? '-'} - ${data.nopol ?? '-'}</li>
            <li class="list-group-item text-uppercase fw-bold">Warna: ${data.warna ?? '-'}</li>
            <li class="list-group-item text-uppercase fw-bold">Tahun: ${data.tahun ?? '-'}</li>
            <li class="list-group-item text-uppercase fw-bold">Pajak: ${data.pajak ?? '-'}</li>
            <li class="list-group-item text-uppercase">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Total Harga:</span>
                    <a class="btn btn-sm btn-link  text-uppercase fw-bold" data-bs-toggle="collapse" href="#hargaDetail" role="button" aria-expanded="false" aria-controls="hargaDetail">
                    Rp${Number(data.harga).toLocaleString()}
                    </a>
                </div>

                <div class="collapse mt-2" id="hargaDetail">
                    <ul class="list-group list-group-flush">
                    ${(data.biayas ?? []).map(biaya => `
                        <li class="list-group-item text-uppercase">${biaya.nama}: Rp${Number(biaya.nominal).toLocaleString()}</li>
                    `).join('')}
                    </ul>
                </div>
                </li>

        `;
        $('#detailList').html(detailHtml);

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        modal.show();
    }
    function showEditModal(data) {
        // Kosongkan isi sebelumnya
        console.log('data', data)
       
       let oprasional = data.biayas.find(item => item.nama === 'Oprasional');
       let hargaBeli = data.biayas.find(item => item.nama === 'Harga Barang');
       let biayaPajak = data.biayas.find(item => item.nama === 'Biaya Pajak');
       let sparepartLists = data.biayas
        .filter(item => !['Biaya Pajak', 'Oprasional', 'Harga Barang'].includes(item.nama))
        .map(item => ({
            id: item.id,
            nama: item.nama,
            nominal: item.nominal
        }));
        sparepartList = sparepartLists
        // console.log('sparepart', spareparts)
        console.log('sparepartList', sparepartList)

        $('#id_barang').val(data.id)
        $('#category_id').val(data.id).trigger('change')
        $('#merkmotor').val(data.merek_id).trigger('change')
        // Tunggu beberapa saat sebelum set #type
        setTimeout(function () {
        $('#type').val(data.type_id).trigger('change');
        }, 3000); 
        $('#nopol').val(data.nopol)
        $('#warna').val(data.warna)
        $('#tahun').val(data.tahun)
        $('#hargaBarang').val(hargaBeli.nominal )
        $('#pajak').val(data.pajak)
        $('#biaya_pajak').val(biayaPajak.nominal)
        $('#oprasional').val(oprasional.nominal)
        // $('#fotos').val(data.)
        // Tampilkan modal
        renderList()
        const modal = new bootstrap.Modal(document.getElementById('formModal'));
        modal.show();
    }

    $(document).ready(function () {
        $('#formModal').on('hidden.bs.modal', function () {
        $('#id_barang').val('');
        });
        async function renderData() {
            try {
                const dataList = await getAPI('/dataAjax');
                console.log('dataList', dataList)
                $('#fotosContainer').empty();

                dataList.forEach(data => {
                    const fotoPath = data.fotos && data.fotos.length > 0
                        ? `/storage/${data.fotos[0].path}`
                        : 'https://via.placeholder.com/300x200?text=No+Image';

                    const card = `
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 position-relative">
                            ${data.status == 1
                                ? `<i class="bi px-2 bg-success rounded bi-check text-white position-absolute top-0 end-0 m-2 fs-4"></i>`
                                : `<i class="bi px-2 rounded bg-white bi-hourglass-split text-warning position-absolute top-0 end-0 m-2 fs-4"></i>`
                            }

                            <img src="${fotoPath}" class="card-img-top img-fluid"
                                style="height: 200px; object-fit: cover;" alt="Foto Kendaraan">

                            <div class="card-body text-uppercase d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title fw-bold">${data.tipe?.nama ?? 'Tipe'} - ${data.nopol ?? 'Nopol'}</h5>
                                <p class="card-text">Warna: ${data.warna ?? '-'}</p>

                                <div class="d-flex justify-content-between">
                                <div class="fs-6">Harga Modal:</div>
                                <div class="fw-bold text-end text-primary">
                                    ${formatNumberToRupiah(data.biayas?.reduce((sum, item) => sum + (item.nominal || 0), 0))}
                                </div>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                <div class="fs-6">Harga Jual:</div>
                                <div class="fw-bold text-end text-success">
                                    ${formatNumberToRupiah(data.harga_terjual ?? 0)}
                                </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button onclick='showDetailModal(${JSON.stringify(data)})' class="btn btn-primary w-100">
                                <i class="bi bi-eye me-1"></i> Detail
                                </button>
                                <button onclick='showEditModal(${JSON.stringify(data)})' class="btn btn-warning w-100 text-white">
                                <i class="bi bi-pen me-1"></i> Edit
                                </button>
                            </div>
                            </div>
                        </div>
                        </div>
                    `;
                    $('#fotosContainer').append(card);
                });

            } catch (err) {
                console.error('Gagal ambil data:', err);
                alert('Gagal mengambil data. Cek console.');
            }
        }
        renderData()

    //TABLE
        function Table(table, url, columns = [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama', name: 'nama' },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ]) {
            $(table).DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                pageLength: 5, // ← hanya tampilkan table (tanpa search, pagination, info, dll)
                columns: columns
            });
        }

        Table('#kategoriTable', 'kategori')
        Table('#merekTable', 'merek')
        Table('#sparepartTable', 'sparepart')
        Table('#tipeTable', 'tipe', [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'kategori', name: 'kategori' }, // ← tampilkan nama kategori
            { data: 'merek', name: 'merek' },       // ← tampilkan nama merek
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]);
        Table('#pengeluaranTable', 'pengeluaran', [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'nominal', name: 'nominal' }, // ← tampilkan nama kategori
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
        ]);
        Table('#penjualanTable', 'list-terjual', [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'harga', name: 'harga', render: function(data, type, row) {
                return formatNumberToRupiah(data);
            } }, // ← tampilkan nama kategori
                    {
                data: 'bonus',
                name: 'bonus',
                render: function (data, type, row) {
                 return null;
            }}
            ,
 // ← tampilkan nama kategori
            { data: 'harga_terjual', name: 'harga_terjual', render: function(data, type, row) {
                return formatNumberToRupiah(data);
            } }, // ← tampilkan nama kategori
            { data: 'laba', name: 'laba', render: function(data, type, row) {
                return formatNumberToRupiah(data);
            } }, // ← tampilkan nama kategori
        ]);
        Table('#saldoAwalTable', 'saldo-modal', [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nominal', name: 'nominal' },
        ]);
        Table('#partnerTable', 'partner', [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'persentase', name: 'persentase' },
            { data: 'aksi', name: 'aksi' },
        ]);

    // END TABLE

    // fungsi reuseble crud
        function editCrud(init) {
            console.log('init', init);
            $(init.id).val(init?.valID);
            $(init.nama).val(init?.valNama); // ← perbaiki di sini
        }

        async function formCrud(init) {
            const response = await postAPI(init?.api?.url, init?.api?.data, init?.api?.method);
            
            $(init?.table).DataTable().ajax.reload();
            $(init?.idHide).val('')
            $(init?.form)[0].reset();
            return response;
        }
    // end fungsi reuseble crud

    // PARTNER

    $('#formPartner').on('submit', async function (e) {
        e.preventDefault();
        // let id = $('#kendaraan_id').val()
        const data = {
            api : {
                url: `partner`,
                data :  new FormData(this),
                // method : 'PATCH'
            },
            table: '#partnerTable',
            idHide: '#id_partner',
            form: '#formPartner',
        }
        const res = await formCrud(data)
        if(res.error){
            alert(res.message)
        }
    });

    $(document).on('click', '.editPartner', function () {
        let id = $(this).data('id');
        let nama = $(this).data('nama');
        let persentase = $(this).data('persentase');
        $('#persentase').val(persentase)
        console.log('persentase', persentase)
        const init = {
            id : '#id_partner',
            nama : '#nama_partner',
            valID : id,
            valNama : nama,
        }
        editCrud(init)
    });

    $(document).on('click', '.deletePartner', async function () {
        let id = $(this).data('id');
        await postAPI(`partner/${id}`, null, 'DELETE');
        $('#partnerTable').DataTable().ajax.reload();
    });

    $(document).on('click', '.ownwerPartner', async function () {
        const id = $(this).data('id');
        console.log('Set as Owner: ID', id);
        
        // Contoh AJAX: ubah ke Owner
        const data = {
            api : {
                url: `partner/${id}`,
                data :  null,
                method : 'PUT'
            },
            table: '#partnerTable',
            idHide: '',
            form: '#formPartner',
        }
        const res = await formCrud(data)
        console.log('first', res)
        alert(res.message)
    });
    
    $(document).on('click', '#kas', async function () {
        const data = {
            api : {
                url: `partner/kas`,
                method : 'POST'
            },
            table: '#partnerTable',
            idHide: '',
            form: '#formPartner',
        }
        const res = await formCrud(data)
        console.log('first', res)
        alert(res.message)
    });


    // END PARTNER

    // SALDO
    $('#formSaldoAwal').on('submit', async function (e) {
        e.preventDefault();
        // let id = $('#kendaraan_id').val()
        const data = {
            api : {
                url: `saldo-modal`,
                data :  new FormData(this),
                // method : 'PATCH'
            },
            table: '#saldoAwalTable',
            idHide: '#modal_awal',
            form: '#formSaldoAwal',
        }
        formCrud(data)
    });

    // END SALDO

    // PENJUALAN
    $('#formPenjualan').on('submit', async function (e) {
        e.preventDefault();
        // let id = $('#kendaraan_id').val()
        const data = {
            api : {
                url: `jual-unit`,
                data :  new FormData(this),
                // method : 'PATCH'
            },
            table: '#penjualanTable',
            idHide: '#idHidePenjualan',
            form: '#formPenjualan',
        }
        const res = await formCrud(data)
        console.log('first', res)
        alert(res.message)
    });

    $('#kendaraan_id').on('change', async function(){
        let id = $(this).val()
        try {
            const data = await getAPI(`list-terjual/${id}`);
            $('#penjualan_nominal').val(data.harga_terjual)
            const bonuses = data.bonus || [];

            $('input[name="id_partner[]"]').each(function (index) {
                const partnerId = $(this).val();
                const bonusInput = $('input[name="bonus_nominal[]"]').eq(index);

                const foundBonus = bonuses.find(b => b.partner_id == partnerId);

                if (foundBonus) {
                    bonusInput.val(foundBonus.nominal);
                } else {
                    bonusInput.val(''); // Kosongkan jika tidak ada
                }
            });
        } catch (err) {
            console.error('Gagal ambil data:', err);
            alert('Gagal mengambil data. Cek console.');
        }
    })
    

    // END PENJUALAN

    // KATEGORI

        $(document).on('click', '.editKategori', function () {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            const init = {
                id : '#idHideKategori',
                nama : '#nama_kategori',
                valID : id,
                valNama : nama,
            }
            editCrud(init)
        });
        
        $('#formKategori').on('submit', async function (e) {
            e.preventDefault();
            const data = {
                api : {
                    url: 'kategori',
                    data :  new FormData(this)
                },
                table: '#kategoriTable',
                idHide: '#idHideKategori',
                form: '#formKategori',
            }
            formCrud(data)
        });

        $(document).on('click', '.deleteKategori', async function () {
            let id = $(this).data('id');
            await postAPI(`kategori/${id}`, null, 'DELETE');
            $('#kategoriTable').DataTable().ajax.reload();
        });

    // END KATEGORI

    // MEREK

        $(document).on('click', '.editMerek', function () {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            const init = {
                id : '#id_nama_merek',
                nama : '#nama_merek',
                valID : id,
                valNama : nama,
            }
            editCrud(init)
        });
        
        $('#formMerek').on('submit', async function (e) {
            e.preventDefault();
            const data = {
                api : {
                    url: 'merek',
                    data :  new FormData(this)
                },
                table: '#merekTable',
                idHide: '#id_nama_merek',
                form: '#formMerek',
            }
            formCrud(data)
        });

        $(document).on('click', '.deleteMerek', async function () {
            let id = $(this).data('id');
            await postAPI(`merek/${id}`, null, 'DELETE');
            $('#merekTable').DataTable().ajax.reload();
        });

    // END MEREK

    // TIPE
        $(document).on('click', '.editTipe', function () {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let kategoriID = $(this).data('kategori');
            let merekID = $(this).data('merek');    
            
            $('#category_id').val(kategoriID)
            $('#tipe_merek_motor').val(merekID)
            $('#nama_tipe').val(nama)
            $('#id_nama_tipe').val(id)
        });
        
        $('#formTipe').on('submit', async function (e) {
            e.preventDefault();
            const data = {
                api : {
                    url: 'tipe',
                    data :  new FormData(this)
                },
                table: '#tipeTable',
                idHide: '#id_nama_tipe',
                form: '#formTipe',
            }
            formCrud(data)
        });

        $(document).on('click', '.deleteTipe', async function () {
            let id = $(this).data('id');
            await postAPI(`tipe/${id}`, null, 'DELETE');
            $('#tipeTable').DataTable().ajax.reload();
        });
    // END TIPE

    // SPAREPART

        $(document).on('click', '.editSparepart', function () {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            const init = {
                id : '#id_nama_sparepart',
                nama : '#nama_sparepart',
                valID : id,
                valNama : nama,
            }
            editCrud(init)
        });
        
        $('#formSparepart').on('submit', async function (e) {
            e.preventDefault();
            const data = {
                api : {
                    url: 'sparepart',
                    data :  new FormData(this)
                },
                table: '#sparepartTable',
                idHide: '#id_nama_sparepart',
                form: '#formSparepart',
            }
            formCrud(data)
        });

        $(document).on('click', '.deleteSparepart', async function () {
            let id = $(this).data('id');
            await postAPI(`sparepart/${id}`, null, 'DELETE');
            $('#sparepartTable').DataTable().ajax.reload();
        });

    // END SPAREPART

    // PENGELUARAN

        $(document).on('click', '.editPengeluaran', function () {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let nominal = $(this).data('nominal');
            $('#idHidePengeluaran').val(id)
            $('#nama_pengeluaran').val(nama)
            $('#pengeluaran_nominal').val(nominal)
            
        });
        
        $('#formPengeluaran').on('submit', async function (e) {
            e.preventDefault();
            const data = {
                api : {
                    url: 'pengeluaran',
                    data :  new FormData(this)
                },
                table: '#pengeluaranTable',
                idHide: '#id_nama_pengeluaran',
                form: '#formPengeluaran',
            }
            const res = await formCrud(data)
            console.log('first', res)
            alert(res.message)
            renderData()
        });

        $(document).on('click', '.deletePengeluaran', async function () {
            let id = $(this).data('id');
            await postAPI(`pengeluaran/${id}`, null, 'DELETE');
            $('#pengeluaranTable').DataTable().ajax.reload();
        });

    // END PENGELUARAN


    document.querySelectorAll('.rupiah').forEach(input => {
        input.addEventListener('input', function () {
            hitung()
            let angka = this.value.replace(/[^0-9]/g, '');
            this.value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        });
    });

    
    async function select(id, selectId, params){
        if (!id) {
            $(selectId).html('<option value="">-- PILIH --</option>');
            return;
        }
        
        try {
            const merek = await getAPI(`merek/${id}/${params}`);
            let options = '<option value="">-- PILIH --</option>';
            merek.forEach(item => {
                options += `<option value="${item.id}">${item.nama}</option>`;
            });
            $(selectId).html(options);
        } catch (err) {
            console.error('Gagal ambil data:', err);
            alert('Gagal mengambil data. Cek console.');
        }
    }

        // $('#category_id').on('change', async function () {
        //     const id = $(this).val();
        //     select(id, '#merkmotor', 'merek')
        // });

        $('#merkmotor').on('change', async function () {
            const id = $(this).val();
            select(id, '#type', 'type')
        });


        $('#addBtn').on('click', function () {
            const sparepartId = $('#sparepart').val();
            const sparepartText = $('#sparepart option:selected').text();
            const harga = $('#hargaSparepart').val();

            if (!sparepartId) {
            alert('Silakan pilih sparepart dan isi nominal yang valid');
            return;
            }

            // Cek apakah sparepart sudah ada dalam list
            const existing = sparepartList.find(item => item.id === sparepartId);

            if (existing) {
            // Jika sudah ada, tambahkan nominalnya
            existing.nominal += harga;
            } else {
            // Jika belum, tambahkan item baru
            sparepartList.push({
                id: sparepartId,
                nama: sparepartText,
                nominal: formatRupiahToNumber(harga)
            });
            }

            // Reset input
            $('#sparepart').val('');
            $('#hargaSparepart').val('');
            hitung()
            renderList();
        });

     
        
        
        //post data
        
        $('#formBarang').on('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const response = await postAPI(`dataAjax`, formData);
            // console.log('response', response)
            alert('Data berhasil disimpan!');
            $('#formBarang')[0].reset(); // reset form
            $('.list').empty(); // hapus list sparepart
            sparepartList.length = 0; // reset array
            $('#inputSpareparts').val('');
            $('#formModal').modal('hide');
            renderData()
        });

        


    });
</script>