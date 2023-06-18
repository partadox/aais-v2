<!-- Modal -->
<div class="modal fade" id="modalkonfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/sertifikat/save-konfirmasi', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">

                <input type="hidden" class="form-control" id="sertifikat_id" name="sertifikat_id" value="<?= $sertifikat_id ?>">

                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">NIS / Nama<code>*</code></label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control text-uppercase" value="<?= $nis ?>" readonly>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control text-uppercase" value="<?= $nama_peserta ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Level<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $sertifikat_level ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nominal Bayar<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nominal_bayar_cetak" name="nominal_bayar_cetak" value="<?= $nominal_bayar_cetak ?>">
                        <div class="invalid-feedback error_nominal_bayar_cetak"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Keterangan Lain</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="keterangan_cetak" name="keterangan_cetak" value="<?= $keterangan_cetak ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan"><i class="fa fa-check"></i> Konfirmasi</button>
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
                    nominal_bayar_cetak: $('input#nominal_bayar_cetak').val(),
                    keterangan_cetak: $('input#keterangan_cetak').val(),
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
                        if (response.error.nominal_bayar_cetak) {
                            $('#nominal_bayar_cetak').addClass('is-invalid');
                            $('.error_nominal_bayar_cetak').html(response.error.nominal_bayar_cetak);
                        } else {
                            $('#nominal_bayar_cetak').removeClass('is-invalid');
                            $('.error_nominal_bayar_cetak').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Konfirmasi Pendaftaran Sertifikat",
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

    $(document).ready(function () {
    $('#nominal_bayar_cetak').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
  });
</script>