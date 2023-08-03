<!-- Modal -->
<div class="modal fade" id="modalNote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/pengajar/update-absensi-note', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" name="absen_peserta_id" id="absen_peserta_id" value="<?= $absen['absen_peserta_id'] ?>"  readonly>
                <div class="form-group row">
                    <label for="" class="col-3 col-form-label">Peserta</label>
                    <input type="text" class="col-7 form-control" readonly value="<?= $peserta ?>">
                </div>
                <div class="form-group row">
                    <label for="" class="col-3 col-form-label">TM</label>
                    <select class="col-7 form-control" name="tm" id="tm">
                        <option value="" selected disabled>--PILIH--</option>
                        <?php for($i = 1; $i <= 16; $i++): ?>
                            <option value="<?= $i ?>">TM-<?= $i ?></option>
                        <?php endfor; ?> 
                    </select>
                </div>
                <div class="form-group row" id="divNote" style="display: none;">
                    <label for="" class="col-sm-3 col-form-label">Note</label>
                    <br>
                    <div class="col-sm-12">
                        <textarea class="form-control" name="note"  id="note" cols="50" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan" style="display: none;" id="btnsubmit"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    var tmNotes = <?= $tm_notes ?>;

    document.getElementById('tm').addEventListener('change', function() {
        var tmValue = this.value;
        var divNote = document.getElementById('divNote');
        var btnsubmit = document.getElementById('btnsubmit');
        var textarea = document.getElementById('note');

        if (tmValue) {
        divNote.style.display = 'block';
        btnsubmit.style.display = 'block';

        // Access the corresponding note from the tmNotes object and update the textarea
        textarea.value = tmNotes[tmValue];
        } else {
        divNote.style.display = 'none';
        }
    });

    $(document).ready(function() {
        $('#note').val('');
        $('.formedit').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            var tmValue = $('#tm').val();
            var noteValue = $('#note').val();
            formData += '&tm=' + tmValue + '&note=' + noteValue;

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: formData,
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
                            text: "Berhasil Edit Catatan TM",
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