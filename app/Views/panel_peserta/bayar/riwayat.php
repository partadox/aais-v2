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
        <select onchange="javascript:location.href = this.value;" class="form-control select2 mb-2" name="angkatan_kelas" id="angkatan_kelas">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/bayar/riwayat?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?> > <?= $data['angkatan_kelas'] ?> </option>
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
                        <hr>
                            <strong>Transaksi ID:</strong> <?= $data['bayar_id'] ?> <br>
                            <?php if($data['metode'] == NULL) { ?>
                                <strong>Metode: Transfer Manual</strong>
                            <?php } ?>
                            <?php if($data['metode'] == 'flip') { ?>
                                <strong>Metode:Flip</strong>
                            <?php } ?>
                            <?php if($data['metode'] == 'beasiswa') { ?>
                                <strong>Metode: Kode Beasiswa</strong>
                            <?php } ?>
                        <br>
                            <?php if($data['tgl_bayar'] == '1000-01-01' || $data['tgl_bayar'] == NULL) { ?>
                                <a><strong>Tgl Bayar:</strong> -</a> <br>
                            <?php } ?>
                            <?php if($data['tgl_bayar'] != '1000-01-01' && $data['tgl_bayar'] == NULL) { ?>
                                <a><strong>Tgl Bayar:</strong>  <?= shortdate_indo($data['tgl_bayar'])?></a> <br>
                            <?php } ?>
                            <?php if($data['waktu_bayar'] == '00:00:00') { ?>
                            <a><strong>Waktu Bayar:</strong> -</a> <br>
                            <?php } ?>
                            <?php if($data['waktu_bayar'] != '00:00:00') { ?>
                                <a><strong>Waktu Bayar:</strong> <?= $data['waktu_bayar'] ?></a> <br>
                            <?php } ?>
                        <strong>Ket. Peserta:</strong> <?= $data['keterangan_bayar'] ?>
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
                        <?php if($data['metode'] == NULL) { ?>
                            <button class="expandButton">Lihat Bukti Upload</button>

                            <div class="zoom-container mt-2">
                                <img class="zoom-image" title="" src="<?= base_url('public/img/transfer/' . $data['bukti_bayar']) ?>" alt="" align="right" border="1" hspace="" vspace="" />
                            </div>
                        <?php } ?>
                        <?php if($data['metode'] == 'flip') { ?>
                            <strong>Total Transfer: Rp <?= rupiah($data['bill_amount']) ?></strong> <br>
                            <strong>Bank: <?= $data['bill_bank'] ?> </strong> <br>
                            <?php if($data['status_konfirmasi'] == 'Proses') { ?>
                                <strong>VA: <?= $data['bill_va'] ?> </strong>
                                <input style="display: none;" type="text" id="vaCopy<?= $nomor ?>" value="<?= $data['bill_va'] ?>">
                                <br> <strong>Expired: <?= $data['bill_expired'] ?>  </strong> <br>
                                <button class="expandPay btn btn-sm btn-info">Lihat Cara Bayar</button>

                                <div class="caraBayar mt-2" style="display: none;">
                                    <u>Cara Bayar:</u>
                                    <?php if($data['bill_bank'] == 'BSI') { ?>
                                        <ol>
                                            <li>Buka aplikasi BSI Mobile kemudian pilih menu Transfer.</li>
                                            <li>Pilih menu Pembayaran.</li>
                                            <li>Pilih menu E-Commerce.</li>
                                            <li>Pilih “DOKU”.</li>
                                            <li>Pilih nomor rekening.</li>
                                            <li>Masukkan nomor Virtual Account (VA) diatas.</li>
                                            <li>Pastikan jumlah transfernya sudah sesuai.</li>
                                            <li>Masukkan PIN BSI Mobile.</li>
                                            <li>Transaksi selesai.</li>
                                        </ol>
                                    <?php } ?>
                                    <?php if($data['bill_bank'] == 'BRI') { ?>
                                        <ol>
                                            <li>Buka aplikasi BRIMO kemudian pilih menu BRIVA.</li>
                                            <li>Masukkan nomor Virtual Account (VA) diatas.</li>
                                            <li>Pastikan jumlah transfernya sudah sesuai.</li>
                                            <li>Masukkan PIN BRIMO.</li>
                                            <li>Transaksi selesai.</li>
                                        </ol>
                                    <?php } ?>
                                    <?php if($data['bill_bank'] == 'MANDIRI') { ?>
                                        <ol>
                                            <li>Buka aplikasi Livin by Mandiri pilih menu Transfer Rupiah.</li>
                                            <li>Klik tombol transfer ke penerima baru.</li>
                                            <li>Pilih Bank penerima yaitu bank Mandiri.</li>
                                            <li>Masukkan nomor Virtual Account (VA) diatas.</li>
                                            <li>Klik Lanjutkan.</li>
                                            <li>Ketikan nominal transfer sesuai dengan Total Transfer diatas.</li>
                                            <li>Konfirmasi pembayaran dan pastikan terdapat nama anda dibawah tulisan Doku VA Agregrator.</li>
                                            <li>Transaksi selesai.</li>
                                        </ol>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <p class="card-text">
                            <hr>
                            <h6><strong>Rincian</strong></h6>
                            <?php if($data['status_konfirmasi'] == 'Terkonfirmasi') { ?>
                                <a><strong>Total:</strong> Rp <?= rupiah($data['nominal_bayar']) ?></a> <br>
                                <a><strong>Daftar:</strong> Rp <?= rupiah($data['awal_bayar_daftar']) ?></a> <br>
                                <a><strong>SPP1:</strong> Rp <?= rupiah($data['awal_bayar_spp1']) ?></a> <br>
                                <a><strong>SPP2:</strong> Rp <?= rupiah($data['awal_bayar_spp2']) ?></a> <br>
                                <a><strong>SPP3:</strong> Rp <?= rupiah($data['awal_bayar_spp3']) ?></a> <br>
                                <a><strong>SPP4:</strong> Rp <?= rupiah($data['awal_bayar_spp4']) ?></a><br>
                                <a><strong>Modul:</strong> Rp <?= rupiah($data['awal_bayar_modul']) ?></a> <br>
                                <a><strong>Infaq:</strong> Rp <?= rupiah($data['awal_bayar_infaq']) ?></a> <br>
                                <a><strong>Lain:</strong> Rp <?= rupiah($data['awal_bayar_lainnya']) ?></a> 
                                <?php if($data['metode'] == 'flip') { ?>
                                    <br><a><strong>Biaya Transaksi:</strong> Rp <?= rupiah($data['nominal_bayar'] - ($data['awal_bayar_daftar']+$data['awal_bayar_spp1']+$data['awal_bayar_spp2']+$data['awal_bayar_spp3']+$data['awal_bayar_spp4']+$data['awal_bayar_modul']+$data['awal_bayar_infaq']+$data['awal_bayar_lainnya'])) ?></a> 
                                <?php } ?>
                            <?php } ?>
                            <?php if($data['status_konfirmasi'] == 'Proses') { ?>
                                <button class="btn btn-warning btn-sm mb-2" disabled>Proses</button>
                            <?php } ?>
                            <hr>
                            <h6><strong>Status Konfirmasi:</strong></h6>
                            <?php if($data['status_konfirmasi'] == 'Proses') { ?>
                                <button class="btn btn-secondary btn-sm" disabled>Proses</button> 
                            <?php } ?>
                            <?php if($data['status_konfirmasi'] == 'Terkonfirmasi') { ?>
                                <button class="btn btn-success btn-sm mb-2" disabled>Terkonfirmasi</button>
                            <?php } ?>
                            <?php if($data['status_konfirmasi'] == 'Tolak') { ?>
                                <button class="btn btn-danger btn-sm mb-2" disabled>Tolak</button>
                            <?php } ?>
                            <?php if($data['status_konfirmasi'] == 'Gagal') { ?>
                                <button class="btn btn-danger btn-sm mb-2" disabled>Gagal</button>
                            <?php } ?>
                            <hr>
                            <h6><strong>Status Pembayaran: </strong></h6>
                            <?php if($data['status_bayar_admin'] == 'SESUAI BAYAR') { ?>
                                <button class="btn btn-success btn-sm mb-2" disabled>SESUAI BAYAR</button>
                            <?php } ?>
                            <?php if($data['status_bayar_admin'] != 'SESUAI BAYAR') { ?>
                                <button class="btn btn-secondary btn-sm mb-2" disabled><?= $data['status_bayar_admin'] ?></button>
                            <?php } ?>
                            <br>
                            <a><b>Tgl Bayar:</b> <?= shortdate_indo($data['tgl_bayar']) ?></a>
                            <br>
                            <a><b>Waktu Bayar:</b> <?= $data['waktu_bayar'] ?></a>
                            <br>
                            <a><b>Keterangan Admin:</b> <?= $data['keterangan_bayar_admin'] ?></a>

                            <br>
                            <?php if($data['tgl_bayar_konfirmasi'] == '1000-01-01' || $data['tgl_bayar_konfirmasi'] == NULL) { ?>
                            <a><b>Tgl Konfirmasi:</b> -</a> <br>
                            <?php } ?>
                            <?php if($data['tgl_bayar_konfirmasi'] != '1000-01-01' && $data['tgl_bayar_konfirmasi'] != NULL) { ?>
                                <a><b>Tgl Konfirmasi:</b> <?= shortdate_indo($data['tgl_bayar_konfirmasi'])?></a> <br>
                            <?php } ?>
                            <?php if($data['waktu_bayar_konfirmasi'] == '00:00:00') { ?>
                            <a><b>Waktu Konfirmasi:</b> -</a> <br>
                            <?php } ?>
                            <?php if($data['waktu_bayar_konfirmasi'] != '00:00:00') { ?>
                                <p><b>Waktu Konfirmasi:</b> <?= $data['waktu_bayar_konfirmasi'] ?></p> <br>
                        <?php } ?>
                        </p>
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
        const vaCopyElements = document.querySelectorAll("input[id^='vaCopy']");
        for (const vaCopyElement of vaCopyElements) {
            const copyButton = document.createElement("button");
            copyButton.id = vaCopyElement.id + "-copy";
            copyButton.innerHTML = "<i class='fas fa-copy mr-1'></i> Copy VA";
            copyButton.addEventListener("click", function() {
                navigator.clipboard.writeText(vaCopyElement.value);
                copyButton.innerHTML = "VA Copied";
            });

            vaCopyElement.insertAdjacentElement("afterend", copyButton);
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
    $(document).ready(function(){
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });
        $(".expandButton").click(function(){
            $(this).next('.zoom-container').toggle(); // This will only toggle the zoom-container that is directly after the clicked button
        });
        $(".expandPay").click(function(){
            $(this).next('.caraBayar').toggle();
        });
    });
    </script>
<?= $this->endSection('isi') ?>