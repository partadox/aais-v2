<!-- Modal -->
<div class="modal fade" id="modalmanual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('bayar/save-manual', ['class' => 'formbayar']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Total <code>*</code></label>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Bayar</button>
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
        $('.formbayar').submit(function(e) {
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

                        if (response.error.username) {
                            $('#username').addClass('is-invalid');
                            $('.errorUsername').html(response.error.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.errorUsername').html('');
                        }

                        if (response.error.active) {
                            $('#active').addClass('is-invalid');
                            $('.errorActive').html(response.error.active);
                        } else {
                            $('#active').removeClass('is-invalid');
                            $('.errorActive').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Akun Admin",
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