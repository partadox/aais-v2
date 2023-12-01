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
            <option value="/absensi-bina/peserta-export?angkatan=<?= $data['angkatan_kelas'] ?>"> Angkatan Kuliah <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-auto mb-2">
        <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas" id="angkatan_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/absensi-bina/peserta?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?>> <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>Peserta</th>
                <th>Kelas</th>
                <th>Angkatan <br> Perkuliahan</th>
                <!-- <th>Status <br> Peserta</th> -->
                <th>Jumlah <br> Kehadiran</th>
                <?php
                    for ($i = 1; $i <= 15; $i++) {
                        ?>
                        <th width="1%"><?= $i ?></th>
                        <?php
                    }
                ?>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="1%"><?= $nomor ?></td>
                    <td width="10%"><?= $data['nis'] ?></td>
                    <td width="10%"><?= $data['nama_peserta'] ?></td>
                    <td width="10%"><?= $data['bk_name'] ?></td>
                    <td width="2%"><?= $data['bk_angkatan'] ?></td>
                    <!-- <td width="2%">
                        <?php if($data['bs_status_peserta'] == NULL) { ?>
                            <button class="btn btn-success btn-sm mb-2" disabled>AKTIF</button>
                        <?php } ?>
                        <?php if($data['bs_status_peserta'] == 'OFF') { ?>
                            <button class="btn btn-secondary btn-sm mb-2" disabled>OFF</button>
                        <?php } ?>
                    </td> -->
                    <td width="3%"><?= $data['tm1']+$data['tm2']+$data['tm3']+$data['tm4']+$data['tm5']+$data['tm6']+$data['tm7']+$data['tm8']+$data['tm9']+$data['tm10']+$data['tm11'] ?></td>
                    <?php
                        for ($i = 1; $i <= 15; $i++) {
                            $key = 'tm' . $i;
                            ?>
                            <td>
                                <?php if ($data[$key] === NULL) { ?>
                                    <p></p>
                                <?php } elseif ($data[$key] == '0') { ?>
                                    <i class="fa fa-minus" style="color:red"></i>
                                <?php } elseif ($data[$key] == '1') { ?>
                                    <i class="fa fa-check" style="color:green"></i>
                                <?php } ?>
                            </td>
                            <?php
                        }
                    ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodalrincian">
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
</script>

<?= $this->endSection('isi') ?>