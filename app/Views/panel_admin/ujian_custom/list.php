<h4 class="text-center">Data Ujian Custom</h4>
<h5 class="text-center">Angkatan <?= $angkatan ?> - <?= $nama_program ?></h5>

<div class="table-responsive mb-3">
  <table id="list" class="table table-striped table-bordered dt-responsive wrap w-100 ">
    <thead>
        <tr class="table-secondary">
            <th width=2%>No.</th>
            <th width=5%>NIS</th>
            <th width=5%>Peserta</th>
            <th width=5%>Jenis <br> Kelamin</th>
            <th width=5%>Kelas</th>
            <th width=5%>Angkatan <br> Perkuliahan</th>
            <th width=5%>Pengajar</th>
            <th width=5%>Hari <br> Kelas</th>
            <th width=5%>Waktu <br> Kelas</th>
            <th width=5%>Kelulusan</th>
            <th width=5%></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<script>
    function fetch(angkatan, program) {
        var table = $('#list').DataTable({
            "processing": true,
            "serverside": true,
            "order": [],
            "ajax": {
                "url": "<?= base_url('/ujian-custom/fetch') ?>",
                "type": "POST",
                "data": {
                    angkatan: angkatan,
                    program: program,
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

    $(document).ready(function () {
        $('.select2').select2({});
        fetch('<?= $angkatan ?>', '<?= $program_id ?>');
    });

    function info(ucv_id, program_id, peserta_kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/ujian-custom/modal') ?>",
            data: {
                ucv_id : ucv_id,
                program_id: program_id,
                peserta_kelas_id: peserta_kelas_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modal').modal('show');
                }
            }
        });
    }
</script>