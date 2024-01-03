<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('program-regular/update-sertifikat', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="program_id" value="<?= $program['program_id'] ?>" name="program_id" readonly>
                <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Nama Program <code>*</code></label>
                    <div class="col-6">
                        <input type="text" class="form-control text-uppercase" value="<?= $program['nama_program'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Nama File <code>*</code></label>
                    <div class="col-6">
                        <input type="text" class="form-control text-uppercase" value="<?= $program['sertemp_program'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-2 col-form-label">Upload Template Baru</label>
                    <div class="col-6">
                        <input type="file" id="template" name="template" class="form-control" accept=".pdf" required>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Upload</button>
                    </div>
                </div>
                <?php if($program['sertemp_program'] != NULL) { ?>
                    <div class="form-group row">
                        <label for="" class="col-2 col-form-label">Preview Template Sekarang</label>
                        <div class="col-10">
                            <embed id="pdf-object" src="public/assets/template/<?= $program['sertemp_program'] ?>" type="application/pdf" style="width: 100%; height: calc(100vh - 120px); justify-content: center;"/>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            
        });
        $('.formedit').submit(function(e) {
            e.preventDefault();
            // Create FormData object
            var formData = new FormData(this);

            // Append additional data (hidden input with id program_id)
            formData.append('program_id', $('#program_id').val());

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
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

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text:  "Berhasil Edit Data Template Sertifikat Program",
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
    $('#biaya_program').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    $('#biaya_daftar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    // $('#biaya_bulanan').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    $('#biaya_modul').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
  });
</script>