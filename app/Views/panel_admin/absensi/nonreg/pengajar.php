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
            <?php foreach ($list_tahun as $key => $data) { ?>
            <option value="/absensi-nonreg/pengajar-export?tahun=<?= $data['nk_tahun'] ?>"> Tahun <?= $data['nk_tahun'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-auto mb-2">
        <label for="tahun_kelas">Pilih Tahun</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="tahun_kelas" id="tahun_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_tahun as $key => $data) { ?>
            <option value="/absensi-nonreg/pengajar?tahun=<?= $data['nk_tahun'] ?>" <?php if ($tahun_pilih == $data['nk_tahun']) echo "selected"; ?>> <?= $data['nk_tahun'] ?> </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Pengajar</th>
                <th>Kelas</th>
                <th>Tahun</th>
                <th>Total Hadir</th>
                <?php for ($i = 1; $i <= $highest_tm_ambil; $i++): ?>
                    <th><?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($processed_lists as $data) :
                $nomor++; ?>
                <tr>
                    <td width="1%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['nama_pengajar'] ?></td>
                    <td width="10%"><?= $data['nk_nama'] ?></td>
                    <td width="10%"><?= $data['nk_tahun'] ?></td>
                    <td width="10%">
                        <?php $totHadir = 0; for ($i = 1; $i <= $highest_tm_ambil; $i++): ?>
                            <?php if (isset($data['napj'.$i])) { ?> 
                                <?php if ($data['napj'.$i]['tm'] == '1') { $totHadir = $totHadir+1; ?> 
                                <?php } ?>
                            <?php } ?>
                        <?php endfor; ?>
                        <?= $totHadir?>
                    </td>
                    <?php for ($i = 1; $i <= $highest_tm_ambil; $i++): ?>
                        <td>
                            <?php if (isset($data['napj'.$i])) { ?> 
                                <?php if ($data['napj'.$i]['tm'] == '1') { ?> 
                                    <i style="color: green;" class="mdi mdi-check-bold"></i>
                                <?php } ?>
                                <?php if ($data['napj'.$i]['tm'] == '0') { ?> 
                                    <i style="color: red;" class="mdi mdi-minus"></i>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    <?php endfor; ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodalcatatan">
</div>

<script>
    $('#tahun_kelas').bind('change', function () { // bind change event to select
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