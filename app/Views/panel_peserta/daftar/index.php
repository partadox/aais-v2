<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<?php if ($status_pendaftaran == 'TUTUP') { ?>
    <div class="card col d-flex justify-content-center">
        <div class="card-body">
            <h5 class="card-title">PENDAFTARAAN PROGRAM AL-HAQQ BELUM DIBUKA</h5>
            <h6 class="card-subtitle mb-2 text-muted">Pengumuman</h6>
            <p class="card-text"> <b>Assalamu’alaikum Warahmatullahi Wabarakatuh</b> <br>
            Kami menginformasikan kepada seluruh peserta atau calon peserta program Al-Haqq, pendaftaran kelas pada program Al-Haqq untuk saat ini belum dibuka. Ikuti terus informasi terbaru kami melalui website atau anda langsung dapat menghubungi kami melalui kontak berikut : 0899-8049-000. <br>
            <b>Wassalamualaikum Warahmatullahi Wabarakatuh</b> <br> <br>
            <b>Hormat Kami,</b> <br>
            <i>Admin & Pengurus Al-Haqq</i>
            </p>
        </div>
    </div>
    <?php } ?>

<?php if ($status_pendaftaran == 'BUKA') { ?>
        <?php if ($cek != 0) { ?>
            <div class="card col d-flex justify-content-center shadow">
                <div class="card-body">
                    <h5 class="card-title">Proses Pemilihan Kelas Masih Belum Selesai.</h5>
                    <p class="card-text"> 
                    Anda Perlu Menyelesaikan Proses Pembayaran Sebelum Memilih Kelas Lain <?= $cek ?>
                    </p>
                </div>
            </div>
        <?php } ?>

        <?php if ($cek == 0 ) { ?>
        <div class="container-fluid">
        <p class="mt-1">Catatan :<br>
            <i class="mdi mdi-information"></i> Anda harus memilih level kelas yg akan anda ikuti. <br>
            <i class="mdi mdi-information"></i> Jadwal kelas akan muncul ketika anda telah memilih. <br>
            <i class="mdi mdi-information"></i> Pilih kelas yang masih memiliki kuota. <br>
        </p>

        <?= form_open('daftar/level_update', ['class' => 'formtambahlevel']) ?>
        <?= csrf_field() ?>
        <div class="form-group">
        <input type="hidden" id="peserta_id" name="peserta_id" value="<?=$peserta['peserta_id'] ?>">
            <div class="mb-3">
            <label class="form-label">Silahkan Memilih Level Kelas Terlebih Dahulu <code>*</code></label>
                
                <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single mb-2" name="level_peserta" id="level_peserta">
                    <?php foreach ($tampil_ondaftar as $key => $data) { ?>
                    <option value="/daftar?level=<?= $data['peserta_level_id'] ?>" <?php if ($level == $data['peserta_level_id']) echo "selected"; ?> > <?= $data['nama_level'] ?> </option>
                    <?php } ?>
                </select>
            <!-- <div class="invalid-feedback errorLevel_peserta"> -->
            </div>
        </div>
        <?= form_close() ?> 
        
        <div class="row">
            <?php
            foreach ($program as $data) :
            ?>
            <div class="col-sm-3 col-md-3">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h6><?= $data['nama_program'] ?></h6>
                    <h5 class="card-title"><?= $data['nama_kelas'] ?></h5>
                    <hr>
                    <p> <i class="mdi mdi-calendar"></i> Hari = <?= $data['hari_kelas'] ?> </p>
                    <p> <i class="mdi mdi-clock"></i> Waktu = <?= $data['waktu_kelas'] ?></p>
                    <a> <i class="mdi mdi-teach"></i>
                        <?php if($data['metode_kelas'] == 'OFFLINE') { ?>
                            Metode Perkuliahan = <span class="badge badge-secondary">TATAP MUKA / OFFLINE</span>
                        <?php } ?>
                        <?php if($data['metode_kelas'] == 'ONLINE') { ?>
                            Metode Perkuliahan = <span class="badge badge-success">DARING / ONLINE</span>
                        <?php } ?>
                    </a>
                    <hr>
                    <p> <i class="mdi mdi-cash-marker"></i> Biaya Pendaftaran = Rp <?= rupiah($data['biaya_daftar']) ?></p>
                    <p> <i class="mdi mdi-cash-marker"></i> Biaya Modul = Rp <?= rupiah($data['biaya_modul']) ?></p>
                    <p> <i class="mdi mdi-cash-register"></i> SPP per Bulan = Rp <?= rupiah($data['biaya_bulanan']) ?> (x 4 Bulan)</p>
                    <hr>
                    <p> <i class="mdi mdi-bookmark-check"></i> Total Kuota = <?= $data['kouta'] ?></p>
                    <h6> <i class="mdi mdi-bookmark-minus"> </i> Sisa Kuota = <?= $data['kouta']-$data['peserta_kelas_count'] ?> </h6>
                    
                    <input type="hidden" name="peserta_id" id="peserta_id" value="<?= $peserta['peserta_id'] ?>" />
                    <input type="hidden" name="kelas_id" id="kelas_id" value="<?= $data['kelas_id'] ?>" />
                    <input type="hidden" name="biaya_daftar" id="biaya_daftar" value="<?= $data['biaya_daftar'] ?>" />
                    <input type="hidden" name="biaya_bulanan" id="biaya_bulanan" value="<?= $data['biaya_bulanan'] ?>" />
                    <?php if( $data['kouta']-$data['peserta_kelas_count'] == '0') { ?>
                        <button type="button" class="btn btn-danger btn-sm" disabled>PENUH</button>
                    <?php } ?>
                    <?php if( $data['peserta_status'] == 1) { ?>
                        <br><b>ANDA SUDAH TERDAFTAR DI KELAS INI</b>
                    <?php } ?>
                    <?php if($data['peserta_status'] == 0 && $data['kouta']-$data['peserta_kelas_count'] != '0') { ?>
                        <input type='submit' class='btn btn-warning align-right btnsimpan' value='Daftar' onclick="daftar('<?= $data['kelas_id'] ?>')"></input>
                    <?php } ?>
                    
                </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        </div>
        <?php } ?>

        
<?php } ?>


