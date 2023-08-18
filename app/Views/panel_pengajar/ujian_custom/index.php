<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<a href="<?= base_url('/pengajar/kelas') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<h5 style="text-align:center;">Kelas <?= $kelas['nama_kelas'] ?></h5>
<h6 style="text-align:center;"><?= $kelas['hari_kelas'] ?>, <?= $kelas['waktu_kelas'] ?> <?= $kelas['zona_waktu_kelas'] ?> - <?= $kelas['metode_kelas'] ?></h6>
<h6 style="text-align:center;"><?= $nama_pengajar ?></h6>
<?php if($kelas['show_ujian'] == NULL || $kelas['show_ujian'] == '0') { ?>
    <h6 style="text-align:center; color: red;">HASIL UJIAN TIDAK TAMPIL</h6> 
<?php } ?>
<?php if($kelas['show_ujian'] == '1') { ?>
    <h6 style="text-align:center; color: green;">HASIL UJIAN TAMPIL</h6> 
<?php } ?>
<div style="text-align:center;">
    <button type="button" class="mb-2 btn btn-primary"  onclick="show('<?=$kelas['kelas_id']?>')"><i class="fa fa-eye"></i> Tampilkan Hasil Ujian</button>
</div>

<?php $nomor = 0;
foreach ($peserta_onkelas as $data) :
    $nomor++; ?>
    <div class="accordion" id="accordionAbsen">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#colapse<?= $nomor?>" aria-expanded="true" aria-controls="colapse<?= $nomor?>" style="color: black; text-decoration: none;">
                <h6>
                    <?= $nomor ?>. <?= $data['nis'] ?> - <?= $data['nama_peserta'] ?>
                    <i class="fa fa-angle-down float-right"></i>
                </h6>
                </button>
            </h2>
            </div>

            <div id="colapse<?= $nomor?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionAbsen">
                <div class="card-body">
                    <h6>
                        <strong>Status Kelulusan: </strong>
                        <?php if($data['status_peserta_kelas'] == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'MENGULANG') { ?>
                            <button class="btn btn-warning btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    <table class="table table-bordered mt-4">
                        <tbody>
                            <?php for ($i=1; $i <= 10; $i++): ?>
                                <?php
                                    $col_status = 'text'.$i.'_status';
                                    $col_name   = 'text'.$i.'_name'  ;

                                    $val        = 'ucv_text'.$i;
                                    if($ucc[$col_status] == '1') { ?>
                                        <tr>
                                            <th width="5%"><?= strtoupper($ucc[$col_name]) ?> </th>
                                            <th width="95%"><?= $data[$val] ?></th>
                                        </tr>
                                    <?php } ?>
                            <?php endfor; ?>

                            <?php for ($i=1; $i <= 10; $i++): ?>
                                <?php
                                    $col_status = 'int'.$i.'_status';
                                    $col_name   = 'int'.$i.'_name'  ;

                                    $val        = 'ucv_int'.$i;
                                    if($ucc[$col_status] == '1') { ?>
                                        <tr>
                                            <th width="5%"><?= strtoupper($ucc[$col_name]) ?> </th>
                                            <th width="95%"><?= $data[$val] ?></th>
                                        </tr>
                                    <?php } ?>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="mt-2 btn btn-info"  onclick="info('<?=$data['ucv_id']?>', '<?=$kelas['program_id']?>', '<?=$data['peserta_kelas_id']?>')"><i class="fa fa-edit"></i> Input Nilai</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="viewmodal"></div>
<div class="viewmodaldatashow"></div>
<script>
    $(document).ready(function () {
        $('.collapse').on('shown.bs.collapse', function () {
            $(this).parent().find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");
        }).on('hidden.bs.collapse', function () {
            $(this).parent().find(".fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
        });
    });

    function info(ucv_id, program_id, peserta_kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/ujian-custom/modal') ?>",
            data: {
                ucv_id : ucv_id,
                program_id: program_id,
                peserta_kelas_id: peserta_kelas_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modal').modal('show');
                }
            }
        });
    }

    function show(kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/pengajar/show-ujian') ?>",
            data: {
                kelas_id : kelas_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaldatashow').html(response.sukses).show();
                    $('#modalshow').modal('show');
                }
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>