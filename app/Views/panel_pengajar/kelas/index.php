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
            <option value="/pengajar/kelas?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?> > <?= $data['angkatan_kelas'] ?> </option>
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
                            <strong>Level:</strong> <?= $data['nama_level'] ?><br>
                            <strong>Jumlah Peserta:</strong> <?= $data['peserta_kelas_count'] ?><br>
                            <strong>Status Kelas:</strong>
                            <?php if($data['status_kelas'] == 'aktif') { ?>
                                <span class="badge badge-success">AKTIF</span>
                            <?php } ?>
                            <?php if($data['status_kelas'] == 'nonaktif') { ?>
                                <span class="badge badge-secondary">NONAKTIF</span>
                            <?php } ?><br>
                        </p>
                    </div>
                    <div class="card-footer text-left">
                        <a href="/pengajar/absensi?kelas=<?= $data['kelas_id'] ?>" class="btn btn-info">
                            <i class="fa fa-user-graduate mr-1"></i>Absensi
                        </a>
                        <a href="/pengajar/ujian?kelas=<?= $data['kelas_id'] ?>" class="btn btn-warning">
                            <i class="fa fa-file-archive mr-1"></i>Hasil Ujian
                        </a>
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


<script>

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