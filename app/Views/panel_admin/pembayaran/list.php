<hr>
<h6>Pembayaran Angkatan: <?= $angkatan ?> <br> <br> Metode Bayar: <?php if($payment_filter == 'all') { ?>
                        Semua Metode
                    <?php } ?>
                    <?php if($payment_filter == 'tf') { ?>
                        Transfer Manual
                    <?php } ?>
                    <?php if($payment_filter == 'flip') { ?>
                        Payment Gateway Flip
                    <?php } ?>
                    <?php if($payment_filter == 'beasiswa') { ?>
                        Kode Beasiswa
                    <?php } ?></h6>
<div class="table-responsive">
    <table id="listpembayaran" class="table table-striped table-bordered mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="thead-light">
            <tr>
                <th>No.(ID)</th>
                <th>Peserta</th>
                <th>Metode <br> Bayar</th>
                <th>Upload Bayar</th>
                <th class="text-wrap">Rincian Bayar</th>
                <th class="text-wrap">Status <br> Pembayaran</th>
                <th>Bukti <br> Transfer</th>
                <th>Status <br> Konfirmasi</th>
                <th>Tindakan</th>
            </tr>
        </thead>


        <tbody>

        </tbody>
    </table>
</div>

<script>
    function getdata_pembayaran(angkatan, payment_filter) {
        var table = $('#listpembayaran').DataTable({
            "processing": true,
            "serverside": true,
            "fixedColumns":   {
                "left": 1
            },
            "order": [],
            "ajax": {
                "url": "<?= site_url('pembayaran/getdata') ?>",
                "type": "POST",
                "data": {
                    angkatan: angkatan,
                    payment_filter: payment_filter
                },
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
        getdata_pembayaran('<?= $angkatan ?>', '<?= $payment_filter ?>');
    });

    function flip_bill(bill_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pembayaran/bill') ?>",
            data: {
                peserta_id: peserta_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaldatadiri').html(response.sukses).show();
                    $('#modaldatadiri').modal('show');
                }
            }
        });
    }

    function edit(bayar_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pembayaran/edit') ?>",
            data: {
                bayar_id : bayar_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaldataedit').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function gambar(bayar_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pembayaran/edit-bukti') ?>",
            data: {
                bayar_id : bayar_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalgambar').html(response.sukses).show();
                    $('#modalgambar').modal('show');
                }
            }
        });
    }

    function hapus(bayar_id) {
        Swal.fire({
            title: 'Yakin Hapus Data Pembayaran ini?',
            text: `Data SPP/Infaq yang Terkait Data Pembayaran ini Akan Hilang Juga.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('pembayaran/delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        bayar_id : bayar_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus pembayaran ini!",
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