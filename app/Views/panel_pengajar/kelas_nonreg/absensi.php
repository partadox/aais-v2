<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<a href="<?= base_url('/pengajar/kelas-nonreg') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<br>


<h5 style="text-align:center;">Kelas <?= $kelas['nk_nama'] ?></h5>
<h6 style="text-align:center;"><?= $kelas['nk_hari'] ?>, <?= $kelas['nk_waktu'] ?> <?= $kelas['nk_timezone'] ?></h6>


<div class="row mt-2">
    <div class="col d-flex flex-column align-items-center">
        <label for=""><code>Pilih TM untuk Pengisian Absensi</code></label>
        <select onchange="inputAbsensi(this.value);" class="form-control select-single col-2" name="inputTM" id="inputTM">
            <option value="" selected disabled>--PILIH--</option>
            <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                <option value="<?= $i ?>">TATAP MUKA <?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>

<div class="table-responsive mt-3">
    <table id="datatable-absen" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA</th>
                <!-- <th>NOTE</th> -->
                <th>JML. HADIR</th>
                <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                    <th><?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($peserta_onkelas as $data) :
                $nomor++; ?>
                <tr>
                    <td width="5%"><?= $nomor ?></td>
                    <td width="15%">
                        <?= $data['nama'] ?>
                    </td>
                    <!-- <td width="5%">
                        <button class="btn btn-sm btn-info" onclick="inputNote(<?= $data['naps_id'] ?>)"> <i class="mdi mdi-file"></i> </button>
                    </td> -->
                    <td width="10%">
                        <?php $totHadir = 0; for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                            <?php if (isset($data['naps'.$i])) { ?> 
                                <?php if ($data['naps'.$i]['tm'] == '1') { $totHadir = $totHadir+1; ?> 
                                <?php } ?>
                            <?php } ?>
                        <?php endfor; ?>
                        <?= $totHadir?>
                    </td>
                    <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                        <td>
                            <?php if (isset($data['naps'.$i])) { ?> 
                                <?php if ($data['naps'.$i]['tm'] == '1') { ?> 
                                    <i style="color: green;" class="mdi mdi-check-bold"></i>
                                <?php } ?>
                                <?php if ($data['naps'.$i]['tm'] == '0') { ?> 
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

<hr>

<h5>Absensi dan Catatan Pengajar</h5>

<div class="table-responsive">
    <table id="datatable-tm" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>TM</th>
                <th>TGL TM</th>
                <th>WAKTU ISI</th>
                <th>PENGISI ABSENSI</th>
                <th>PENGAJAR HADIR</th>
                <th>NOTE</th>
            </tr>
        </thead>

        <tbody>
            <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                <tr>
                    <td width="5%"><?= $i ?></td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj'.$i]['dt_tm'])) { ?> 
                            <?= shortdate_indo($absenTm['napj'.$i]['dt_tm']) ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj'.$i]['dt_isi'])) { ?> 
                            <?= shortdate_indo(substr($absenTm['napj'.$i]['dt_isi'],0,10)) ?>, <?= substr($absenTm['napj'.$i]['dt_isi'],11,15) ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj'.$i]['by'])) { ?> 
                            <?= $absenTm['napj'.$i]['by'] ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj'.$i]['tm'])) { ?> 
                            <?php if ($absenTm['napj'.$i]['tm'] == '1') { ?> 
                                <i style="color: green;" class="mdi mdi-check-bold"></i>
                            <?php } ?>
                            <?php if ($absenTm['napj'.$i]['tm'] == '0') { ?> 
                                <i style="color: red;" class="mdi mdi-minus"></i>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td width="20%">
                        <?php if (isset($absenTm['napj'.$i]['dt_isi'])) { ?> 
                            <?= $absenTm['napj'.$i]['note'] ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php endfor; ?>
            
        </tbody>
    </table>
</div>

<div class="modalIsi"></div>
<div class="modalIsiNote"></div>

<script>
    function inputAbsensi(tm) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('/pengajar/input-absensi-nonreg') ?>",
            data: {
                nk_id: "<?= $kelas['nk_id']?>",
                tm: tm,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.modalIsi').html(response.sukses).show();
                    $('#modaltm').modal('show');
                }
            }
        });
    }

    function inputNote(absen_pesertaId) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('/pengajar/absensi-note')?>",
            data: {
                absen_pesertaId: absen_pesertaId,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.modalIsiNote').html(response.sukses).show();
                    $('#isiNote').modal('show');
                }
            }
        });
    }

    // function tm(tm, kelas_id, data_absen_pengajar) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('/pengajar/input-absensi') ?>",
    //         data: {
    //             tm : tm,
    //             kelas_id : kelas_id,
    //             data_absen_pengajar : data_absen_pengajar,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.viewmodaltm').html(response.sukses).show();
    //                 $('#modaltm').modal('show');
    //             }
    //         }
    //     });
    // }

    // function aturAbsen(kelas_id) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('/pengajar/atur-absensi') ?>",
    //         data: {
    //             kelas_id : kelas_id
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.viewmodalaturabsen').html(response.sukses).show();
    //                 $('#modalatur').modal('show');
    //             }
    //         }
    //     });
    // }

    // function note(absen_peserta_id, nis, nama, kelas_id) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('/pengajar/absensi-note')?>",
    //         data: {
    //             absen_peserta_id: absen_peserta_id,
    //             nis: nis,
    //             nama: nama,
    //             kelas_id: kelas_id,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.editNote').html(response.sukses).show();
    //                 $('#modalNote').modal('show');
    //             }
    //         }
    //     });
    // }

    // function tm_pengajar(tm, kelas_id, data_absen_pengajar) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('absen/input_tm_pengajar') ?>",
    //         data: {
    //             tm : tm,
    //             kelas_id : kelas_id,
    //             data_absen_pengajar : data_absen_pengajar
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.viewmodaltmpgj').html(response.sukses).show();
    //                 $('#modaltmpgj').modal('show');
    //             }
    //         }
    //     });
    // }
</script>

<?= $this->endSection('isi') ?>