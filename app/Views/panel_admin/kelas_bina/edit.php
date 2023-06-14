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
            <?= form_open('kelas-bina/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="bk_id" value="<?= $bina['bk_id'] ?>" name="bk_id" readonly>
                <div class="form-group row">
                    <label for="bk_name" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" value="<?= $bina['bk_name'] ?>" id="bk_name" name="bk_name">
                        <div class="invalid-feedback error_bk_name"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_angkatan" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" value="<?= $bina['bk_angkatan'] ?>" id="bk_angkatan" name="bk_angkatan">
                        <div class="invalid-feedback error_bk_angkatan"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="bk_hari" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_hari" name="bk_hari">
                            <option value="SENIN"  <?php if ($bina['bk_hari'] == 'SENIN') echo "selected"; ?> >SENIN</option>
                            <option value="SELASA" <?php if ($bina['bk_hari'] == 'SELASA') echo "selected"; ?> >SELASA</option>
                            <option value="RABU"   <?php if ($bina['bk_hari'] == 'RABU') echo "selected"; ?> >RABU</option>
                            <option value="KAMIS"  <?php if ($bina['bk_hari'] == 'KAMIS') echo "selected"; ?> >KAMIS</option>>
                            <option value="JUMAT"  <?php if ($bina['bk_hari'] == 'JUMAT') echo "selected"; ?> >JUMAT</option>>
                            <option value="SABTU"  <?php if ($bina['bk_hari'] == 'SABTU') echo "selected"; ?> >SABTU</option>>
                            <option value="MINGGU" <?php if ($bina['bk_hari'] == 'MINGGU') echo "selected"; ?> >MINGGU</option>>
                        </select>
                        <div class="invalid-feedback error_bk_hari"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_waktu" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="bk_waktu" name="bk_waktu">
                            <option value="05:00" <?php if ($bina['bk_waktu'] == '05:00') echo "selected"; ?>>05:00</option>
                            <option value="06:00" <?php if ($bina['bk_waktu'] == '06:00') echo "selected"; ?>>06:00</option>
                            <option value="07:00" <?php if ($bina['bk_waktu'] == '07:00') echo "selected"; ?>>07:00</option>
                            <option value="08:00" <?php if ($bina['bk_waktu'] == '08:00') echo "selected"; ?>>08:00</option>
                            <option value="09:00" <?php if ($bina['bk_waktu'] == '09:00') echo "selected"; ?>>09:00</option>
                            <option value="10:00" <?php if ($bina['bk_waktu'] == '10:00') echo "selected"; ?>>10:00</option>
                            <option value="11:00" <?php if ($bina['bk_waktu'] == '11:00') echo "selected"; ?>>11:00</option>
                            <option value="12:00" <?php if ($bina['bk_waktu'] == '12:00') echo "selected"; ?>>12:00</option>
                            <option value="13:00" <?php if ($bina['bk_waktu'] == '13:00') echo "selected"; ?>>13:00</option>
                            <option value="14:00" <?php if ($bina['bk_waktu'] == '14:00') echo "selected"; ?>>14:00</option>
                            <option value="15:00" <?php if ($bina['bk_waktu'] == '15:00') echo "selected"; ?>>15:00</option>
                            <option value="16:00" <?php if ($bina['bk_waktu'] == '16:00') echo "selected"; ?>>16:00</option>
                            <option value="17:00" <?php if ($bina['bk_waktu'] == '17:00') echo "selected"; ?>>17:00</option>
                            <option value="18:00" <?php if ($bina['bk_waktu'] == '18:00') echo "selected"; ?>>18:00</option>
                            <option value="19:00" <?php if ($bina['bk_waktu'] == '19:00') echo "selected"; ?>>19:00</option>
                            <option value="20:00" <?php if ($bina['bk_waktu'] == '20:00') echo "selected"; ?>>20:00</option>
                            <option value="21:00" <?php if ($bina['bk_waktu'] == '21:00') echo "selected"; ?>>21:00</option>
                        </select>
                        <div class="invalid-feedback error_bk_waktu"></div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="bk_timezone" name="bk_timezone">
                            <option value="WITA" <?php if ($bina['bk_timezone'] == 'WITA') echo "selected"; ?>>WITA</option>
                            <option value="WIB" <?php if ($bina['bk_timezone'] == 'WIB') echo "selected"; ?>>WIB</option>
                            <option value="WIT" <?php if ($bina['bk_timezone'] == 'WIT') echo "selected"; ?>>WIT</option>
                        </select>
                        <div class="invalid-feedback error_bk_timezone"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="bk_jenkel" class="col-sm-4 col-form-label">Jenis Kelamin <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_jenkel" name="bk_jenkel">
                            <option value="IKHWAN" <?php if ($bina['bk_jenkel'] == 'IKHWAN') echo "selected"; ?>>IKHWAN</option>
                            <option value="AKHWAT" <?php if ($bina['bk_jenkel'] == 'AKHWAT') echo "selected"; ?>>AKHWAT</option>
                        </select>
                        <div class="invalid-feedback error_bk_jenkel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_tm_total" class="col-sm-4 col-form-label">Total Tatap Muka (TM) <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control"  value="<?= $bina['bk_tm_total'] ?>" id="bk_tm_total" name="bk_tm_total" placeholder="">
                        <div class="invalid-feedback error_bk_tm_total"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="bk_tm_methode" class="col-sm-4 col-form-label">Metode Tatap Muka<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_tm_methode" name="bk_tm_methode">
                            <option value="ONLINE" <?php if ($bina['bk_tm_methode'] == 'ONLINE') echo "selected"; ?>>ONLINE</option>
                            <option value="OFFLINE" <?php if ($bina['bk_tm_methode'] == 'OFFLINE') echo "selected"; ?>>OFFLINE</option>
                        </select>
                        <div class="invalid-feedback error_bk_tm_methode"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_status" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_status" name="bk_status">
                            <option value="1" <?php if ($bina['bk_status'] == '1') echo "selected"; ?>>Aktif</option>
                            <option value="0" <?php if ($bina['bk_status'] == '0') echo "selected"; ?>>Nonaktif</option>
                        </select>
                        <div class="invalid-feedback error_bk_status"></div>
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

                        if (response.error.bk_name) {
                            $('#bk_name').addClass('is-invalid');
                            $('.error_bk_name').html(response.error.bk_name);
                        } else {
                            $('#bk_name').removeClass('is-invalid');
                            $('.error_bk_name').html('');
                        }

                        if (response.error.bk_angkatan) {
                            $('#bk_angkatan').addClass('is-invalid');
                            $('.error_bk_angkatan').html(response.error.bk_angkatan);
                        } else {
                            $('#bk_angkatan').removeClass('is-invalid');
                            $('.error_bk_angkatan').html('');
                        }

                        if (response.error.bk_hari) {
                            $('#bk_hari').addClass('is-invalid');
                            $('.error_bk_hari').html(response.error.bk_hari);
                        } else {
                            $('#bk_hari').removeClass('is-invalid');
                            $('.error_bk_hari').html('');
                        }

                        if (response.error.bk_waktu) {
                            $('#bk_waktu').addClass('is-invalid');
                            $('.error_bk_waktu').html(response.error.bk_waktu);
                        } else {
                            $('#bk_waktu').removeClass('is-invalid');
                            $('.error_bk_waktu').html('');
                        }

                        if (response.error.bk_timezone) {
                            $('#bk_timezone').addClass('is-invalid');
                            $('.error_bk_timezone').html(response.error.bk_timezone);
                        } else {
                            $('#bk_timezone').removeClass('is-invalid');
                            $('.error_bk_timezone').html('');
                        }

                        if (response.error.bk_jenkel) {
                            $('#bk_jenkel').addClass('is-invalid');
                            $('.error_bk_jenkel').html(response.error.bk_jenkel);
                        } else {
                            $('#bk_jenkel').removeClass('is-invalid');
                            $('.error_bk_jenkel').html('');
                        }

                        if (response.error.bk_tm_total) {
                            $('#bk_tm_total').addClass('is-invalid');
                            $('.error_bk_tm_total').html(response.error.bk_tm_total);
                        } else {
                            $('#bk_tm_total').removeClass('is-invalid');
                            $('.error_bk_tm_total').html('');
                        }

                        if (response.error.bk_tm_methode) {
                            $('#bk_tm_methode').addClass('is-invalid');
                            $('.error_bk_tm_methode').html(response.error.bk_tm_methode);
                        } else {
                            $('#bk_tm_methode').removeClass('is-invalid');
                            $('.error_bk_tm_methode').html('');
                        }

                        if (response.error.bk_status) {
                            $('#bk_status').addClass('is-invalid');
                            $('.error_bk_status').html(response.error.bk_status);
                        } else {
                            $('#bk_status').removeClass('is-invalid');
                            $('.error_bk_status').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Kelas Non-Regular",
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