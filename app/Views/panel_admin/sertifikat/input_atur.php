<!-- Modal -->
<div class="modal fade" id="modalatur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/sertifikat/save-atur', ['class' => 'formatur']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <!-- <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Admin harus mengaktifkan <b>Status Pendaftaran Cetak Sertifikat</b> agar peserta dapat mengakses menu cetak sertifikat. <br>
                    <i class="mdi mdi-information"></i> Isikan periode cetak sertifikat juga. <br>
                </p> -->
                <div class="form-group row" style="display: none;">
                    <label for="" class="col-sm-4 col-form-label">Periode Sertifikat <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control"  value="<?= $konfig[0]['periode_sertifikat'] ?>" id="periode_sertifikat" name="periode_sertifikat">
                        <div class="invalid-feedback errorPeriode_sertifikat"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Menu Sertifikat<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_menu_sertifikat" name="status_menu_sertifikat">
                            <option value="TUTUP" <?php if ($konfig[0]['status_menu_sertifikat'] == 'TUTUP') echo "selected"; ?>>DITUTUP</option>
                            <option value="BUKA" <?php if ($konfig[0]['status_menu_sertifikat'] == 'BUKA') echo "selected"; ?>>DIBUKA</option>
                        </select>
                        <div class="invalid-feedback errorStatus_menu_sertifikat"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Sertifikat <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"  value="Rp. <?= rupiah($konfig[0]['biaya_sertifikat']) ?>" id="biaya_sertifikat" name="biaya_sertifikat">
                        <div class="invalid-feedback errorBiaya_sertifikat"></div>
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
        $('.formatur').submit(function(e) {
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
                        if (response.error.periode_sertifikat) {
                            $('#periode_sertifikat').addClass('is-invalid');
                            $('.errorPeriode_sertifikat').html(response.error.periode_sertifikat);
                        } else {
                            $('#periode_sertifikat').removeClass('is-invalid');
                            $('.errorPeriode_sertifikat').html('');
                        }

                        if (response.error.status_menu_sertifikat) {
                            $('#status_menu_sertifikat').addClass('is-invalid');
                            $('.errorStatus_menu_sertifikat').html(response.error.status_menu_sertifikat);
                        } else {
                            $('#status_menu_sertifikat').removeClass('is-invalid');
                            $('.errorStatus_menu_sertifikat').html('');
                        }

                        if (response.error.biaya_sertifikat) {
                            $('#biaya_sertifikat').addClass('is-invalid');
                            $('.errorBiaya_sertifikat').html(response.error.biaya_sertifikat);
                        } else {
                            $('#biaya_sertifikat').removeClass('is-invalid');
                            $('.errorBiaya_sertifikat').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Ubah Pengaturan Cetak Sertifikat",
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
    $('#biaya_sertifikat').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
  });
</script>