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
            <?= form_open('kelas-nonreg/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Nama Kelas Harus Unik<br>
                </p>
                <div class="form-group row">
                    <label for="nk_name" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_name" name="nk_name" placeholder="Nama Kelas Non-Regular...">
                        <div class="invalid-feedback error_nk_name"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_angkatan" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" min="1" class="form-control" id="nk_angkatan" name="nk_angkatan" value="<?= $angkatan ?>">
                        <div class="invalid-feedback error_nk_angkatan"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nj_pengajar" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="nj_pengajar[]" multiple="multiple" id="nj_pengajar" class="js-example-basic-single">
                            <?php foreach ($pengajar as $key => $data) { ?>
                                <option value="<?= $data['pengajar_id'] ?>"><?= $data['nama_pengajar'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback error_nj_pengajar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_hari" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_hari" name="nk_hari">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="SENIN">SENIN</option>
                            <option value="SELASA">SELASA</option>
                            <option value="RABU">RABU</option>
                            <option value="KAMIS">KAMIS</option>
                            <option value="JUMAT">JUMAT</option>
                            <option value="SABTU">SABTU</option>
                            <option value="MINGGU">MINGGU</option>
                        </select>
                        <div class="invalid-feedback error_nk_hari"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_waktu" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_waktu" name="nk_waktu">
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
                        <div class="invalid-feedback error_nk_waktu"></div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_timezone" name="nk_timezone">
                            <option value="" disabled selected>--ZONA--</option>
                            <option value="WITA">WITA</option>
                            <option value="WIB">WIB</option>
                            <option value="WIT">WIT</option>
                        </select>
                        <div class="invalid-feedback error_nk_timezone"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="nk_jenkel" class="col-sm-4 col-form-label">Jenis Kelamin <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_jenkel" name="nk_jenkel">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="IKHWAN">IKHWAN</option>
                            <option value="AKHWAT">AKHWAT</option>
                        </select>
                        <div class="invalid-feedback error_nk_jenkel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_tm_methode" class="col-sm-4 col-form-label">Metode Tatap Muka<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_tm_methode" name="nk_tm_methode">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="ONLINE">ONLINE</option>
                            <option value="OFFLINE">OFFLINE</option>
                            <option value="HYBRID">HYBRID</option>
                        </select>
                        <div class="invalid-feedback error_nk_tm_methode"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nk_tm_total" class="col-sm-4 col-form-label">Jumlah Tatap Muka (TM)<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" min="1" class="form-control" id="nk_tm_total" name="nk_tm_total" placeholder="">
                        <div class="invalid-feedback error_nk_tm_total"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="nk_status" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_status" name="nk_status">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="1">AKTIF</option>
                            <option value="0">NONAKTIF</option>
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
        $('.js-example-basic-single').select2({
            theme: "bootstrap4"
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    nk_name: $('input#nk_name').val(),
                    nk_angkatan: $('input#nk_angkatan').val(),
                    nj_pengajar: $('select#nj_pengajar').val(),
                    nk_hari: $('select#nk_hari').val(),
                    nk_waktu: $('select#nk_waktu').val(),
                    nk_timezone: $('select#nk_timezone').val(),
                    nk_jenkel: $('select#nk_jenkel').val(),
                    nk_tm_total: $('input#nk_tm_total').val(),
                    nk_tm_methode: $('select#nk_tm_methode').val(),
                    nk_status: $('select#nk_status').val(),
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

                        if (response.error.nj_pengajar) {
                            $('#nj_pengajar').addClass('is-invalid');
                            $('.error_nj_pengajar').html(response.error.nj_pengajar);
                        } else {
                            $('#nj_pengajar').removeClass('is-invalid');
                            $('.error_nj_pengajar').html('');
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
                            text: "Berhasil Tambah Data Kelas Non-Regular Baru",
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