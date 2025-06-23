<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <div class="col-sm-auto">
        <button type="button" class="btn btn-primary mb-3" onclick="tambah('')"><i class=" fa fa-plus-circle"></i> Tambah Kelas</button>
    </div>

    <div class="col-sm-auto">
        <a href="<?= base_url('kelas-nonreg/export?tahun=' . $tahun_pilih) ?>">
            <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-file-download"></i> Export Excel (Download)</button>
        </a>
    </div>
</div>
</div>
<div class="row">
    <div class="col-sm-auto ml-4 mb-2">
        <label for="tahun_kelas">Pilih Tahun</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="tahun_kelas_filter" id="tahun_kelas_filter" class="js-example-basic-single mb-2">
            <?php foreach ($list_tahun as $key => $data) { ?>
                <option value="kelas-nonreg?tahun=<?= $data['nk_tahun'] ?>" <?php if ($tahun_pilih == $data['nk_tahun']) echo "selected"; ?>> <?= $data['nk_tahun'] ?> </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIK</th>
                <th>Nama Kelas</th>
                <th>Tahun <br> Perkuliahan</th>
                <th>Program</th>
                <th>Tipe Kelas</th>
                <th>Bidang <br> Usaha</th>
                <th>Pengajar</th>
                <th>Hari</th>
                <th>Jam</th>
                <!-- <th>Pengajar</th> -->
                <!-- <th>Level</th> -->
                <th>Jml. <br> Peserta</th>
                <th>Jml. <br> Pertemuan</th>
                <th>Status Kelas</th>
                <th>Pembayaran</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="3%"><?= $nomor ?></td>
                    <td width="7%"><?= $data['nk_id'] ?></td>
                    <td width="15%"><?= $data['nk_nama'] ?></td>
                    <td width="5%"><?= $data['nk_tahun'] ?></td>
                    <td width="10%"><?= $data['nama_program'] ?></td>
                    <td width="10%"><?= $data['nk_tipe'] ?></td>
                    <td width="10%"><?= $data['nk_usaha'] ?></td>
                    <td width="10%"><?= $data['nama_pengajar_list'] ?></td>
                    <td width="5%"><?= $data['nk_hari'] ?></td>
                    <td width="5%"><?= $data['nk_waktu'] ?> <?= $data['nk_timezone'] ?></td>
                    <!-- <td width="10%">$data['nama_pengajar']</td> -->
                    <!-- <td width="10%"><?= $data['nk_level'] ?></td> -->
                    <td width="10%"><?= $data['nk_kuota'] ?></td>
                    <td>
                        <p>Diambil: <?= $data['nk_tm_ambil'] ?></p>
                        <p>Maks.: <?= $data['nk_tm_total'] ?></p>
                    </td>
                    <td width="5%">
                        <?php if ($data['nk_status'] == 1) { ?>
                            <button class="btn btn-success btn-sm" disabled>Aktif</button>
                        <?php } ?>
                        <?php if ($data['nk_status'] == 0) { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Nonaktif</button>
                        <?php } ?>
                    </td>
                    <td width="5%">
                        Daftar:
                        <?php if ($data['nk_status_daftar'] == "1") { ?>
                            <button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i></button>
                        <?php } ?>
                        <?php if ($data['nk_status_daftar'] == "0") { ?>
                            <button class="btn btn-secondary btn-sm" disabled><i class="fa fa-hourglass-half"></i></button>
                        <?php } ?>
                        <br> <br>
                        <!-- Extend: 
                        <?php if ($data['nk_status_bayar'] == "1") { ?>
                            <button class="btn btn-success btn-sm" disabled><i class="fa fa-check"></i></button> 
                        <?php } ?>
                        <?php if ($data['nk_status_bayar'] == "0") { ?>
                            <button class="btn btn-secondary btn-sm" disabled><i class="fa fa-hourglass-half"></i></button> 
                        <?php } ?> -->
                        TM Terbayar: <br> <?= $data['nk_tm_bayar'] ?>
                    </td>
                    <td width="10%">
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $data['nk_id'] ?>')">
                            <i class=" fa fa-edit"></i></button>

                        <a href="kelas-nonreg/detail?id=<?= $data['nk_id'] ?>" class="btn btn-info">
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
    $('#tahun_kelas_filter').bind('change', function() { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-nonreg/input') ?>",
            data: {},
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaltambah').html(response.sukses).show();
                    $('#modaltambah').modal('show');
                }
            }
        });
    }

    function edit(nk_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-nonreg/edit') ?>",
            data: {
                nk_id: nk_id
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
</script>
<?= $this->endSection('isi') ?>