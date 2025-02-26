<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('kelas-regular/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
            <p class="mt-1">Catatan :<br> 
                    <!-- <i class="mdi mdi-information"></i> Status Kerja merupakan parameter yang berfungsi untuk filter peserta Bekerja / Tidak. <br>
                    <i class="mdi mdi-information"></i> Peserta status dalam ikatan kerja maka dapat memilih kelas pada hari weekdays dan weekend. <br>
                    <i class="mdi mdi-information"></i> Peserta status <code>tidak</code> dalam ikatan kerja maka hanya dapat memilih kelas pada hari-hari weekdays. <br> -->
                    <i class="mdi mdi-information"></i> Nama Kelas Harus Unik, Format Penamaan Angkatan-Level-Jenkel-Waktu. Contoh A01-TAJWIDI-1-AKHWAT-SENIN18 <br>
                </p>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="program_id" id="program_id" class="js-example-basic-single">
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($program as $key => $data) { ?>
                                <option value="<?= $data['program_id'] ?>"><?= $data['nama_program'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorProgram"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nama_kelas" name="nama_kelas" placeholder="Cth: A01-TAJWIDI-1-AKHWAT-SENIN18">
                        <div class="invalid-feedback errorNamakelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="angkatan_kelas" name="angkatan_kelas" value="<?= $angkatan ?>">
                        <div class="invalid-feedback errorAngkatankelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="pengajar_id" id="pengajar_id" class="js-example-basic-single">
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($pengajar as $key => $data) { ?>
                                <option value="<?= $data['pengajar_id'] ?>"><?= $data['nama_pengajar'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorPengajar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="hari_kelas" name="hari_kelas">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="SENIN">SENIN</option>
                            <option value="SELASA">SELASA</option>
                            <option value="RABU">RABU</option>
                            <option value="KAMIS">KAMIS</option>
                            <option value="JUMAT">JUMAT</option>
                            <option value="SABTU">SABTU</option>
                            <option value="MINGGU">MINGGU</option>
                        </select>
                        <div class="invalid-feedback errorHarikelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="waktu_kelas" name="waktu_kelas">
                            <option value="" disabled selected>--WAKTU--</option>
                            <option value="05:00">05:00</option>
                            <option value="06:00">06:00</option>
                            <option value="07:00">07:00</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                        </select>
                        <div class="invalid-feedback errorWaktukelas"></div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="zona_waktu_kelas" name="zona_waktu_kelas">
                            <option value="" disabled selected>--ZONA--</option>
                            <option value="WITA">WITA</option>
                            <option value="WIB">WIB</option>
                            <option value="WIT">WIT</option>
                        </select>
                        <div class="invalid-feedback errorZonawaktukelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Level Peserta <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="peserta_level" id="peserta_level" class="js-example-basic-single">
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($level as $key => $data) { ?>
                                <option value="<?= $data['peserta_level_id'] ?>"><?= $data['nama_level'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorPesertalevel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Jenis Kelamin <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="jenkel" name="jenkel">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="IKHWAN">IKHWAN</option>
                            <option value="AKHWAT">AKHWAT</option>
                        </select>
                        <div class="invalid-feedback errorJenkel"></div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kat. Pilihan Waktu<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_kerja" name="status_kerja">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="1">WEEKDAYS & WEEKEND (PEKERJA)</option>
                            <option value="0">WEEKDAYS (NON-PEKERJA)</option>
                        </select>
                        <div class="invalid-feedback errorStatuskerja"></div>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kuota <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="kouta" name="kouta" placeholder="">
                        <div class="invalid-feedback errorKouta"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Metode Tatap Muka<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="metode_kelas" name="metode_kelas">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="ONLINE">ONLINE</option>
                            <option value="OFFLINE">OFFLINE</option>
                            <option value="HYBRID">HYBRID</option>
                        </select>
                        <div class="invalid-feedback errorMetodekelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_kelas" name="status_kelas">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="aktif">AKTIF</option>
                            <option value="nonaktif">NONAKTIF</option>
                        </select>
                        <div class="invalid-feedback errorStatuskelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Link WAG Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="wag" name="wag">
                        <div class="invalid-feedback errorWag"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modaltambah')
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    program_id: $('select#program_id').val(),
                    nama_kelas: $('input#nama_kelas').val(),
                    angkatan_kelas: $('input#angkatan_kelas').val(),
                    pengajar_id: $('select#pengajar_id').val(),
                    hari_kelas: $('select#hari_kelas').val(),
                    waktu_kelas: $('select#waktu_kelas').val(),
                    zona_waktu_kelas: $('select#zona_waktu_kelas').val(),
                    peserta_level: $('select#peserta_level').val(),
                    jenkel: $('select#jenkel').val(),
                    // status_kerja: $('select#status_kerja').val(),
                    kouta: $('input#kouta').val(),
                    metode_kelas: $('select#metode_kelas').val(),
                    status_kelas: $('select#status_kelas').val(),
                    wag: $('input#wag').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="fa fa-share-square"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.program_id) {
                            $('#program_id').addClass('is-invalid');
                            $('.errorProgram').html(response.error.program_id);
                        } else {
                            $('#program_id').removeClass('is-invalid');
                            $('.errorProgram').html('');
                        }

                        if (response.error.nama_kelas) {
                            $('#nama_kelas').addClass('is-invalid');
                            $('.errorNamakelas').html(response.error.nama_kelas);
                        } else {
                            $('#nama_kelas').removeClass('is-invalid');
                            $('.errorNamakelas').html('');
                        }

                        if (response.error.angkatan_kelas) {
                            $('#angkatan_kelas').addClass('is-invalid');
                            $('.errorAngkatankelas').html(response.error.angkatan_kelas);
                        } else {
                            $('#angkatan_kelas').removeClass('is-invalid');
                            $('.errorAngkatankelas').html('');
                        }

                        if (response.error.pengajar_id) {
                            $('#pengajar_id').addClass('is-invalid');
                            $('.errorPengajar').html(response.error.pengajar_id);
                        } else {
                            $('#pengajar_id').removeClass('is-invalid');
                            $('.errorPengajar').html('');
                        }

                        if (response.error.hari_kelas) {
                            $('#hari_kelas').addClass('is-invalid');
                            $('.errorHarikelas').html(response.error.hari_kelas);
                        } else {
                            $('#hari_kelas').removeClass('is-invalid');
                            $('.errorHarikelas').html('');
                        }

                        if (response.error.waktu_kelas) {
                            $('#waktu_kelas').addClass('is-invalid');
                            $('.errorWaktukelas').html(response.error.waktu_kelas);
                        } else {
                            $('#waktu_kelas').removeClass('is-invalid');
                            $('.errorWaktukelas').html('');
                        }

                        if (response.error.zona_waktu_kelas) {
                            $('#zona_waktu_kelas').addClass('is-invalid');
                            $('.errorZonawaktukelas').html(response.error.zona_waktu_kelas);
                        } else {
                            $('#zona_waktu_kelas').removeClass('is-invalid');
                            $('.errorZonawaktukelas').html('');
                        }

                        if (response.error.peserta_level) {
                            $('#peserta_level').addClass('is-invalid');
                            $('.errorPesertalevel').html(response.error.peserta_level);
                        } else {
                            $('#peserta_level').removeClass('is-invalid');
                            $('.errorPesertalevel').html('');
                        }

                        if (response.error.jenkel) {
                            $('#jenkel').addClass('is-invalid');
                            $('.errorJenkel').html(response.error.jenkel);
                        } else {
                            $('#jenkel').removeClass('is-invalid');
                            $('.errorJenkel').html('');
                        }

                        // if (response.error.status_kerja) {
                        //     $('#status_kerja').addClass('is-invalid');
                        //     $('.errorStatuskerja').html(response.error.status_kerja);
                        // } else {
                        //     $('#status_kerja').removeClass('is-invalid');
                        //     $('.errorStatuskerja').html('');
                        // }

                        if (response.error.kouta) {
                            $('#kouta').addClass('is-invalid');
                            $('.errorKouta').html(response.error.kouta);
                        } else {
                            $('#kouta').removeClass('is-invalid');
                            $('.errorKouta').html('');
                        }

                        if (response.error.metode_kelas) {
                            $('#metode_kelas').addClass('is-invalid');
                            $('.errorMetodekelas').html(response.error.metode_kelas);
                        } else {
                            $('#metode_kelas').removeClass('is-invalid');
                            $('.errorMetodekelas').html('');
                        }

                        if (response.error.status_kelas) {
                            $('#status_kelas').addClass('is-invalid');
                            $('.errorStatuskelas').html(response.error.status_kelas);
                        } else {
                            $('#status_kelas').removeClass('is-invalid');
                            $('.errorStatuskelas').html('');
                        }

                        if (response.error.wag) {
                            $('#wag').addClass('is-invalid');
                            $('.errorWag').html(response.error.wag);
                        } else {
                            $('#wag').removeClass('is-invalid');
                            $('.errorWag').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Tambah Data Kelas Baru",
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
    });
</script>