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
            <?= form_open('level/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="peserta_level_id" value="<?= $peserta_level['peserta_level_id'] ?>" name="peserta_level_id" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Level <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nama_level" name="nama_level" value="<?= $peserta_level['nama_level'] ?>">
                        <div class="invalid-feedback errorNama_level"></div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Urutan Level<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="urutan_level" name="urutan_level" value="<?= $peserta_level['urutan_level'] ?>">
                        <div class="invalid-feedback errorUrutan_level"></div>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Tampil Di Daftar Peserta Baru <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="tampil_ondaftar" name="tampil_ondaftar">
                            <option value="0"  <?php if ($peserta_level['tampil_ondaftar'] == '0') echo "selected"; ?> >Tidak Tampil</option>
                            <option value="1" <?php if ($peserta_level['tampil_ondaftar'] == '1') echo "selected"; ?> >Tampil</option>
                        </select>
                        <div class="invalid-feedback errorTampil_ondaftar"></div>
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
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modaledit')
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
                        if (response.error.nama_level) {
                            $('#nama_level').addClass('is-invalid');
                            $('.errorNama_level').html(response.error.nama_level);
                        } else {
                            $('#nama_level').removeClass('is-invalid');
                            $('.errorNama_level').html('');
                        }

                        // if (response.error.urutan_level) {
                        //     $('#urutan_level').addClass('is-invalid');
                        //     $('.errorUrutan_level').html(response.error.urutan_level);
                        // } else {
                        //     $('#urutan_level').removeClass('is-invalid');
                        //     $('.errorUrutan_level').html('');
                        // }

                        if (response.error.tampil_ondaftar) {
                            $('#tampil_ondaftar').addClass('is-invalid');
                            $('.errorTampil_ondaftar').html(response.error.tampil_ondaftar);
                        } else {
                            $('#tampil_ondaftar').removeClass('is-invalid');
                            $('.errorTampil_ondaftar').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text:  "Berhasil Edit Data Level",
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