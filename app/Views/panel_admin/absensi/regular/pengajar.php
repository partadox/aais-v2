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
            <option value="/absensi-regular/pengajar-export?angkatan=<?= $data['angkatan_kelas'] ?>"> Angkatan Kuliah <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-auto mb-2">
        <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas" id="angkatan_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/absensi-regular/pengajar?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?>> <?= $data['angkatan_kelas'] ?> </option>
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
                <th>Cabang</th>
                <th>Kelas</th>
                <th>Angkatan <br> Perkuliahan</th>
                <th>Jumlah <br> Kehadiran</th>
                <th width="3%">Catatan</th>
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
                    <td width="5%"><?= $data['nama_pengajar'] ?></td>
                    <td width="10%"><?= $data['nama_kantor'] ?></td>
                    <td width="10%"><?= $data['nama_kelas'] ?></td>
                    <td width="1%"><?= $data['angkatan_kelas'] ?></td>
                   <td>
                       <?= $data['tm1_pengajar']+$data['tm2_pengajar']+$data['tm3_pengajar']+$data['tm4_pengajar']+$data['tm5_pengajar']+$data['tm6_pengajar']+$data['tm7_pengajar']+$data['tm8_pengajar']+$data['tm9_pengajar']+$data['tm10_pengajar']+$data['tm11_pengajar']+$data['tm12_pengajar']+$data['tm13_pengajar']+$data['tm14_pengajar']+$data['tm15_pengajar']+$data['tm16_pengajar'] ?>
                    </td>
                    <td>
                    <button type="button" class="btn btn-info mb-2" onclick="catatan(<?= $data['absen_pengajar_id'] ?>, <?= $data['kelas_id'] ?>)" >
                        <i class=" fa fa-file mr-1"></i>Catatan</button>
                        
                    </td>
                   <td >
                        <?php if($data['tm1_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm1_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm1_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm2_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm2_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm2_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm3_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm3_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm3_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm4_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm4_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm4_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm5_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm5_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm5_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm6_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm6_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm6_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm7_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm7_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm7_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm8_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm8_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm8_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm9_pengajar']== NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm9_pengajar']== '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm9_pengajar']== '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm10_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm10_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm10_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm11_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm11_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm11_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm12_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm12_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm12_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm13_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm13_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm13_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm14_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm14_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm14_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm15_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm15_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm15_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                    <td >
                        <?php if($data['tm16_pengajar'] == NULL) { ?>
                            <p></p>
                        <?php } ?>
                        <?php if($data['tm16_pengajar'] == '0') { ?>
                            <i class=" fa fa-minus" style="color:red"></i>
                        <?php } ?>
                        <?php if($data['tm16_pengajar'] == '1') { ?>
                            <i class=" fa fa-check" style="color:green"></i>
                        <?php } ?>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodalcatatan">
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