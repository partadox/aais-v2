<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('kelas-regular/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="kelas_id" value="<?= $kelas['kelas_id'] ?>" name="kelas_id" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="program_id" id="program_id" class="js-example-basic-single-edit">
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($program as $key => $data) { ?>
                                <option value="<?= $data['program_id'] ?>"  <?php if ($data['program_id'] == $kelas['program_id']) echo "selected"; ?> ><?= $data['nama_program'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorProgram"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" value="<?= $kelas['nama_kelas'] ?>" id="nama_kelas" name="nama_kelas">
                        <div class="invalid-feedback errorNamakelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" value="<?= $kelas['angkatan_kelas'] ?>" id="angkatan_kelas" name="angkatan_kelas">
                        <div class="invalid-feedback errorAngkatankelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="pengajar_id" id="pengajar_id" class="js-example-basic-single-edit">
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($pengajar as $key => $data) { ?>
                                <option value="<?= $data['pengajar_id'] ?>" <?php if ($data['pengajar_id'] == $kelas['pengajar_id']) echo "selected"; ?> ><?= $data['nama_pengajar'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorPengajar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="hari_kelas" name="hari_kelas">
                            <option value="SENIN"  <?php if ($kelas['hari_kelas'] == 'SENIN') echo "selected"; ?> >SENIN</option>
                            <option value="SELASA" <?php if ($kelas['hari_kelas'] == 'SELASA') echo "selected"; ?> >SELASA</option>
                            <option value="RABU"   <?php if ($kelas['hari_kelas'] == 'RABU') echo "selected"; ?> >RABU</option>
                            <option value="KAMIS"  <?php if ($kelas['hari_kelas'] == 'KAMIS') echo "selected"; ?> >KAMIS</option>>
                            <option value="JUMAT"  <?php if ($kelas['hari_kelas'] == 'JUMAT') echo "selected"; ?> >JUMAT</option>>
                            <option value="SABTU"  <?php if ($kelas['hari_kelas'] == 'SABTU') echo "selected"; ?> >SABTU</option>>
                            <option value="MINGGU" <?php if ($kelas['hari_kelas'] == 'MINGGU') echo "selected"; ?> >MINGGU</option>>
                        </select>
                        <div class="invalid-feedback errorHarikelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="waktu_kelas" name="waktu_kelas">
                            <option value="05:00" <?php if ($kelas['waktu_kelas'] == '05:00') echo "selected"; ?>>05:00</option>
                            <option value="06:00" <?php if ($kelas['waktu_kelas'] == '06:00') echo "selected"; ?>>06:00</option>
                            <option value="07:00" <?php if ($kelas['waktu_kelas'] == '07:00') echo "selected"; ?>>07:00</option>
                            <option value="08:00" <?php if ($kelas['waktu_kelas'] == '08:00') echo "selected"; ?>>08:00</option>
                            <option value="09:00" <?php if ($kelas['waktu_kelas'] == '09:00') echo "selected"; ?>>09:00</option>
                            <option value="10:00" <?php if ($kelas['waktu_kelas'] == '10:00') echo "selected"; ?>>10:00</option>
                            <option value="11:00" <?php if ($kelas['waktu_kelas'] == '11:00') echo "selected"; ?>>11:00</option>
                            <option value="12:00" <?php if ($kelas['waktu_kelas'] == '12:00') echo "selected"; ?>>12:00</option>
                            <option value="13:00" <?php if ($kelas['waktu_kelas'] == '13:00') echo "selected"; ?>>13:00</option>
                            <option value="14:00" <?php if ($kelas['waktu_kelas'] == '14:00') echo "selected"; ?>>14:00</option>
                            <option value="15:00" <?php if ($kelas['waktu_kelas'] == '15:00') echo "selected"; ?>>15:00</option>
                            <option value="16:00" <?php if ($kelas['waktu_kelas'] == '16:00') echo "selected"; ?>>16:00</option>
                            <option value="17:00" <?php if ($kelas['waktu_kelas'] == '17:00') echo "selected"; ?>>17:00</option>
                            <option value="18:00" <?php if ($kelas['waktu_kelas'] == '18:00') echo "selected"; ?>>18:00</option>
                            <option value="19:00" <?php if ($kelas['waktu_kelas'] == '19:00') echo "selected"; ?>>19:00</option>
                            <option value="20:00" <?php if ($kelas['waktu_kelas'] == '20:00') echo "selected"; ?>>20:00</option>
                            <option value="21:00" <?php if ($kelas['waktu_kelas'] == '21:00') echo "selected"; ?>>21:00</option>
                        </select>
                        <div class="invalid-feedback errorWaktukelas"></div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="zona_waktu_kelas" name="zona_waktu_kelas">
                            <option value="WITA" <?php if ($kelas['zona_waktu_kelas'] == 'WITA') echo "selected"; ?>>WITA</option>
                            <option value="WIB" <?php if ($kelas['zona_waktu_kelas'] == 'WIB') echo "selected"; ?>>WIB</option>
                            <option value="WIT" <?php if ($kelas['zona_waktu_kelas'] == 'WIT') echo "selected"; ?>>WIT</option>
                        </select>
                        <div class="invalid-feedback errorZonawaktukelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Level Peserta <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="peserta_level" id="peserta_level" class="js-example-basic-single-edit">
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($level as $key => $data) { ?>
                                <option value="<?= $data['peserta_level_id'] ?>"  <?php if ($data['peserta_level_id'] == $kelas['peserta_level']) echo "selected"; ?>><?= $data['nama_level'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorPesertalevel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Jenis Kelamin <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="jenkel" name="jenkel">
                            <option value="IKHWAN" <?php if ($kelas['jenkel'] == 'IKHWAN') echo "selected"; ?>>IKHWAN</option>
                            <option value="AKHWAT" <?php if ($kelas['jenkel'] == 'AKHWAT') echo "selected"; ?>>AKHWAT</option>
                        </select>
                        <div class="invalid-feedback errorJenkel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kuota <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control"  value="<?= $kelas['kouta'] ?>" id="kouta" name="kouta" placeholder="">
                        <div class="invalid-feedback errorKouta"></div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Sisa Kuota <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control"  value="" id="sisa_kouta" name="sisa_kouta" placeholder="">
                        <div class="invalid-feedback errorSisakouta"></div>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Metode Tatap Muka<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="metode_kelas" name="metode_kelas">
                            <option value="ONLINE" <?php if ($kelas['metode_kelas'] == 'ONLINE') echo "selected"; ?>>ONLINE</option>
                            <option value="OFFLINE" <?php if ($kelas['metode_kelas'] == 'OFFLINE') echo "selected"; ?>>OFFLINE</option>
                        </select>
                        <div class="invalid-feedback errorMetodekelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_kelas" name="status_kelas">
                            <option value="aktif" <?php if ($kelas['status_kelas'] == 'aktif') echo "selected"; ?>>Aktif</option>
                            <option value="nonaktif" <?php if ($kelas['status_kelas'] == 'nonaktif') echo "selected"; ?>>Nonaktif</option>
                        </select>
                        <div class="invalid-feedback errorStatuskelas"></div>
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
        $('.js-example-basic-single-edit').select2({
            
        });
        $('.formedit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
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

                        if (response.error.kouta) {
                            $('#kouta').addClass('is-invalid');
                            $('.errorKouta').html(response.error.kouta);
                        } else {
                            $('#kouta').removeClass('is-invalid');
                            $('.errorKouta').html('');
                        }

                        // if (response.error.sisa_kouta) {
                        //     $('#sisa_kouta').addClass('is-invalid');
                        //     $('.errorSisakouta').html(response.error.sisa_kouta);
                        // } else {
                        //     $('#sisa_kouta').removeClass('is-invalid');
                        //     $('.errorSisakouta').html('');
                        // }

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

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Kelas",
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