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
<a href="<?= base_url('/pengajar/ujian?kelas='.$detail_kelas[0]['kelas_id']) ?>"> 
    <button type="button" class="btn btn-success mb-3"><i class="fa fa-bars"></i> Tampilan Baris</button>
</a>

<h5 style="text-align:center;">Kelas <?= $detail_kelas[0]['nama_kelas'] ?></h5>
<h6 style="text-align:center;"><?= $detail_kelas[0]['hari_kelas'] ?>, <?= $detail_kelas[0]['waktu_kelas'] ?> - <?= $detail_kelas[0]['metode_kelas'] ?></h6>
<h6 style="text-align:center;"><?= $detail_kelas[0]['nama_pengajar'] ?></h6>
<?php if($detail_kelas[0]['ujian_show'] == NULL || $detail_kelas[0]['ujian_show'] == '0') { ?>
    <h6 style="text-align:center; color: red;">HASIL UJIAN TIDAK TAMPIL</h6> 
<?php } ?>
<?php if($detail_kelas[0]['ujian_show'] == '1') { ?>
    <h6 style="text-align:center; color: green;">HASIL UJIAN TAMPIL</h6> 
<?php } ?>
<!-- <div style="text-align:center;">
    <button type="button" class="mb-2 btn btn-primary"  onclick="show('<?=$detail_kelas[0]['kelas_id']?>')"><i class="fa fa-eye"></i> Tampilkan Hasil Ujian</button>
</div> -->


<hr>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Status Kelulusan</th>
                <th>Input Nilai</th>
                <th>Pelaksanaan Ujian</th>
                <th>Nilai Ujian</th>
                <th>Nilai Akhir</th>
                <th>Rekomendasi level</th>
                <th>Note dari Pengajar</th>
                
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($peserta_onkelas as $data) :
                $nomor++; ?>
                <tr>
                    <td width="2%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['nis'] ?></td>
                    <td width="5%"><?= $data['nama_peserta'] ?> <?php if($data['status_aktif_peserta'] == 'OFF') { ?><a style="color: red;">(OFF)</a><?php } ?></td>
                    <td width="10%">
                        <?php if($data['status_peserta_kelas'] == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'MENGULANG') { ?>
                            <button class="btn btn-warning btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    </td>
                    <td width="5%">
                        <button type="button" class="btn btn-warning" onclick="edit(<?= $data['ujian_id'] ?>, <?= $data['data_peserta_id'] ?>, <?= $data['data_kelas_id'] ?>, <?= $data['peserta_kelas_id'] ?>)" > <i class="fa fa-edit"></i></button>
                    </td>
                    <td width="10%"><?= $data['tgl_ujian'] ?> <?= $data['waktu_ujian'] ?></td>
                    <td width="10%"><?= $data['nilai_ujian'] ?></td>
                    <td width="10%"><?= $data['nilai_akhir'] ?></td>
                    <td width="10%"><?= $data['next_level'] ?></td>
                    <td width="10%"><?= $data['ujian_note'] ?></td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

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