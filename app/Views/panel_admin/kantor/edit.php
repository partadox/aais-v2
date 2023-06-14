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
            <?= form_open('kantor/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="kantor_id" value="<?= $kantor['kantor_id'] ?>" name="kantor_id" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Kantor <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nama_kantor" name="nama_kantor" value="<?= $kantor['nama_kantor'] ?>">
                        <div class="invalid-feedback errorNama_kantor"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kota Kantor<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="kota_kantor" name="kota_kantor" value="<?= $kantor['kota_kantor'] ?>">
                        <div class="invalid-feedback errorKota_kantor"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Alamat Kantor<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="alamat_kantor" name="alamat_kantor" value="<?= $kantor['alamat_kantor'] ?>">
                        <div class="invalid-feedback errorAlamat_kantor"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kontak Kantor<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="kontak_kantor" name="kontak_kantor" value="<?= $kantor['kontak_kantor'] ?>">
                        <div class="invalid-feedback errorKontak_kantor"></div>
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
                        if (response.error.nama_kantor) {
                            $('#nama_kantor').addClass('is-invalid');
                            $('.errorNama_kantor').html(response.error.nama_kantor);
                        } else {
                            $('#nama_kantor').removeClass('is-invalid');
                            $('.errorNama_kantor').html('');
                        }

                        if (response.error.kota_kantor) {
                            $('#kota_kantor').addClass('is-invalid');
                            $('.errorKota_kantor').html(response.error.kota_kantor);
                        } else {
                            $('#kota_kantor').removeClass('is-invalid');
                            $('.errorKota_kantor').html('');
                        }

                        if (response.error.alamat_kantor) {
                            $('#alamat_kantor').addClass('is-invalid');
                            $('.errorAlamat_kantor').html(response.error.alamat_kantor);
                        } else {
                            $('#alamat_kantor').removeClass('is-invalid');
                            $('.errorAlamat_kantor').html('');
                        }

                        if (response.error.kontak_kantor) {
                            $('#kontak_kantor').addClass('is-invalid');
                            $('.errorKontak_kantor').html(response.error.kontak_kantor);
                        } else {
                            $('#kontak_kantor').removeClass('is-invalid');
                            $('.errorKontak_kantor').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Kantor / Cabang",
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