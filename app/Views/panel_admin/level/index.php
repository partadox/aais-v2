<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<a> 
    <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Tambah Level</button>
</a>

<div class="table-responsive">
    <table id="datatable" class="table table-bordered mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>ID Level</th>
                <th>Level</th>
                <th>Tampil Di Pendaftaran Awal Peserta</th>
                <th>Tindakan</th> 
            </tr>
        </thead>

        <tbody>
            <?php 
            foreach ($list as $data) :
                ?>
                <tr>
                    <!-- <td width="5%"><?= $data['urutan_level'] ?></td> -->
                    <td width="7%"><?= $data['peserta_level_id'] ?></td>
                    <td width="20%"><?= $data['nama_level'] ?></td>
                    <td width="15%">
                        <?php if($data['tampil_ondaftar'] == '0') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Tidak Tampil</button>  
                        <?php } ?>
                        <?php if($data['tampil_ondaftar'] == '1') { ?>
                            <button class="btn btn-success btn-sm" disabled>Tampil</button> 
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $data['peserta_level_id'] ?>')" >
                        <i class=" fa fa-edit mr-1"></i>Edit</button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modaltambahlevel">
</div>

<div class="modaleditlevel">
</div>

<script>
    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('level/input') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.modaltambahlevel').html(response.sukses).show();
                    $('#modaltambahlevel').modal('show');
                }
            }
        });
    }

    function edit(peserta_level_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('level/edit') ?>",
            data: {
                peserta_level_id : peserta_level_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.modaleditlevel').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }
</script>
<?= $this->endSection('isi') ?>