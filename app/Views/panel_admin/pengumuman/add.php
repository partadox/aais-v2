<!-- Modal -->
<div class="modal fade" id="modalpengumumantambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('pengumuman/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
            <div class="modal-body">
                <input type="hidden" class="form-control" id="by" name="by" value="<?= $user['nama'] ?>">
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Judul <code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title">
                        <div class="invalid-feedback errortitle"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Tampil<code>*</code></label>
                    <div class="col-sm-10">
                        <select class="form-control btn-square select2" id="status" name="status">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value=0>Tidak Tampil</option>
                            <option value=1>Tampil</option>
                        </select>
                        <div class="invalid-feedback errorstatus"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Kepada<code>*</code></label>
                    <div class="col-sm-10">
                        <select class="form-control btn-square select2" id="type" name="type">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value=PESERTA>PESERTA</option>
                            <option value=PENGAJAR>PENGAJAR</option>
                        </select>
                        <div class="invalid-feedback errortype"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Isi <code>*</code></label>
                    <div class="col-sm-10">
                        <textarea name="content" id="content"></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#content').summernote({
            height: 100
        });

        $('.select2').select2({
            dropdownParent: $('#modalpengumumantambah'),
            minimumResultsForSearch: Infinity
        });

        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    by: $('input#by').val(),
                    title: $('input#title').val(),
                    status: $('select#status').val(),
                    type: $('select#type').val(),
                    content: $('textarea#content').val(),
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

                        if (response.error.title) {
                            $('#title').addClass('is-invalid');
                            $('.errortitle').html(response.error.title);
                        } else {
                            $('#title').removeClass('is-invalid');
                            $('.errortitle').html('');
                        }

                        if (response.error.status) {
                            $('#status').addClass('is-invalid');
                            $('.errorstatus').html(response.error.status);
                        } else {
                            $('#status').removeClass('is-invalid');
                            $('.errorstatus').html('');
                        }

                        if (response.error.type) {
                            $('#type').addClass('is-invalid');
                            $('.errortype').html(response.error.type);
                        } else {
                            $('#type').removeClass('is-invalid');
                            $('.errortype').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Tambah Pengumuman",
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