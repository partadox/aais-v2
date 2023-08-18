<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> <?= $detail_kelas[0]['nama_kelas'] ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<a href="<?= base_url('/pengajar/kelas') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<h5 style="text-align:center;">Kelas <?= $detail_kelas[0]['nama_kelas'] ?></h5>
<h6 style="text-align:center;"><?= $detail_kelas[0]['hari_kelas'] ?>, <?= $detail_kelas[0]['waktu_kelas'] ?> - <?= $detail_kelas[0]['metode_kelas'] ?></h6>
<h6 style="text-align:center;"><?= $detail_kelas[0]['nama_pengajar'] ?></h6>
<?php if($detail_kelas[0]['show_ujian'] == NULL || $detail_kelas[0]['show_ujian'] == '0') { ?>
    <h6 style="text-align:center; color: red;">HASIL UJIAN TIDAK TAMPIL</h6> 
<?php } ?>
<?php if($detail_kelas[0]['show_ujian'] == '1') { ?>
    <h6 style="text-align:center; color: green;">HASIL UJIAN TAMPIL</h6> 
<?php } ?>
<div style="text-align:center;">
    <button type="button" class="mb-2 btn btn-primary"  onclick="show('<?=$detail_kelas[0]['kelas_id']?>')"><i class="fa fa-eye"></i> Tampilkan Hasil Ujian</button>
</div>


<hr>

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
                            <tr>
                                <th width="5%">Pelaksanaan Ujian </th>
                                <th width="95%"><?= $data['tgl_ujian'] ?> <?= $data['waktu_ujian'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Nilai Ujian </th>
                                <th width="95%"><?= $data['nilai_ujian'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Nilai Akhir </th>
                                <th width="95%"><?= $data['nilai_akhir'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Rekomendasi level</th>
                                <th width="95%"><?= $data['next_level'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Note dari Pengajar</th>
                                <th width="95%"><?= $data['ujian_note'] ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info" onclick="edit(<?= $data['ujian_id'] ?>, <?= $data['data_peserta_id'] ?>, <?= $data['data_kelas_id'] ?>, <?= $data['peserta_kelas_id'] ?>)" > <i class="fa fa-edit"></i> Input Nilai</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="viewmodaldataedit"></div>
<div class="viewmodaldatashow"></div>

<script>
    $(document).ready(function () {
        $('.collapse').on('shown.bs.collapse', function () {
            $(this).parent().find(".fa-angle-down").removeClass("fa-angle-down").addClass("fa-angle-up");
        }).on('hidden.bs.collapse', function () {
            $(this).parent().find(".fa-angle-up").removeClass("fa-angle-up").addClass("fa-angle-down");
        });
    });

    function edit(ujian_id, peserta_id, kelas_id, peserta_kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('ujian/edit') ?>",
            data: {
                ujian_id : ujian_id,
                peserta_id : peserta_id,
                kelas_id : kelas_id,
                peserta_kelas_id : peserta_kelas_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaldataedit').html(response.sukses).show();
                    $('#modaledit').modal('show');
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