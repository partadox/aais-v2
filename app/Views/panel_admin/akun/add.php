<!-- Modal -->
<div class="modal fade" id="modalakuntambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('akun/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Akun <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nama" name="nama">
                        <div class="invalid-feedback errorNama"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Level<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="level" name="level">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="1">SUPERADMIN</option>
                            <option value="2">ADMIN PUSAT</option>
                            <option value="3">ADMIN PUSAT TU</option>
                            <!-- <option value="7">ADMIN CABANG</option> -->
                        </select>
                        <div class="invalid-feedback errorLevel"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Username<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-lowercase" id="username" name="username">
                        <div class="invalid-feedback errorUsername"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Password<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="password" name="password">
                        <div class="invalid-feedback errorPassword"></div>
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
                    username: $('input#username').val(),
                    nama: $('input#nama').val(),
                    level: $('select#level').val(),
                    password: $('input#password').val(),
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
                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorUsername').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errorUsername').html('');
                        }

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }

                        if (response.error.level) {
                            $('#level').addClass('is-invalid');
                            $('.errorLevel').html(response.error.level);
                        } else {
                            $('#level').removeClass('is-invalid');
                            $('.errorLevel').html('');
                        }

                        if (response.error.password) {
                            $('#password').addClass('is-invalid');
                            $('.errorPassword').html(response.error.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('.errorPassword').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Tambah Akun Admin",
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