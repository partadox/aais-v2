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
    <?php if($user['level'] == 1 || $user['level'] == 2) { ?>
        <div class="col-sm-auto">
            <button type="button" class="btn btn-success mb-3" onclick="AturDaftar('')" ><i class="fa fa-screwdriver"></i> Pengaturan Pendaftaran</button>
        </div>
    <?php } ?>
    
    <div class="col-sm-auto">
        <a href="<?= base_url('kelas-regular/export?angkatan='.$angkatan_pilih ) ?>"> 
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
            <option value="kelas-regular?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?> > <?= $data['angkatan_kelas'] ?> </option>
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
                <th>Program</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Pengajar</th>
                <th>Metode TM</th>
                <th>Level</th>
                <th>Jen. Kel.</th>
                <th>Kuota <br> Pendaftaran</th>
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
                    <td width="3%"><?= $nomor ?></td>
                    <td width="3%"><?= $data['kelas_id'] ?></td>
                    <td width="15%"><?= $data['nama_kelas'] ?></td>
                    <td width="5%"><?= $data['angkatan_kelas'] ?></td>
                    <td width="10%"><?= $data['nama_program'] ?></td>
                    <td width="5%"><?= $data['hari_kelas'] ?></td>
                    <td width="5%"><?= $data['waktu_kelas'] ?> <?= $data['zona_waktu_kelas'] ?></td>
                    <td width="7%"><?= $data['nama_pengajar'] ?></td>
                    <td width="5%">
                        <?php if($data['metode_kelas'] == 'ONLINE') { ?>
                            <button class="btn btn-primary btn-sm" disabled>ONLINE</button> 
                        <?php } ?>
                        <?php if($data['metode_kelas'] == 'OFFLINE') { ?>
                            <button class="btn btn-info btn-sm" disabled>OFFLINE</button> 
                        <?php } ?>
                        <?php if($data['metode_kelas'] == 'HYBRID') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>HYBRID</button> 
                        <?php } ?>
                    </td>
                    <td  width="7%"><?= $data['nama_level'] ?></td>
                    <td  width="7%"><?= $data['jenkel'] ?></td>
                    <td width="15%">
                        <p>Kuota: <?= $data['kouta'] ?></p>
                        <p>Sisa Kuota: <?= $data['kouta']-$data['peserta_kelas_count'] ?></p>
                    </td>
                    <td><?= $data['peserta_kelas_count'] ?></td>
                    <td width="5%">
                        <?php if($data['status_kelas'] == 'aktif') { ?>
                            <button class="btn btn-success btn-sm" disabled>Aktif</button> 
                        <?php } ?>
                        <?php if($data['status_kelas'] == 'nonaktif') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Nonaktif</button> 
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $data['kelas_id'] ?>')" >
                            <i class=" fa fa-edit"></i></button>

                        <a href="kelas-regular/detail?id=<?= $data['kelas_id'] ?>" class="btn btn-info">
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

<div class="viewmodalatur">
</div>

<script>

    $('#angkatan_kelas_filter').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    function AturDaftar() {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-regular/input-setting') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalatur').html(response.sukses).show();
                    $('#modalatur').modal('show');
                }
            }
        });
    }
    
    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-regular/input') ?>",
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

    function edit(kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-regular/edit') ?>",
            data: {
                kelas_id : kelas_id
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
            url: "<?= site_url('kelas-regular/detail') ?>",
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