<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            minimumResultsForSearch: Infinity
        });
    });
    function daftar(kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('daftar/save') ?>",
            data: {
                peserta_id: $('input#peserta_id').val(),
                kelas_id: kelas_id,
            },
            dataType: "json",
            beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="fa fa-share-square"></i>  Daftar');
                },
                success: function(response) {
                  if (response.error) {

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Anda Berhasil Memilih Program, Silahkan Lanjutkan Pembayaran!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                                window.location = response.sukses.link;
                        });
                    }
                }
        });
    }

    $('.formtambahlevel').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    peserta_id: $('input#peserta_id').val(),
                    level_peserta: $('select#level_peserta').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btncari').attr('disable', 'disable');
                    $('.btncari').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btncari').removeAttr('disable', 'disable');
                    $('.btncari').html('<i class="fa fa-share-square"></i>  Pilih');
                },
                success: function(response) {
                    if (response.error) {

                        // if (response.error.level_peserta) {
                        //     $('#level_peserta').addClass('is-invalid');
                        //     $('.errorLevel_peserta').html(response.error.level_peserta);
                        // } else {
                        //     $('#level_peserta').removeClass('is-invalid');
                        //     $('.errorLevel_peserta').html('');
                        // }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Akun Anda berhasil Memilih Level Kelas!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                                window.location = response.sukses.link;
                        });
                    }
                }
            });
        })

        $('#level_peserta').bind('change', function () { // bind change event to select
            var url = $(this).val(); // get selected value
            if (url != '') { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
</script>
<?= $this->endSection('isi') ?>