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
            <?= form_open('bank/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="bank_id" value="<?= $bank['bank_id'] ?>" name="bank_id" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Bank <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nama_bank" name="nama_bank" value="<?= $bank['nama_bank'] ?>">
                        <div class="invalid-feedback errorNama_bank"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Rekening Bank<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="rekening_bank" name="rekening_bank" value="<?= $bank['rekening_bank'] ?>">
                        <div class="invalid-feedback errorRekening_bank"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Atas Nama<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="atas_nama_bank" name="atas_nama_bank" value="<?= $bank['atas_nama_bank'] ?>">
                        <div class="invalid-feedback errorAtas_nama_bank"></div>
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
                        if (response.error.nama_bank) {
                            $('#nama_bank').addClass('is-invalid');
                            $('.errorNama_bank').html(response.error.nama_bank);
                        } else {
                            $('#nama_bank').removeClass('is-invalid');
                            $('.errorNama_kantor').html('');
                        }

                        if (response.error.rekening_bank) {
                            $('#rekening_bank').addClass('is-invalid');
                            $('.errorRekening_bank').html(response.error.rekening_bank);
                        } else {
                            $('#rekening_bank').removeClass('is-invalid');
                            $('.errorRekening_bank').html('');
                        }

                        if (response.error.atas_nama_bank) {
                            $('#atas_nama_bank').addClass('is-invalid');
                            $('.errorAtas_nama_bank').html(response.error.atas_nama_bank);
                        } else {
                            $('#atas_nama_bank').removeClass('is-invalid');
                            $('.errorAtas_nama_bank').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Rekening Bank",
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