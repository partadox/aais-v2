<!-- Modal -->
<div class="modal fade" id="modaleditpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('biodata-pengajar/update-password', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <style>
                .password-wrapper {
                position: relative;
                }

                #toggle-password {
                position: absolute;
                right: 10px;
                top: 10px;
                border: none;
                background: none;
                cursor: pointer;
                }

            </style>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="user_id" value="<?= $user_id ?>" name="user_id" readonly>
                <input type="hidden" class="form-control" id="level" value="<?= $level ?>" name="level" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Password<code>*</code></label>
                    <div class="col-sm-8">
                        <div class="password-wrapper">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password baru">
                        <!-- Add a button that will trigger the show/hide password functionality -->
                        <button type="button" id="toggle-password" aria-label="Toggle password visibility">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                        <div class="invalid-feedback errorPassword"></div>
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
    var password = document.getElementById('password');
    var togglePassword = document.getElementById('toggle-password');

    togglePassword.addEventListener('click', function() {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye icon
        this.classList.toggle('fa fa-eye-slash');
    });
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
                            text: "Berhasil Ubah Password",
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