<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <div class="col-sm-auto mb-2">
        <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas" id="angkatan_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/peserta-kelas?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?> > <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-auto">
        <label for="searchInput">Pencarian</label>
        <input class="form-control" type="text" id="searchInput" onkeyup="cardSearch()" placeholder="Ketikan kata kunci..">
    </div>
</div>

<div class="container mt-3">
    <div class="row card-row">
        <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-lg rounded">
                    <div class="card-body">
                        <h5 class="card-title"><?= $nomor ?>. <?= $data['nama_kelas'] ?></h5>
                        <p class="card-text">
                            <strong>Angkatan Perkuliahan:</strong> <?= $data['angkatan_kelas'] ?><br>
                            <strong>Program:</strong> <?= $data['nama_program'] ?><br>
                            <strong>Hari:</strong> <?= $data['hari_kelas'] ?><br>
                            <strong>Jam:</strong> <?= $data['waktu_kelas'] ?> <?= $data['zona_waktu_kelas'] ?><br>
                            <strong>Metode TM:</strong>
                            <?php if($data['metode_kelas'] == 'ONLINE') { ?>
                                <span class="badge badge-primary">ONLINE</span>
                            <?php } ?>
                            <?php if($data['metode_kelas'] == 'OFFLINE') { ?>
                                <span class="badge badge-info">OFFLINE</span>
                            <?php } ?><br>
                            <hr>
                            <?php 
                                $totalBiaya = $data['biaya_daftar'] + $data['biaya_program'];
                                $totalBayar = $data['byr_daftar'] + $data['byr_spp1'] + $data['byr_spp2'] + $data['byr_spp3'] + $data['byr_spp4'];
                                $totalBeasiswa = 0;

                                // Jika beasiswa diterima, anggap sebagai pembayaran
                                if($data['beasiswa_daftar'] == 1) {
                                    $totalBeasiswa += $data['biaya_daftar'];
                                }
                                if($data['beasiswa_spp1'] == 1) {
                                    $totalBeasiswa += $data['biaya_bulanan'];
                                }
                                if($data['beasiswa_spp2'] == 1) {
                                    $totalBeasiswa += $data['biaya_bulanan'];
                                }
                                if($data['beasiswa_spp3'] == 1) {
                                    $totalBeasiswa += $data['biaya_bulanan'];
                                }
                                if($data['beasiswa_spp4'] == 1) {
                                    $totalBeasiswa += $data['biaya_bulanan'];
                                }
                                // total pembayaran ditambah dengan total beasiswa
                                $totalBayar += $totalBeasiswa;

                                if($totalBiaya - $totalBayar != 0) { ?>
                                    <strong>Status SPP: </strong>  <button class="btn btn-warning btn-sm mb-2" disabled>BELUM LUNAS</button> <br>
                            <?php } ?>
                            <?php if($totalBiaya - $totalBayar == 0) { ?>
                                <strong>Status SPP: </strong> <button class="btn btn-success btn-sm mb-2" disabled>LUNAS</button> <br>
                            <?php } ?>
                            <strong>Pendaftaran: </strong> 
                                <?php if($data['byr_daftar'] == $data['biaya_daftar']) { ?>
                                    <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($data['byr_daftar']) ?>
                                <?php } ?>
                                <?php if($data['beasiswa_daftar'] == 1) { ?>
                                    <span class="badge badge-success">Beasiswa</span>
                                <?php } ?>
                            <br>
                            <strong>SPP-1: </strong> 
                                <?php if($data['byr_spp1'] == $data['biaya_bulanan']) { ?>
                                    <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($data['byr_spp1']) ?>
                                <?php } ?>
                                <?php if($data['beasiswa_spp1'] == 1) { ?>
                                    <span class="badge badge-success">Beasiswa</span>
                                <?php } ?>
                            <br>
                            <strong>SPP-2: </strong> 
                                <?php if($data['byr_spp2'] == $data['biaya_bulanan']) { ?>
                                    <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($data['byr_spp2']) ?>
                                <?php } ?>
                                <?php if($data['beasiswa_spp2'] == 1) { ?>
                                    <span class="badge badge-success">Beasiswa</span>
                                <?php } ?>
                            <br>
                            <strong>SPP-3: </strong> 
                                <?php if($data['byr_spp3'] == $data['biaya_bulanan']) { ?>
                                    <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($data['byr_spp3']) ?>
                                <?php } ?>
                                <?php if($data['beasiswa_spp3'] == 1) { ?>
                                    <span class="badge badge-success">Beasiswa</span>
                                <?php } ?>
                            <br>
                            <strong>SPP-4: </strong> 
                                <?php if($data['byr_spp4'] == $data['biaya_bulanan']) { ?>
                                    <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($data['byr_spp4']) ?>
                                <?php } ?>
                                <?php if($data['beasiswa_spp4'] == 1) { ?>
                                    <span class="badge badge-success">Beasiswa</span>
                                <?php } ?>
                            <br>
                            <strong>Modul: </strong> 
                                <?php if($data['byr_modul'] == $data['biaya_modul']) { ?>
                                   Rp <?= rupiah($data['byr_modul']) ?>
                                <?php } ?>
                            <br>
                        </p>
                    </div>
                    <div class="card-footer text-left">
                        <a href="/bayar/spp?kelas=<?= $data['kelas_id'] ?>" class="btn btn-primary mb-2">
                            <i class="fa fa-cash-register mr-1"></i>Bayar
                        </a>
                        <!-- <button type="button" class="btn btn-info mb-2" onclick="absensi('<?= $data['data_absen'] ?>','<?= $data['kelas_id'] ?>')" ><i class="fa fa-user-graduate mr-1"></i>Absensi</button> -->
                        <a href="/peserta/absensi-regular?absen=<?= $data['data_absen'] ?>&kelas=<?= $data['kelas_id'] ?>" class="btn btn-info mb-2">
                            <i class="fa fa-user-graduate mr-1"></i>Absensi
                        </a>
                        <button type="button" class="btn btn-warning mb-2" onclick="ujian('<?= $data['data_ujian'] ?>','<?= $data['kelas_id'] ?>')" ><i class="fa fa-file mr-1"></i>Ujian</button>
                    </div>
                </div>
            </div>
            <?php 
                if ($nomor % 3 == 0) {
                    echo '</div><div class="row card-row">'; // close the current row and start a new one after every 3rd card
                }
            endforeach; ?>
            <?php
            foreach ($list_bina as $data) :
                $nomor++; ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-lg rounded">
                        <div class="card-body">
                            <h5 class="card-title"><?= $nomor ?>. <?= $data['bk_name'] ?></h5>
                            <p class="card-text">
                                <strong>Angkatan Perkuliahan:</strong> <?= $data['bk_angkatan'] ?><br>
                                <strong>Hari:</strong> <?= $data['bk_hari'] ?><br>
                                <strong>Jam:</strong> <?= $data['bk_waktu'] ?> <?= $data['bk_timezone'] ?><br>
                                <strong>Metode TM:</strong>
                                <?php if($data['bk_tm_methode'] == 'ONLINE') { ?>
                                    <span class="badge badge-primary">ONLINE</span>
                                <?php } ?>
                                <?php if($data['bk_tm_methode'] == 'OFFLINE') { ?>
                                    <span class="badge badge-info">OFFLINE</span>
                                <?php } ?><br>
                                <?php if($data['bk_tm_methode'] == 'HYBRID') { ?>
                                    <span class="badge badge-primary">HYBRID</span>
                                <?php } ?><br>
                            </p>
                        </div>
                        <div class="card-footer text-left">
                            <?php if(($data['bk_absen_status'] == 1 && $data['bk_absen_koor'] == $data['bs_peserta']) || ($data['bk_absen_status'] == 1 && $data['bk_absen_methode'] == 'Mandiri')) { ?>
                                <a href="/peserta/absensi-bina?bs=<?= $data['bs_id'] ?>&bk=<?= $data['bs_kelas'] ?>" class="btn btn-info mb-2">
                                    <i class="fa fa-user-graduate mr-1"></i>Absensi
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php 
                    if ($nomor % 3 == 0) {
                        echo '</div><div class="row card-row">'; // close the current row and start a new one after every 3rd card
                    }
                endforeach; ?>
    </div>
</div>
    <div class="viewmodalabsensi"></div>
    <div class="viewmodalujian"></div>

<script>
function ujian(ujian, kelas) {
    $.ajax({
        type: "post",
        url: "<?= site_url('/peserta/ujian') ?>",
        data: {
            data_ujian : ujian,
            kelas_id: kelas
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                $('.viewmodalujian').html(response.sukses).show();
                $('#modalujian').modal('show');
            }
        }
    });
}

function absensi(absensi, kelas) {
    $.ajax({
        type: "post",
        url: "<?= site_url('/peserta/absensi') ?>",
        data: {
            data_absen : absensi,
            kelas_id: kelas
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                $('.viewmodalabsensi').html(response.sukses).show();
                $('#modalabsen').modal('show');
            }
        }
    });
}

function cardSearch() {
    // Declare variables
    var input, filter, cardRows, cards, title, i, j;
    input = document.getElementById('searchInput');
    filter = input.value.toUpperCase();
    cardRows = document.getElementsByClassName('card-row');
    for (i = 0; i < cardRows.length; i++) {
        cards = cardRows[i].getElementsByClassName('card');
        for (j = 0; j < cards.length; j++) {
            title = cards[j].querySelector(".card-body h5.card-title");
            if (title.innerText.toUpperCase().indexOf(filter) > -1) {
                cards[j].style.display = "";
            } else {
                cards[j].style.display = "none";
            }
        }
    }
}


$('#angkatan_kelas').bind('change', function () { // bind change event to select
    var url = $(this).val(); // get selected value
    if (url != '') { // require a URL
        window.location = url; // redirect
    }
    return false;
});
</script>

<?= $this->endSection('isi') ?>