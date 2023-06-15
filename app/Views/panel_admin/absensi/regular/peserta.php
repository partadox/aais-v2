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
            <option value="/absensi-regular/peserta-export?angkatan=<?= $data['angkatan_kelas'] ?>"> Angkatan Kuliah <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-auto mb-2">
        <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas" id="angkatan_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/absensi-regular/peserta?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?>> <?= $data['angkatan_kelas'] ?> </option>
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
                <th>Status <br> Peserta</th>
                <th>Jumlah <br> Kehadiran</th>
                <th width="3%">1</th>
                <th width="3%">2</th>
                <th width="3%">3</th>
                <th width="3%">4</th>
                <th width="3%">5</th>
                <th width="3%">6</th>
                <th width="3%">7</th>
                <th width="3%">8</th>
                <th width="3%">9</th>
                <th width="3%">10</th>
                <th width="3%">11</th>
                <th width="3%">12</th>
                <th width="3%">13</th>
                <th width="3%">14</th>
                <th width="3%">15</th>
                <th width="3%">16</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="1%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['nis'] ?></td>
                    <td width="10%"><?= $data['nama_peserta'] ?></td>
                    <td width="10%"><?= $data['nama_kelas'] ?></td>
                    <td width="1%"><?= $data['angkatan_kelas'] ?></td>
                    <td width="2%">
                        <?php if($data['status_aktif_peserta'] == NULL) { ?>
                            <button class="btn btn-success btn-sm mb-2" disabled>AKTIF</button>
                        <?php } ?>
                        <?php if($data['status_aktif_peserta'] == 'OFF') { ?>
                            <button class="btn btn-secondary btn-sm mb-2" disabled>OFF</button>
                        <?php } ?>
                    </td>
                   <td><?= $data['tm1']+$data['tm2']+$data['tm3']+$data['tm4']+$data['tm5']+$data['tm6']+$data['tm7']+$data['tm8']+$data['tm9']+$data['tm10']+$data['tm11']+$data['tm12']+$data['tm13']+$data['tm14']+$data['tm15']+$data['tm16'] ?></td>
                   <td >
                        <?php if($data['tm1'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm1'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm1'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm2'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm2'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm2'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm3'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm3'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm3'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm4'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm4'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm4'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm5'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm5'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm5'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm6'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm6'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm6'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm7'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm7'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm7'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm8'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm8'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm8'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm9']== NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm9']== '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm9']== '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm10'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm10'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm10'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm11'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm11'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm11'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm12'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm12'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm12'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm13'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm13'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm13'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm14'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm14'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm14'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm15'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm15'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm15'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm16'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm16'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm16'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
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