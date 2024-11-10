<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="table-responsive">
    <table id="listpeserta" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead class="thead-light">
            <tr>
                <th>NO.</th>
                <th>NAMA</th>
                <th>LEVEL</th>
                <th>GENDER</th>
                <th>USIA</th>
                <th>ASAL</th>
                <th>HP</th>
                <th>STATUS</th>
                <th>TGL TF</th>
                <th>TGL TF DITERIMA</th>
                <th>NOTE</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="viewModal"></div>

<script>
    function getdata_peserta() {
        var table = $('#listpeserta').DataTable({
            "processing": true,
            "serverside": true,
            "fixedColumns":   {
                "left": 2
            },
            "order": [],
            "ajax": {
                "url": "<?= site_url('terima-peserta/getdataAll') ?>",
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
        getdata_peserta();
    });

    function accept(peserta_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('terima-peserta/modal') ?>",
            data: {
                peserta_id: peserta_id,
                modal: 'terima'
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewModal').html(response.sukses).show();
                    $('#modalTerima').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading modal:', error);
            }
        });
    }

    function history(peserta_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('terima-peserta/modal') ?>",
            data: {
                peserta_id: peserta_id,
                modal: 'history'
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewModal').html(response.sukses).show();
                    $('#modalTerima').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading modal:', error);
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>