<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <div class="col-sm-auto">
        <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Tambah Kelas</button>
    </div>
    
    <div class="col-sm-auto">
        <a href="<?= base_url('kelas-bina/export?angkatan='.$angkatan_pilih ) ?>"> 
            <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-file-download"></i> Export Excel (Download)</button>
        </a>
    </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-auto ml-4 mb-2">
        <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas_filter" id="angkatan_kelas_filter" class="js-example-basic-single mb-2">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="kelas-bina?angkatan=<?= $data['bk_angkatan'] ?>" <?php if ($angkatan_pilih == $data['bk_angkatan']) echo "selected"; ?> > <?= $data['bk_angkatan'] ?> </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Kelas</th>
                <th>Angkatan <br> Perkuliahan</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Metode TM</th>
                <th>Jen. Kel.</th>
                <th>Jml. <br> Peserta</th>
                <th>Status Kelas</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="2%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['bk_id'] ?></td>
                    <td width="15%"><?= $data['bk_name'] ?></td>
                    <td width="5%"><?= $data['bk_angkatan'] ?></td>
                    <td width="5%"><?= $data['bk_hari'] ?></td>
                    <td width="5%"><?= $data['bk_waktu'] ?> <?= $data['bk_timezone'] ?></td>
                    <td width="5%">
                        <?php if($data['bk_tm_methode'] == 'ONLINE') { ?>
                            <button class="btn btn-primary btn-sm" disabled>ONLINE</button> 
                        <?php } ?>
                        <?php if($data['bk_tm_methode'] == 'OFFLINE') { ?>
                            <button class="btn btn-info btn-sm" disabled>OFFLINE</button> 
                        <?php } ?>
                        <?php if($data['bk_tm_methode'] == 'HYBRID') { ?>
                            <button class="btn btn-warning btn-sm" disabled>HYBRID</button> 
                        <?php } ?>
                    </td>
                    <td  width="5%"><?= $data['bk_jenkel'] ?></td>
                    <td width="5%"><?= $data['peserta_bina_count'] ?></td>
                    <td width="5%">
                        <?php if($data['bk_status'] == '1') { ?>
                            <button class="btn btn-success btn-sm" disabled>Aktif</button> 
                        <?php } ?>
                        <?php if($data['bk_status'] == '0') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Nonaktif</button> 
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $data['bk_id'] ?>')" >
                            <i class=" fa fa-edit"></i></button>

                        <a href="kelas-bina/detail?id=<?= $data['bk_id'] ?>" class="btn btn-info">
                            <i class=" fa fa-user-graduate"></i>
                        </a>
                        
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodaltambah">
</div>

<div class="viewmodaledit">
</div>

<script>

    $('#angkatan_kelas_filter').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });
    
    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-bina/input') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaltambah').html(response.sukses).show();
                    $('#modaltambah').modal('show');
                }
            }
        });
    }

    function edit(bk_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-bina/edit') ?>",
            data: {
                bk_id : bk_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaledit').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function peserta(kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-bina/detail') ?>",
            data: {
                kelas_id : kelas_id
            },
            dataType: "json",
            // success: function(response) {
            //     (function() {
            //                     window.location = response.sukses.link;
            //             });
            // }
        });
    }
</script>
<?= $this->endSection('isi') ?>