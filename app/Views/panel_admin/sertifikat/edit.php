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
                            <input type="text" class="form-control" value="<?= $data_sertifikat['nomor_sertifikat']?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Peserta</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= $data_peserta['nis'] . ' - '. $data_peserta['nama_peserta'] ?>" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Tindakan</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="tindakan" id="tindakan">
                                <option value="" disabled selected>--PILIH--</option>
                                <option value="tampil"> Atur Tampilan e-Sertifikat di Peserta</option>
                                <option value="hapus"> Hapus e-Sertifikat</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row" id="tampil" style="display: none;">
                        <label for="" class="col-sm-4 col-form-label">e-Sertifikat Tampil di Sisi Peserta</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="unshow" id="unshow">
                                <option value="0" <?php if($data_sertifikat['unshow'] != '1'){?> selected <?php } ?>  >Tampil</option>
                                <option value="1" <?php if($data_sertifikat['unshow'] == '1'){?> selected <?php } ?> >Tidak</option>
                            </select>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning btnsimpan"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <?= form_close() ?>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $('#tindakan').change(function () {
        if ($(this).val() == "tampil") {
            $('#tampil').show();
            $('#unshow').prop('required', true);
        } else {
            $('#tampil').hide();
            $('#unshow').prop('required', false);
        }
    });

    $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    tindakan: $('select#tindakan').val(),
                    unshow: $('select#unshow').val(),
                    sertifikat_id: $('input#sertifikat_id').val(),
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

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Tindakan Berhasil Diterapkan",
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