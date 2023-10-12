<?= form_open('beasiswa/deleteselect', ['class' => 'formhapus']) ?>

<button type="submit" class="btn btn-danger btn" id="btn-dels">
    <i class="fa fa-trash"></i> Hapus yang Diceklist 
</button>

<hr>
<div class="table-responsive">
    <table id="listbeasiswa" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="thead-light">
            <tr>
                <th>
                    <input type="checkbox" id="centangSemua">
                </th>
                <th>NIS</th>
                <th>Bsw Kode</th>
                <th>Nama</th>
                <th>Program</th>
                <th>Status</th>
                <th>Daftar</th>
                <th>SPP-1</th>
                <th>SPP-2</th>
                <th>SPP-3</th>
                <th>SPP-4</th>
                <th>Dibuat</th>
                <th>Dipakai</th>
                <th></th>
            </tr>
        </thead>


        <tbody>

        </tbody>
    </table>
    <?= form_close() ?>
</div>

<script>
    function getdata_beasiswa() {
        var table = $('#listbeasiswa').DataTable({
            "processing": true,
            "serverside": true,
            "scrollY": "500px",
            "scrollX":  true,
            "scrollCollapse": true,
            "fixedColumns":   {
                "left": 2
            },
            "order": [],
            "ajax": {
                "url": "<?= site_url('beasiswa/getdata') ?>",
                "type": "POST",
                'dataSrc': function (json) {
                    if (json.userLevel == 1) {
                        $('#btn-dels').show();
                    } else {
                        $('#btn-dels').hide();
                    }
                    return json.data;
                }
            },
            "columnDefs": [{
                    "targets": 0,
                    "orderable": false,
                },
                {
                    "targets": -1,
                    "orderable": false,
                },
            ],
            buttons: [],
            columnDefs: [{
                targets: -1,
                visible: false
            }],
            dom: "<'row px-2 px-md-4 pt-2'<'col-md-3'l><'col-md-5 text-center py-2'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row px-2 px-md-4 py-3'<'col-md-5'i><'col-md-7'p>>",
            lengthMenu: [
                [25, 50, 75, 100, -1],
                [25, 50, 75, 100, "All"]
            ],
            columnDefs: [{
                targets: -1,
                orderable: false,
                searchable: false
            }],
        });
        table.buttons().container().appendTo('#dataTable_wrapper .col-md-5:eq(0)');

    }
    $(document).ready(function() {
    getdata_beasiswa();

    $('#centangSemua').click(function(e) {
            if ($(this).is(':checked')) {
                $('.centangBeasiswaid').prop('checked', true);
            } else {
                $('.centangBeasiswaid').prop('checked', false);
            }
        });

        $('.formhapus').submit(function(e) {
            e.preventDefault();
            let jmldata = $('.centangBeasiswaid:checked');
            if (jmldata.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ooops!',
                    text: 'Silahkan pilih data!',
                    showConfirmButton: false,
                    timer: 1500
                })
            } else {
                Swal.fire({
                    title: 'Hapus data',
                    text: `Apakah anda yakin ingin menghapus sebanyak ${jmldata.length} data?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus!',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                window.location = response.sukses.link;
                        });
                            }
                        });
                    }
                })
            }
        });
    });


    function hapus(beasiswa_id, nama_peserta, peserta_id) {
        Swal.fire({
            title: 'Yakin Hapus Data Beasiswa ini?',
            text: `Hapus data beasiswa ke '${encodeURIComponent(nama_peserta)}'?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('beasiswa/delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        beasiswa_id : beasiswa_id,
                        peserta_id: peserta_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus data beasiswa ini!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location = response.sukses.link;
                        });
                        }
                    }
                });
            }
        })
    }
</script>