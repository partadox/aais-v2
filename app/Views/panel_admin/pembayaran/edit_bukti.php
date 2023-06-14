<!-- Modal -->
<div class="modal fade" id="modalgambar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('/pembayaran/update-bukti');
            helper('text');
            ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="bayar_id" name="bayar_id" value="<?= $bayar_id ?>" >
                

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Upload Bukti Transfer<code>*</code></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input"  id="foto" name="foto" onchange="previewimg()" accept=".jpg,.jpeg,.png">
                                <label class="custom-file-label">Upload Bukti Transfer</label>
                            </div>
                        </div>
                    </div>
                    <div class="invalid-feedback errorFoto"></div>
                    <div class="col-lg-8 mt-2 content-justify-center">
                        <div class="media">
                            <img src="" class="img-preview img-thumbnail rounded img-fluid" width="50%" alt >
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?php echo form_close() ?>
        </div>
    </div>
</div>