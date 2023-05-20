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
            <?= form_open('kelas-regular/save-setting', ['class' => 'formatur']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
            <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Admin harus mengaktifkan <b>Status Pendaftaran</b> agar peserta dapat memilih program/kelas. <br>
                    <i class="mdi mdi-information"></i> Isikan angkatan perkuliahan saat ini. <br>
                </p>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control"  value="<?= $konfig[0]['angkatan_kuliah'] ?>" id="angkatan_kuliah" name="angkatan_kuliah">
                        <div class="invalid-feedback errorAngkatan_kuliah"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Pendaftaran<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_pendaftaran" name="status_pendaftaran">
                            <option value="TUTUP" <?php if ($konfig[0]['status_pendaftaran'] == 'TUTUP') echo "selected"; ?>>DITUTUP</option>
                            <option value="BUKA" <?php if ($konfig[0]['status_pendaftaran'] == 'BUKA') echo "selected"; ?>>DIBUKA</option>
                        </select>
                        <div class="invalid-feedback errorStatus_pendaftaran"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Filter Domisili - Metode Kuliah<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="filter_domisili" name="filter_domisili">
                            <option value="AKTIF" <?php if ($konfig[0]['filter_domisili'] == 'AKTIF') echo "selected"; ?>>AKTIF</option>
                            <option value="NONAKTIF" <?php if ($konfig[0]['filter_domisili'] == 'NONAKTIF') echo "selected"; ?>>NONAKTIF</option>
                        </select>
                        <div class="invalid-feedback errorFilter_domisili"></div>
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
                        if (response.error.angkatan_kuliah) {
                            $('#angkatan_kuliah').addClass('is-invalid');
                            $('.errorAngkatan_kuliah').html(response.error.angkatan_kuliah);
                        } else {
                            $('#angkatan_kuliah').removeClass('is-invalid');
                            $('.errorAngkatan_kuliah').html('');
                        }

                        if (response.error.status_pendaftaran) {
                            $('#status_pendaftaran').addClass('is-invalid');
                            $('.errorStatus_pendaftaran').html(response.error.status_pendaftaran);
                        } else {
                            $('#status_pendaftaran').removeClass('is-invalid');
                            $('.errorStatus_pendaftaran').html('');
                        }

                        if (response.error.filter_domisili) {
                            $('#filter_domisili').addClass('is-invalid');
                            $('.errorFilter_domisili').html(response.error.filter_domisili);
                        } else {
                            $('#filter_domisili').removeClass('is-invalid');
                            $('.errorFilter_domisili').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Ubah Pengaturan Pendaftaran",
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