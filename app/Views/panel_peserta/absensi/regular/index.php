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

<h5 style="text-align:center;">Kelas <?= $kelas['nama_kelas'] ?></h5>
<h6 style="text-align:center;"><?= $kelas['hari_kelas'] ?>, <?= $kelas['waktu_kelas'] ?> - <?= $kelas['metode_kelas'] ?></h6>
<h6 style="text-align:center;"><?= $nama_pengajar ?></h6>

<?php if ($kelas['metode_absen'] == 'Mandiri' && strtotime(date('Y-m-d H:i:s')) <= strtotime($kelas['expired_absen'])): ?>
    <div class="row">
        <div class="col text-center">
            <button type="button" class="btn btn-success mb-2" onclick="tm('Mandiri', '<?= $absensi['absen_peserta_id'] ?>', '<?= $kelas['kelas_id'] ?>')"><i class=" fa fa-edit"></i> Isi Absen Mandiri</button> <br>
            Batas Waktu: <p style="color: red;"><?= shortdate_indo(substr($kelas['expired_absen'],0,10)) ?>, <?= substr($kelas['expired_absen'],11,5) ?> WITA</p>
        </div>
    </div>
<?php endif; ?>

<?php if($absensi != NULL) { ?>
    <?php for ($i = 1; $i <= 16; $i++): 
        $tm = "tm".$i;
        $tgl_tm = "tgl_tm".$i;
        $note_ps_tm = "note_ps_tm".$i; ?>
        <div class="accordion" id="accordionAbsen">
            <div class="card">
                <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#colapse<?= $tm?>" aria-expanded="true" aria-controls="colapse<?= $tm?>" style="color: black; text-decoration: none;">
                    <h5>
                    TM - <?= $i ?> : 
                    <?php if ($absensi[$tm] == '1'): ?>
                        <a style="color: green;"><i class=" fa fa-check" style="color:green"></i> HADIR</a>
                        
                    <?php endif; ?>
                    <?php if ($absensi[$tm] == '0'): ?>
                        <a style="color: red;"><i class=" fa fa-minus" style="color:red"></i> TIDAK HADIR</a>
                    <?php endif; ?> 
                    <?php if ($absensi[$tm] == NULL): ?>
                        -
                    <?php endif; ?> <br>
                    (<?php if ($absensi_pengajar[$tgl_tm] != NULL && $absensi_pengajar[$tgl_tm] != '2022-01-01'): ?>
                        <?= shortdate_indo(substr($absensi_pengajar[$tgl_tm],0,10)) ?>
                    <?php endif; ?>)
                    <i class="fa fa-angle-down float-right"></i>
                    </h5>
                    </button>
                </h2>
                </div>

                <div id="colapse<?= $tm?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAbsen">
                    <div class="card-body">
                        <h6>
                        <strong>Catatan: </strong> <?= $absensi[$note_ps_tm] ?> <br>
                        <!-- <button type="button" class="mt-2 btn btn-warning"  onclick="note('$absensi['absen_peserta_id']', '$note_ps_tm')"><i class="fa fa-edit"></i> Edit Catatan TM-$i</button> -->
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>
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
    function tm(methode, absen_peserta_id, kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('peserta/absensi-regular-input') ?>",
            data: {
                methode: methode, 
                absen_peserta_id : absen_peserta_id,
                kelas_id : kelas_id,
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

    // function note(absen_peserta_id, note_ps_tm) {
    //     $.ajax({
    //         type: "post",
    //         url: "site_url('peserta/absensi-regular-editnote')",
    //         data: {
    //             absen_peserta_id: absen_peserta_id,
    //             note_ps_tm: note_ps_tm
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
</script>

<?= $this->endSection('isi') ?>