<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/sertifikat/update', ['class' => 'formtambah']) ?>
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
                        <input type="text" class="form-control" id="sertifikat_level" name="sertifikat_level" value="<?= $sertifikat_level ?>">
                        <div class="invalid-feedback error_sertifikat_level"></div>
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
                    <label for="" class="col-sm-4 col-form-label">Status Sertifikat <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_cetak" name="status_cetak">
                            <option value="Proses" <?php if ($status_cetak == 'Proses') echo "selected"; ?>>Proses</option>
                            <option value="Terkonfirmasi" <?php if ($status_cetak == 'Terkonfirmasi') echo "selected"; ?>>Terkonfirmasi</option>
                        </select>
                        <div class="invalid-feedback error_status_cetak"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nomor Sertifikat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nomor_sertifikat" name="nomor_sertifikat" value="<?= $nomor_sertifikat ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Link Sertifikat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="link_cetak" name="link_cetak" value="<?= $link_cetak ?>">
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
                <button type="submit" class="btn btn-warning btnsimpan"><i class="fa fa-save"></i> Update</button>
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

                    sertifikat_level: $('input#sertifikat_level').val(),
                    status_cetak: $('select#status_cetak').val(),
                    nomor_sertifikat: $('input#nomor_sertifikat').val(),
                    link_cetak: $('input#link_cetak').val(),
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

                        if (response.error.sertifikat_level) {
                            $('#sertifikat_level').addClass('is-invalid');
                            $('.error_sertifikat_level').html(response.error.sertifikat_level);
                        } else {
                            $('#sertifikat_level').removeClass('is-invalid');
                            $('.error_sertifikat_level').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Ubah Data Pendaftaran Sertifikat",
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