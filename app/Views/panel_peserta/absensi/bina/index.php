<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<a href="<?= base_url('/peserta-kelas') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<p class="mt-1">Catatan :<br>
    <i class="mdi mdi-information"></i> Klik pada tulisan keterangan absen TM untuk melihat catatan tatap muka. <br>
</p>

<?php
if (session()->getFlashdata('pesan_error')) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <i class="mdi mdi-alert-circle"></i> <strong>';
    echo session()->getFlashdata('pesan_error');
    echo ' </strong> </div>';
}
if (session()->getFlashdata('pesan_sukses')) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <i class="mdi mdi-check-circle"></i> <strong>';
    echo session()->getFlashdata('pesan_sukses');
    echo ' </strong> </div>';
}
?>

<h5 style="text-align:center;"><?= $kelas['bk_name'] ?></h5>
<h6 style="text-align:center;"><?= $kelas['bk_hari'] ?>, <?= $kelas['bk_waktu'] ?> - <?= $kelas['bk_tm_methode'] ?></h6>

<hr>

<?php if ($kelas['bk_absen_status'] == 1 && $kelas['bk_absen_methode'] == 'Perwakilan'  && $kelas['bk_absen_koor'] == $peserta_id): ?>
    <div class="row">
        <div class="col d-flex flex-column align-items-center justify-content-center mb-4">
            <label for="absen_pilih">Pilih TM Absen yang Akan Diisi <br> <code>(Anda Sebagai Koordinator Kelas)</code></label>
            <select onchange="tm('Perwakilan', <?= $kelas['bk_id'] ?>, <?= $bs_id ?>, this.value);" class="form-control text-center col-2" name="absen_pilih" id="absen_pilih">
                <option value="" disabled selected>--PILIH TM--</option>
                <?php for($i = 1; $i <= $kelas['bk_tm_total']; $i++): ?>
                    <option value="<?= $i ?>">TM-<?= $i ?></option>
                <?php endfor; ?> 
            </select>
        </div>
    </div>
<?php endif; ?>

<?php if ($kelas['bk_absen_status'] == 1 && $kelas['bk_absen_methode'] == 'Mandiri' && strtotime(date('Y-m-d H:i:s')) <= strtotime($kelas['bk_absen_expired'])): ?>
    <div class="row">
        <div class="col text-center">
            <button type="button" class="btn btn-success mb-2" onclick="tm('Mandiri', '<?= $kelas['bk_id'] ?>', '<?= $bs_id ?>', '0')"><i class=" fa fa-edit"></i> Isi Absen Mandiri</button> <br>
            Batas Waktu: <p style="color: red;"><?= shortdate_indo(substr($kelas['bk_absen_expired'],0,10)) ?>, <?= substr($kelas['bk_absen_expired'],11,5) ?> WITA</p>
        </div>
    </div>
<?php endif; ?>

<?php if($absensi != NULL) { ?>
    <?php foreach ($absensi as $data): ?>
        <div class="accordion" id="accordionAbsen">
            <div class="card">
                <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#colapse<?= $data['bas_id']?>" aria-expanded="true" aria-controls="colapse<?= $data['bas_id']?>" style="color: black; text-decoration: none;">
                    <h5>
                    TM - <?= $data['bas_tm'] ?> : 
                    <?php if ($data['bas_absen'] == '1'): ?>
                        <a style="color: green;"><i class=" fa fa-check" style="color:green"></i> HADIR</a>
                        
                    <?php endif; ?>
                    <?php if ($data['bas_absen'] == '0'): ?>
                        <a style="color: red;"><i class=" fa fa-minus" style="color:red"></i> TIDAK HADIR</a>
                    <?php endif; ?> <br>
                    (<?php if ($data['bas_tm_dt'] != NULL): ?>
                        <?= shortdate_indo(substr($data['bas_tm_dt'],0,10)) ?>
                    <?php endif; ?>)
                    <i class="fa fa-angle-down float-right"></i>
                    </h5>
                    </button>
                </h2>
                </div>

                <div id="colapse<?= $data['bas_id']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAbsen">
                    <div class="card-body">
                        <h6>
                        <strong>Catatan: </strong> <?= $data['bas_note'] ?> <br>
                        <button type="button" class="mt-2 btn btn-warning"  onclick="note('<?=$data['bas_id']?>')"><i class="fa fa-edit"></i> Edit Catatan TM-<?= $data['bas_tm'] ?></button>
                        <hr>
                        <strong>Tgl Isi Absen: <br> </strong> <?= shortdate_indo(substr($data['bas_create'],0,10)) ?> <?= substr($data['bas_create'],11,5) ?>,  <br> oleh: <?= $data['bas_by'] ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php } ?>

<div class="inputAbsen"></div>
<div class="editNote"></div>

<script>
    $(document).ready(function () {
        $('.collapse').on('shown.bs.collapse', function () {
            $(this).parent().find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");
        }).on('hidden.bs.collapse', function () {
            $(this).parent().find(".fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
        });
    });

    function tm(methode, bk_id, bs_id, tm) {
        $.ajax({
            type: "post",
            url: "<?= site_url('peserta/absensi-bina-input') ?>",
            data: {
                methode: methode, 
                bk_id : bk_id,
                bs_id : bs_id,
                tm: tm,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.inputAbsen').html(response.sukses).show();
                    $('#modalAbsen').modal('show');
                }
            }
        });
    }

    function note(bas_id) {
        $.ajax({
            type: "post",
            url: "<?=site_url('peserta/absensi-bina-editnote')?>",
            data: {
                bas_id: bas_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.editNote').html(response.sukses).show();
                    $('#modalNote').modal('show');
                }
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>