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
            <?= form_open('kelas-nonreg/update-level', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
            <!-- <p class="mt-1">Catatan :<br> 
                <i class="mdi mdi-information"></i> Nama Kelas Harus Unik, Format Penamaan Angkatan-Level-Jenkel-Waktu. Contoh A01-TAJWIDI-1-AKHWAT-SENIN18 <br>
            </p> -->
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"><?= $modulText ?> <code>*</code></label>
                    <input type="hidden" name="nk_id" id="nk_id" value="<?= $nk_id ?>">
                    <input type="hidden" name="modul" id="modul" value="<?= $modul ?>">
                    <?php if ($modul == "level"){?>
                        <div class="col-sm-8">
                            <select name="nk_level[]" id="nk_level"  multiple="multiple" class="select2SearchEdit" required>
                                <?php foreach ($level as $key => $data) { ?>
                                    <option value="<?= $data['peserta_level_id'] ?>"><?= $data['nama_level'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php }?>
                    <?php if ($modul == "pengajar"){?>
                        <div class="col-sm-8">
                            <select name="np_pengajar[]" id="np_pengajar"  multiple="multiple" class="select2SearchEdit" required>
                                <?php foreach ($pengajar as $key => $data) { ?>
                                    <option value="<?= $data['pengajar_id'] ?>"><?= $data['nama_pengajar'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php }?>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning btnsimpan"><i class="fa fa-share-square"></i> Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2SearchEdit').select2({
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

                        if (response.error.nk_nama) {
                            $('#nk_nama').addClass('is-invalid');
                            $('.errorNamakelas').html(response.error.nk_nama);
                        } else {
                            $('#nk_nama').removeClass('is-invalid');
                            $('.errorNamakelas').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Kelas Non-Reguler",
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