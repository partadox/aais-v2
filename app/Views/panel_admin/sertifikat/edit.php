<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php if ($form == "show") { ?>
                <div class="modal-body">
                    <div id="pdf-container">
                        <embed id="pdf-object" src="public/sertifikat/<?= $data_sertifikat['sertifikat_file'] ?>" type="application/pdf" style="width: 100%; height: calc(100vh - 120px); justify-content: center;"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            <?php } ?>
            <?php if ($form == "edit") { ?>
                <?= form_open('/sertifikat/update', ['class' => 'formtambah']) ?>
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="sertifikat_id" name="sertifikat_id" value="<?= $sertifikat_id ?>">

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Nomor Sertifikat</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" id="nomor_sertifikat" name="nomor_sertifikat" value="<?= $data_sertifikat['nomor_sertifikat'] ?>">
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning btnsimpan"><i class="fa fa-save"></i> Update File</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <?= form_close() ?>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
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