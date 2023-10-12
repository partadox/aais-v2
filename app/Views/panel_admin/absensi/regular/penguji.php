<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <div class="col-sm-auto mb-2">
        <label for="absen_pilih">Export Excel (Download)</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="absen_pilih" id="absen_pilih" class="js-example-basic-single mb-2">
            <option value="" disabled selected>Download...</option>
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/absensi-regular/penguji-export?angkatan=<?= $data['angkatan_kelas'] ?>"> Angkatan Kuliah <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-auto mb-2">
        <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas" id="angkatan_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/absensi-regular/penguji?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?>> <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Penguji</th>
                <th>Cabang</th>
                <th>Kelas</th>
                <th>Angkatan <br> Perkuliahan</th>
                <th>Status Absensi</th>
                <th>Tgl Absensi</th>
                <th>Waktu Absensi</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="1%"><?= $nomor ?></td>
                    <td width="15%"><?= $data['nama_pengajar'] ?></td>
                    <td width="10%"><?= $data['nama_kantor'] ?></td>
                    <td width="10%"><?= $data['nama_kelas'] ?></td>
                    <td width="10%"><?= $data['angkatan_kelas'] ?></td>
                    <td width="5%">
                        <?php if($data['absen_penguji'] != NULL) { ?>
                            <a style="color: green;"><i class="fa fa-check"></i></a>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if($data['absen_penguji'] != NULL) { ?>
                            <?= shortdate_indo(substr($data['absen_penguji'],0,10)) ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if($data['absen_penguji'] != NULL) { ?>
                            <?= substr($data['absen_penguji'],11,5) ?>
                        <?php } ?>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $('#angkatan_kelas').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    $('#absen_pilih').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    function catatan(absen_pengajar_id, kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/absensi-regular/pengajar-note') ?>",
            data: {
                absen_pengajar_id : absen_pengajar_id,
                kelas_id : kelas_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalcatatan').html(response.sukses).show();
                    $('#modalcatatan').modal('show');
                }
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>