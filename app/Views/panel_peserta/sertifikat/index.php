<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <?php if ($status_sertifikat == "BUKA") {?>
        <div class="col-sm-auto">
            <a href="<?= base_url("peserta/sertifikat-input") ?>" type="button" class="btn btn-primary mb-3" ><i class=" fa fa-plus-circle"></i> Pengajuan Sertifikat</a>
        </div>
    <?php }?>
    <?php if ($status_sertifikat == "TUTUP") {?>
        <div class="card col d-flex justify-content-center">
            <div class="card-body">
                <p class="text-center"><strong>PENGAJUAN SERTIFIKAT BELUM DIBUKA</strong></p>
            </div>
        </div>
    <?php }?>
</div>

<div class="container mt-3">
    <?php if (count($list) == 0) {?>
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-center">- Anda Belum Memiliki Data Pengajuan Sertifikat -</p>
            </div>
        </div>
    <?php }?>
    <div class="row card-row">
        <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++; ?>
            <div class="col-md-4 mb-3">
                <div class="card shadow-lg rounded">
                    <div class="card-body">
                        <h5 class="card-title">Sertifikat 
                            <?php if($data['sertifikat_kelas'] == '1') { ?>
                                <?= $data['nama_program'] ?>
                            <?php } ?>
                            <?php if($data['sertifikat_kelas'] != '1') { ?>
                                <?= $data['nama_program'] ?> (<?= $data['nama_kelas'] ?>)
                            <?php } ?>
                        </h5>
                        <p class="card-text">
                            <strong>Waktu Pengajuan:</strong> <?= shortdate_indo($data['tgl_bayar']) ?> <?= $data['waktu_bayar'] ?> WITA<br>
                            <strong>Waktu Konfirmasi:</strong>
                            <?php if($data['status_konfirmasi'] == 'Terkonfirmasi') { ?>
                                <?= shortdate_indo($data['tgl_bayar_konfirmasi']) ?> <?= $data['waktu_bayar_konfirmasi'] ?> WITA
                            <?php } ?>
                            <br>
                            <strong>Program:</strong> <?= $data['nama_program'] ?><br>
                            <strong>Status:</strong>
                            <?php if($data['status_konfirmasi'] == 'Proses') { ?>
                                <span class="badge badge-secondary">Proses</span>
                            <?php } ?>
                            <?php if($data['status_konfirmasi'] == 'Terkonfirmasi') { ?>
                                <span class="badge badge-success">Terkonfirmasi</span>
                            <?php } ?> <br>
                            <strong>Biaya Sertifikat:</strong> Rp. <?= rupiah($data['awal_bayar_spp1']) ?><br>
                            <strong>Infaq:</strong> Rp. <?= rupiah($data['awal_bayar_infaq']) ?><br>
                            <strong>Total TF:</strong> Rp. <?= rupiah($data['nominal_bayar']) ?><br>
                            <strong>Keterangan Peserta:</strong> <?= $data['keterangan_bayar'] ?> <br>
                            <strong>Keterangan Admin:</strong> <?= $data['keterangan_bayar_admin'] ?> <br>
                            <hr>
                            <style>
                            .zoom-container {
                                width: 100%;
                                position: relative;
                                overflow: hidden;
                                transition: transform .2s;
                                display: none; /* initially, the image is hidden */
                            }

                            .zoom-container::before {
                                content: "";
                                display: block;
                                padding-top: 100%;  /* This gives the 1:1 aspect ratio (square shape) */
                            }

                            .zoom-container:hover {
                                transform: scale(1.5);  /* Reduce scale to 1.5 */
                            }

                            .zoom-image {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                object-fit: cover;  /* This scales the image while maintaining aspect ratio */
                                object-position: center;  /* This centers the image within its box */
                            }
                            </style>
                            <button class="expandButton">Lihat Bukti Bayar</button>

                            <div class="zoom-container mt-2">
                                <img class="zoom-image" title="" src="<?= base_url('public/img/transfer/' . $data['bukti_bayar']) ?>" alt="" align="right" border="1" hspace="" vspace="" />
                            </div>
                            <hr>
                            <strong>Nomor Sertifikat:</strong>
                            <?php if ($data['nomor_sertifikat'] != "0") {?>
                                <?= $data['nomor_sertifikat'] ?>
                            <?php }?>
                            <br>
                            <strong>Tgl Sertifikat:</strong>
                                <?php if ($data['sertifikat_status'] == 1) {?>
                                    <?= shortdate_indo($data['sertifikat_tgl']) ?> 
                                <?php }?><br>
                    </div>
                    <div class="card-footer text-left">
                        <?php if ($data['sertifikat_status'] == 1 && $data['unshow'] != 1) {?>
                            <button type="button" class="btn btn-warning mb-2" onclick="modal('<?= $data['sertifikat_id'] ?>')" ><i class="mdi mdi-certificate mr-1"></i>e-Sertifikat</button>
                        <?php }?>
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
    <div class="viewmodal"></div>

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


    // $('#angkatan_kelas').bind('change', function () { // bind change event to select
    //     var url = $(this).val(); // get selected value
    //     if (url != '') { // require a URL
    //         window.location = url; // redirect
    //     }
    //     return false;
    // });

    $(document).ready(function(){
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });

        $(".expandButton").click(function(){
            $(this).next('.zoom-container').toggle(); // This will only toggle the zoom-container that is directly after the clicked button
        });
    });

    function modal(sertifikat_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/peserta/sertifikat-show') ?>",
            data: {
                sertifikat_id : sertifikat_id
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
</script>

<?= $this->endSection('isi') ?>