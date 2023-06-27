<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<a> 
    <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Tambah Pengumuman</button>
</a>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered wrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Kepada</th>
                <th>Dibuat</th>
                <!-- <th>Isi</th>  -->
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="5%"><?= $nomor ?></td>
                    <td width="15%"><?= $data['pengumuman_title'] ?></td>
                    <td width="10%">
                        <?php if($data['pengumuman_status'] == 0) { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Tidak Tampil</button> 
                        <?php } ?>
                        <?php if($data['pengumuman_status'] == 1) { ?>
                            <button class="btn btn-success btn-sm" disabled>Tampil</button> 
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if($data['pengumuman_type'] == 'PESERTA') { ?>
                            <button class="btn btn-primary btn-sm" disabled>PESERTA</button> 
                        <?php } ?>
                        <?php if($data['pengumuman_type'] == 'PENGAJAR') { ?>
                            <button class="btn btn-info btn-sm" disabled>PENGAJAR</button> 
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?= $data['pengumuman_create'] ?>, oleh: <?= $data['pengumuman_by'] ?>
                    </td>
                    <!-- <td width="30%">
                        <button class="expandButton btn btn-warning">Baca</button>
                        <div class="baca" style="display: none;">
                        </div>
                    </td> -->
                    <td width="5%">
                        <button type="button" class="btn btn-warning btn-sm" onclick="edit('<?= $data['pengumuman_id'] ?>')" >
                        <i class=" fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $data['pengumuman_id'] ?>', '<?= $data['pengumuman_title'] ?>')" >
                        <i class=" fa fa-trash"></i>
                        </button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modalpengumumantambah">
</div>

<div class="viewmodaldataedit">
</div>


<script>
    $(document).ready(function(){
        $(".expandButton").click(function(){
            $(this).next('.baca').toggle(); // This will only toggle the zoom-container that is directly after the clicked button
        });
    });

    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('pengumuman/input') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.modalpengumumantambah').html(response.sukses).show();
                    $('#modalpengumumantambah').modal('show');
                }
            }
        });
    }

    function edit(pengumuman_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pengumuman/edit') ?>",
            data: {
                pengumuman_id : pengumuman_id
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

    function hapus(pengumuman_id, judul) {
        Swal.fire({
            title: 'Hapus pengumuman?',
            text: `Apakah anda yakin mmenghapus pengumuman ${judul} ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('pengumuman/delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        pengumuman_id: pengumuman_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus pengumuman ini!",
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
<?= $this->endSection('isi') ?>