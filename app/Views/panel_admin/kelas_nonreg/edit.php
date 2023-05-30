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
            <?= form_open('kelas-nonreg/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="nk_id" value="<?= $nonreg['nk_id'] ?>" name="nk_id" readonly>
                <div class="form-group row">
                    <label for="nk_name" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" value="<?= $nonreg['nk_name'] ?>" id="nk_name" name="nk_name">
                        <div class="invalid-feedback error_nk_name"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_angkatan" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" value="<?= $nonreg['nk_angkatan'] ?>" id="nk_angkatan" name="nk_angkatan">
                        <div class="invalid-feedback error_nk_angkatan"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="nk_hari" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_hari" name="nk_hari">
                            <option value="SENIN"  <?php if ($nonreg['nk_hari'] == 'SENIN') echo "selected"; ?> >SENIN</option>
                            <option value="SELASA" <?php if ($nonreg['nk_hari'] == 'SELASA') echo "selected"; ?> >SELASA</option>
                            <option value="RABU"   <?php if ($nonreg['nk_hari'] == 'RABU') echo "selected"; ?> >RABU</option>
                            <option value="KAMIS"  <?php if ($nonreg['nk_hari'] == 'KAMIS') echo "selected"; ?> >KAMIS</option>>
                            <option value="JUMAT"  <?php if ($nonreg['nk_hari'] == 'JUMAT') echo "selected"; ?> >JUMAT</option>>
                            <option value="SABTU"  <?php if ($nonreg['nk_hari'] == 'SABTU') echo "selected"; ?> >SABTU</option>>
                            <option value="MINGGU" <?php if ($nonreg['nk_hari'] == 'MINGGU') echo "selected"; ?> >MINGGU</option>>
                        </select>
                        <div class="invalid-feedback error_nk_hari"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_waktu" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_waktu" name="nk_waktu">
                            <option value="05:00" <?php if ($nonreg['nk_waktu'] == '05:00') echo "selected"; ?>>05:00</option>
                            <option value="06:00" <?php if ($nonreg['nk_waktu'] == '06:00') echo "selected"; ?>>06:00</option>
                            <option value="07:00" <?php if ($nonreg['nk_waktu'] == '07:00') echo "selected"; ?>>07:00</option>
                            <option value="08:00" <?php if ($nonreg['nk_waktu'] == '08:00') echo "selected"; ?>>08:00</option>
                            <option value="09:00" <?php if ($nonreg['nk_waktu'] == '09:00') echo "selected"; ?>>09:00</option>
                            <option value="10:00" <?php if ($nonreg['nk_waktu'] == '10:00') echo "selected"; ?>>10:00</option>
                            <option value="11:00" <?php if ($nonreg['nk_waktu'] == '11:00') echo "selected"; ?>>11:00</option>
                            <option value="12:00" <?php if ($nonreg['nk_waktu'] == '12:00') echo "selected"; ?>>12:00</option>
                            <option value="13:00" <?php if ($nonreg['nk_waktu'] == '13:00') echo "selected"; ?>>13:00</option>
                            <option value="14:00" <?php if ($nonreg['nk_waktu'] == '14:00') echo "selected"; ?>>14:00</option>
                            <option value="15:00" <?php if ($nonreg['nk_waktu'] == '15:00') echo "selected"; ?>>15:00</option>
                            <option value="16:00" <?php if ($nonreg['nk_waktu'] == '16:00') echo "selected"; ?>>16:00</option>
                            <option value="17:00" <?php if ($nonreg['nk_waktu'] == '17:00') echo "selected"; ?>>17:00</option>
                            <option value="18:00" <?php if ($nonreg['nk_waktu'] == '18:00') echo "selected"; ?>>18:00</option>
                            <option value="19:00" <?php if ($nonreg['nk_waktu'] == '19:00') echo "selected"; ?>>19:00</option>
                            <option value="20:00" <?php if ($nonreg['nk_waktu'] == '20:00') echo "selected"; ?>>20:00</option>
                            <option value="21:00" <?php if ($nonreg['nk_waktu'] == '21:00') echo "selected"; ?>>21:00</option>
                        </select>
                        <div class="invalid-feedback error_nk_waktu"></div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_timezone" name="nk_timezone">
                            <option value="WITA" <?php if ($nonreg['nk_timezone'] == 'WITA') echo "selected"; ?>>WITA</option>
                            <option value="WIB" <?php if ($nonreg['nk_timezone'] == 'WIB') echo "selected"; ?>>WIB</option>
                            <option value="WIT" <?php if ($nonreg['nk_timezone'] == 'WIT') echo "selected"; ?>>WIT</option>
                        </select>
                        <div class="invalid-feedback error_nk_timezone"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="nk_jenkel" class="col-sm-4 col-form-label">Jenis Kelamin <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_jenkel" name="nk_jenkel">
                            <option value="IKHWAN" <?php if ($nonreg['nk_jenkel'] == 'IKHWAN') echo "selected"; ?>>IKHWAN</option>
                            <option value="AKHWAT" <?php if ($nonreg['nk_jenkel'] == 'AKHWAT') echo "selected"; ?>>AKHWAT</option>
                        </select>
                        <div class="invalid-feedback error_nk_jenkel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_tm_total" class="col-sm-4 col-form-label">Total Tatap Muka (TM) <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control"  value="<?= $nonreg['nk_tm_total'] ?>" id="nk_tm_total" name="nk_tm_total" placeholder="">
                        <div class="invalid-feedback error_nk_tm_total"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="nk_tm_methode" class="col-sm-4 col-form-label">Metode Tatap Muka<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_tm_methode" name="nk_tm_methode">
                            <option value="ONLINE" <?php if ($nonreg['nk_tm_methode'] == 'ONLINE') echo "selected"; ?>>ONLINE</option>
                            <option value="OFFLINE" <?php if ($nonreg['nk_tm_methode'] == 'OFFLINE') echo "selected"; ?>>OFFLINE</option>
                        </select>
                        <div class="invalid-feedback error_nk_tm_methode"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_status" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_status" name="nk_status">
                            <option value="1" <?php if ($nonreg['nk_status'] == '1') echo "selected"; ?>>Aktif</option>
                            <option value="0" <?php if ($nonreg['nk_status'] == '0') echo "selected"; ?>>Nonaktif</option>
                        </select>
                        <div class="invalid-feedback error_nk_status"></div>
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
            theme: "bootstrap4"
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

                        if (response.error.nk_name) {
                            $('#nk_name').addClass('is-invalid');
                            $('.error_nk_name').html(response.error.nk_name);
                        } else {
                            $('#nk_name').removeClass('is-invalid');
                            $('.error_nk_name').html('');
                        }

                        if (response.error.nk_angkatan) {
                            $('#nk_angkatan').addClass('is-invalid');
                            $('.error_nk_angkatan').html(response.error.nk_angkatan);
                        } else {
                            $('#nk_angkatan').removeClass('is-invalid');
                            $('.error_nk_angkatan').html('');
                        }

                        if (response.error.nk_hari) {
                            $('#nk_hari').addClass('is-invalid');
                            $('.error_nk_hari').html(response.error.nk_hari);
                        } else {
                            $('#nk_hari').removeClass('is-invalid');
                            $('.error_nk_hari').html('');
                        }

                        if (response.error.nk_waktu) {
                            $('#nk_waktu').addClass('is-invalid');
                            $('.error_nk_waktu').html(response.error.nk_waktu);
                        } else {
                            $('#nk_waktu').removeClass('is-invalid');
                            $('.error_nk_waktu').html('');
                        }

                        if (response.error.nk_timezone) {
                            $('#nk_timezone').addClass('is-invalid');
                            $('.error_nk_timezone').html(response.error.nk_timezone);
                        } else {
                            $('#nk_timezone').removeClass('is-invalid');
                            $('.error_nk_timezone').html('');
                        }

                        if (response.error.nk_jenkel) {
                            $('#nk_jenkel').addClass('is-invalid');
                            $('.error_nk_jenkel').html(response.error.nk_jenkel);
                        } else {
                            $('#nk_jenkel').removeClass('is-invalid');
                            $('.error_nk_jenkel').html('');
                        }

                        if (response.error.nk_tm_total) {
                            $('#nk_tm_total').addClass('is-invalid');
                            $('.error_nk_tm_total').html(response.error.nk_tm_total);
                        } else {
                            $('#nk_tm_total').removeClass('is-invalid');
                            $('.error_nk_tm_total').html('');
                        }

                        if (response.error.nk_tm_methode) {
                            $('#nk_tm_methode').addClass('is-invalid');
                            $('.error_nk_tm_methode').html(response.error.nk_tm_methode);
                        } else {
                            $('#nk_tm_methode').removeClass('is-invalid');
                            $('.error_nk_tm_methode').html('');
                        }

                        if (response.error.nk_status) {
                            $('#nk_status').addClass('is-invalid');
                            $('.error_nk_status').html(response.error.nk_status);
                        } else {
                            $('#nk_status').removeClass('is-invalid');
                            $('.error_nk_status').html('');
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