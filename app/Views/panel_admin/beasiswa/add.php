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
            <?= form_open('beasiswa/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"> Peserta<code>*</code></label>
                    <div class="col-sm-8">
                        <select name="beasiswa_peserta" id="beasiswa_peserta" class="js-example-basic-single">
                                <option value="" disabled selected>--PILIH--</option>
                            <?php foreach ($peserta as $key => $data) { ?>
                                <option value="<?= $data['peserta_id'] ?>"><?= $data['nis'] ?> - <?= $data['nama_peserta'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback error_beasiswa_peserta"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"> Program<code>*</code></label>
                    <div class="col-sm-8">
                        <select name="beasiswa_program" id="beasiswa_program" class="js-example-basic-single">
                                <option value="" disabled selected>--PILIH--</option>
                            <?php foreach ($program as $key => $data) { ?>
                                <option value="<?= $data['program_id'] ?>"><?= $data['nama_program'] ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback errorBeasiswa_program"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"> Beasiswa<code>*</code></label>
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="beasiswa_daftar" name="beasiswa_daftar" value="1" checked>
                            <label class="form-check-label" for="beasiswa_daftar">Daftar</label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="beasiswa_spp1" name="beasiswa_spp1" value="1" checked>
                            <label class="form-check-label" for="beasiswa_spp1">SPP-1</label>
                        </div>
                       
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="beasiswa_spp2" name="beasiswa_spp2" value="1" checked>
                            <label class="form-check-label" for="beasiswa_spp2">SPP-2</label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="beasiswa_spp3" name="beasiswa_spp3" value="1" checked>
                            <label class="form-check-label" for="beasiswa_spp3">SPP-3</label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="beasiswa_spp4" name="beasiswa_spp4" value="1" checked>
                            <label class="form-check-label" for="beasiswa_spp4">SPP-4</label>
                        </div>
                        
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
                    beasiswa_peserta: $('select#beasiswa_peserta').val(),
                    beasiswa_program: $('select#beasiswa_program').val(),
                    beasiswa_daftar: $('input#beasiswa_daftar').val(),
                    beasiswa_spp1: $('input#beasiswa_spp1').val(),
                    beasiswa_spp2: $('input#beasiswa_spp2').val(),
                    beasiswa_spp3: $('input#beasiswa_spp3').val(),
                    beasiswa_spp4: $('input#beasiswa_spp4').val(),
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
                        if (response.error.beasiswa_peserta) {
                            $('#beasiswa_peserta').addClass('is-invalid');
                            $('.error_beasiswa_peserta').html(response.error.beasiswa_peserta);
                        } else {
                            $('#beasiswa_peserta').removeClass('is-invalid');
                            $('.error_beasiswa_peserta').html('');
                        }

                        if (response.error.beasiswa_program) {
                            $('#beasiswa_program').addClass('is-invalid');
                            $('.errorBeasiswa_program').html(response.error.beasiswa_program);
                        } else {
                            $('#beasiswa_program').removeClass('is-invalid');
                            $('.errorBeasiswa_program').html('');
                        }


                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Tambah Data Beasiswa",
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