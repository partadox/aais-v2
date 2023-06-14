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
            <?= form_open('payment-methode/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="payment_id" value="<?= $payment['payment_id'] ?>" name="payment_id" readonly>
                <input type="hidden" class="form-control" id="payment_type" value="<?= $payment['payment_type'] ?>" name="payment_type" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="payment_name" name="payment_name" value="<?= $payment['payment_name'] ?>">
                        <div class="invalid-feedback error_payment_name"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="payment_status" name="payment_status">
                            <option value="0"  <?php if ($payment['payment_status'] == '0') echo "selected"; ?> >Nonaktif</option>
                            <option value="1" <?php if ($payment['payment_status'] == '1') echo "selected"; ?> >Aktif</option>
                        </select>
                    </div>
                </div>
                <?php if ($payment['payment_type'] == 'manual'): ?>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Bank<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="payment_bank" name="payment_bank" value="<?= $payment['payment_bank'] ?>">
                </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Rekening Bank<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="payment_rekening" name="payment_rekening" value="<?= $payment['payment_rekening'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Atas Nama<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="payment_atasnama" name="payment_atasnama" value="<?= $payment['payment_atasnama'] ?>">
                    </div>
                </div>
                
                <?php endif; ?>
                <?php if ($payment['payment_type'] != 'manual' && $payment['payment_type'] != 'beasiswa'): ?>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" min=0 id="payment_price" name="payment_price" value="<?= $payment['payment_price'] ?>">
                </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Pajak (%)<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" min=0 class="form-control" id="payment_tax" name="payment_tax" value="<?= $payment['payment_tax'] ?>">
                    </div>
                </div>
                
                <?php endif; ?>
                
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
                        if (response.error.payment_name) {
                            $('#payment_name').addClass('is-invalid');
                            $('.error_payment_name').html(response.error.payment_name);
                        } else {
                            $('#payment_name').removeClass('is-invalid');
                            $('.error_payment_name').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Payment",
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