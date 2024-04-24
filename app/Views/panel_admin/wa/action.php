<!-- Modal -->
<div class="modal fade" id="modalaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('wa-update-action', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if ($modul == "edit") { ?>
                    <input type="hidden" name="code" id="code" value="<?= $wa['code'] ?>">
                    <label for="" class="col-form-label">Status</label>
                    <select class="form-control select2" name="status" id="status">
                        <option value="0" <?php if ($wa['status'] == 0) echo "selected"; ?> >NONAKTIF</option>
                        <option value="1" <?php if ($wa['status'] == 1) echo "selected"; ?> >AKTIF</option>
                    </select>
                <?php } ?>
                <?php if ($modul == "preview") { ?>
                    <label for="" class="col-form-label">Template Preview</label>
                    <div class="row ml-2 mr-2">
                        <textarea class="form-control" rows="20" readonly><?= $wa['template'] ?></textarea>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <?php if ($modul == "edit") { ?>
                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <?php } ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#modalaction'),
            minimumResultsForSearch: Infinity
        });

        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    code: $('input#code').val(),
                    status: $('select#status').val(),
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
                            text: "Berhasil Ubah Status WA Notif",
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