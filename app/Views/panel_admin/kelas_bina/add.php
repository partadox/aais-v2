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
            <?= form_open('kelas-bina/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Nama Kelas Harus Unik<br>
                </p>
                <div class="form-group row">
                    <label for="bk_name" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="bk_name" name="bk_name" placeholder="Nama Kelas Non-Regular...">
                        <div class="invalid-feedback error_bk_name"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_angkatan" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" min="1" class="form-control" id="bk_angkatan" name="bk_angkatan" value="<?= $angkatan ?>">
                        <div class="invalid-feedback error_bk_angkatan"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bj_pengajar" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="bj_pengajar[]" multiple="multiple" id="bj_pengajar" class="js-example-basic-single">
                            <?php foreach ($pengajar as $key => $data) { ?>
                                <option value="<?= $data['pengajar_id'] ?>"><?= $data['nama_pengajar'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback error_bj_pengajar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_hari" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_hari" name="bk_hari">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="SENIN">SENIN</option>
                            <option value="SELASA">SELASA</option>
                            <option value="RABU">RABU</option>
                            <option value="KAMIS">KAMIS</option>
                            <option value="JUMAT">JUMAT</option>
                            <option value="SABTU">SABTU</option>
                            <option value="MINGGU">MINGGU</option>
                        </select>
                        <div class="invalid-feedback error_bk_hari"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_waktu" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="bk_waktu" name="bk_waktu">
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
                        <div class="invalid-feedback error_bk_waktu"></div>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="bk_timezone" name="bk_timezone">
                            <option value="" disabled selected>--ZONA--</option>
                            <option value="WITA">WITA</option>
                            <option value="WIB">WIB</option>
                            <option value="WIT">WIT</option>
                        </select>
                        <div class="invalid-feedback error_bk_timezone"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="bk_jenkel" class="col-sm-4 col-form-label">Jenis Kelamin <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_jenkel" name="bk_jenkel">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="IKHWAN">IKHWAN</option>
                            <option value="AKHWAT">AKHWAT</option>
                        </select>
                        <div class="invalid-feedback error_bk_jenkel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_tm_methode" class="col-sm-4 col-form-label">Metode Tatap Muka<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_tm_methode" name="bk_tm_methode">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="ONLINE">ONLINE</option>
                            <option value="OFFLINE">OFFLINE</option>
                            <option value="HYBRID">HYBRID</option>
                        </select>
                        <div class="invalid-feedback error_bk_tm_methode"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bk_tm_total" class="col-sm-4 col-form-label">Jumlah Tatap Muka (TM)<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" min="1" class="form-control" id="bk_tm_total" name="bk_tm_total" placeholder="">
                        <div class="invalid-feedback error_bk_tm_total"></div>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="bk_status" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="bk_status" name="bk_status">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="1">AKTIF</option>
                            <option value="0">NONAKTIF</option>
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
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modaltambah')
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    bk_name: $('input#bk_name').val(),
                    bk_angkatan: $('input#bk_angkatan').val(),
                    bj_pengajar: $('select#bj_pengajar').val(),
                    bk_hari: $('select#bk_hari').val(),
                    bk_waktu: $('select#bk_waktu').val(),
                    bk_timezone: $('select#bk_timezone').val(),
                    bk_jenkel: $('select#bk_jenkel').val(),
                    bk_tm_total: $('input#bk_tm_total').val(),
                    bk_tm_methode: $('select#bk_tm_methode').val(),
                    bk_status: $('select#bk_status').val(),
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

                        if (response.error.bj_pengajar) {
                            $('#bj_pengajar').addClass('is-invalid');
                            $('.error_bj_pengajar').html(response.error.bj_pengajar);
                        } else {
                            $('#bj_pengajar').removeClass('is-invalid');
                            $('.error_bj_pengajar').html('');
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