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

<br>
<?php if($detail_kelas[0]['config_absen'] == 1) { ?>
    <a> 
        <button type="button" class="btn btn-warning mb-3" onclick="aturAbsen('<?= $detail_kelas[0]['kelas_id'] ?>')" ><i class=" fa fa-screwdriver"></i> Pengaturan Absensi Mandiri</button>
    </a>
<?php } ?>


<h5 style="text-align:center;">Kelas <?= $detail_kelas[0]['nama_kelas'] ?></h5>
<h6 style="text-align:center;"><?= $detail_kelas[0]['hari_kelas'] ?>, <?= $detail_kelas[0]['waktu_kelas'] ?> - <?= $detail_kelas[0]['metode_kelas'] ?></h6>
<h6 style="text-align:center;"><?= $detail_kelas[0]['nama_pengajar'] ?></h6>
<h6 style="text-align:center;">Jumlah Peserta = <?= $detail_kelas[0]['jumlah_peserta'] ?></h6>

<p class="mt-1">Catatan :<br> 
    <i class="mdi mdi-information"></i> Kolom 1-16 merupakan kolom Tatap Muka ke-1 (TM-1) sampai Tatap Muka ke-16 (TM-16). <br>
    <!-- <i class="mdi mdi-information"></i> Untuk mengisi absen silahkan <i class=" fa fa-check-square mr-1"></i> <b>Check</b> pada Checkbox di setiap kolom Tatap Muka peserta jika peserta hadir. <br>
    <i class="mdi mdi-information"></i> Isi data absen diri anda dan isikan tanggal Tatap Muka dan catatan Tatap Muka jika terdapat catatan. <br> -->
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

<div class="table-responsive">
    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
            <th width="3%">No.</th>
            <th width="7%">NIS</th>
            <th width="12%"class="name-col" >Nama</th>
            <th width="2%">Note</th>
            <?php for($i = 1; $i <= 16; $i++): ?>
                <th width="3%"><?= $i ?>
                    <button type="button" class="btn btn-sm btn-warning" onclick="tm('tm<?=$i?>', <?= $detail_kelas[0]['kelas_id'] ?>, <?= $detail_kelas[0]['data_absen_pengajar'] ?>)" ><i class=" fa fa-edit"></i></button> 
                </th>
            <?php endfor; ?>
            <th width="5%"class="missed-col">Jumlah <br> Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $nomor = 0;
            foreach ($peserta_onkelas as $data) :
                $nomor++; 
            ?>
            <tr>
                <td ><?= $nomor ?></td>
                <td ><?= $data['nis'] ?></td>
                <td >
                <?php if($data['status_aktif_peserta'] == 'OFF') { ?><del><?php } ?>
                <?= $data['nama_peserta'] ?>
                <?php if($data['status_aktif_peserta'] == 'OFF') { ?></del><?php } ?>
                <?php if($data['status_aktif_peserta'] == 'OFF') { ?><a class="btn btn-sm btn-danger">OFF</a><?php } ?>
                </td>
                <td>
                    <button type="button" class="mt-2 btn btn-info btn-sm"  onclick="note('<?= $data['absen_peserta_id']?>')"><i class="fa fa-file"></i> Note</button>
                </td>
                <?php
                $total = 0;
                for($i = 1; $i <= 16; $i++):
                    $tm = 'tm' . $i;
                ?>
                <td >
                    <?php if($data[$tm] == NULL) { ?>
                        <p></p>
                    <?php } ?>
                    <?php if($data[$tm] == '0') { ?>
                        <i class=" fa fa-minus" style="color:red"></i>
                    <?php } ?>
                    <?php if($data[$tm] == '1') { 
                        $total += 1;
                    ?>
                        <i class=" fa fa-check" style="color:green"></i>
                    <?php } ?>
                </td>
                <?php endfor; ?>
                <td ><?= $total ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<h5 class="mt-3"> <u> Absensi dan Catatan Pengajar</u></h5>

<div class="table-responsive">
    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th width="8%">Tatap Muka (TM)</th>
                <th width="3%">Absensi <br> Pengajar</th>
                <th width="4%">Tanggal Tatap Muka</th>
                <th width="20%">Catatan Tatap Muka</th>
                <!-- <th width="8%">Tanggal Isi <br>Absensi</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tatapMukaData as $tmData): ?>
                <tr>
                    <td><?= $tmData['name'] ?></td>
                    <td>
                        <?php if ($tmData['absensi'] === NULL): ?>
                            <p></p>
                        <?php endif; ?>
                        <?php if ($tmData['absensi'] === '0'): ?>
                            <i class="fa fa-minus" style="color:red"></i>
                        <?php endif; ?>
                        <?php if ($tmData['absensi'] === '1'): ?>
                            <i class="fa fa-check" style="color:green"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($tmData['tanggal'] === '2022-01-01'): ?>
                            <p>-</p>
                        <?php endif; ?>
                        <?php if ($tmData['tanggal'] !== '2022-01-01'): ?>
                            <?= longdate_indo($tmData['tanggal']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $tmData['note'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodaltm">
</div>

<div class="viewmodaltmpgj">
</div>

<div class="viewmodalaturabsen">
</div>

<div class="editNote">
</div>

<script>
    function tm(tm, kelas_id, data_absen_pengajar) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/pengajar/input-absensi') ?>",
            data: {
                tm : tm,
                kelas_id : kelas_id,
                data_absen_pengajar : data_absen_pengajar,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaltm').html(response.sukses).show();
                    $('#modaltm').modal('show');
                }
            }
        });
    }

    function aturAbsen(kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/pengajar/atur-absensi') ?>",
            data: {
                kelas_id : kelas_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalaturabsen').html(response.sukses).show();
                    $('#modalatur').modal('show');
                }
            }
        });
    }

    function note(absen_peserta_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/pengajar/absensi-note')?>",
            data: {
                absen_peserta_id: absen_peserta_id
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