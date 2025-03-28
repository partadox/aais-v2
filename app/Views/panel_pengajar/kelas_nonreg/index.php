<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <div class="col-sm-auto mb-2">
        <label for="tahun_kelas">Pilih Tahun</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="tahun_kelas" id="tahun_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_tahun as $key => $data) { ?>
            <option value="/pengajar/kelas-nonreg?tahun=<?= $data['nk_tahun'] ?>" <?php if ($tahun_pilih == $data['nk_tahun']) echo "selected"; ?> > <?= $data['nk_tahun'] ?> </option>
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
        <?php if (isset($list)) {?>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <div class="col-md-4 mb-3">
                    <div class="card shadow-lg rounded">
                        <div class="card-body">
                            <h5 class="card-title"><?= $nomor ?>. <?= $data['nk_nama'] ?></h5>
                            <p class="card-text">
                                <strong>Tipe Program:</strong> <?= $data['nk_tipe'] ?><br>
                                <strong>Organisasi:</strong> <?= $data['nk_usaha'] ?><br>
                                <strong>Tahun:</strong> <?= $data['nk_tahun'] ?><br>
                                <strong>Hari:</strong> <?= $data['nk_hari'] ?><br>
                                <strong>Jam:</strong> <?= $data['nk_waktu'] ?> <?= $data['nk_timezone'] ?><br>
                                <strong>PIC:</strong> <?= $data['nk_pic_name'] ?> (<?= $data['nk_pic_hp'] ?>)<br>
                                <strong>Alamat:</strong> <?= $data['nk_lokasi'] ?> <br>
                                <strong>Status Kelas:</strong>
                                <?php if($data['nk_status'] == '1') { ?>
                                    <span class="badge badge-success">AKTIF</span>
                                <?php } ?>
                                <?php if($data['nk_status'] == '0') { ?>
                                    <span class="badge badge-secondary">NONAKTIF</span>
                                <?php } ?><br>
                            </p>
                        </div>
                        <div class="card-footer text-left">
                            <a href="/pengajar/absensi-nonreg?kelas=<?= $data['nk_id'] ?>" class="btn btn-info mb-2">
                                <i class="fa fa-user-graduate mr-1"></i>Absensi
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
                    if ($nomor % 3 == 0) {
                        echo '</div><div class="row card-row">'; // close the current row and start a new one after every 3rd card
                    }
                endforeach; ?>
            <?php }?>
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


$('#tahun_kelas').bind('change', function () { // bind change event to select
    var url = $(this).val(); // get selected value
    if (url != '') { // require a URL
        window.location = url; // redirect
    }
    return false;
});
</script>

<?= $this->endSection('isi') ?>