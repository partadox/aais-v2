<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/ujian-custom/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <style>
                .modal-dialog {
                    overflow-y: auto !important;
                }
                .modal-body {
                    max-height: calc(100vh - 150px); /* Adjust the value as needed */
                }
            </style>
            <div class="modal-body">
                <!-- <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Semua form input wajib diisi! <br>
                </p> -->
                <input type="hidden" class="form-control" id="ucv_id" value="<?= $ucv['ucv_id'] ?>" name="ucv_id" readonly>
                <input type="hidden" class="form-control" id="peserta_id" value="<?= $peserta['peserta_id'] ?>" name="peserta_id" readonly>
                <input type="hidden" class="form-control" id="peserta_kelas_id" value="<?= $peserta_kelas_id ?>" name="peserta_kelas_id" readonly>
                <input type="hidden" class="form-control" id="angkatan" value="<?= $kelas['angkatan_kelas'] ?>" name="angkatan" readonly>
                <input type="hidden" class="form-control" id="program" value="<?= $kelas['program_id'] ?>" name="program" readonly>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">NIS - Nama</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="<?= $peserta['nis'] ?> - <?= $peserta['nama_peserta'] ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $kelas['nama_kelas'] ?>" readonly>
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Kelulusan</label>
                    <div class="col-sm-10">
                        <select class="form-control btn-square" id="status_peserta_kelas" name="status_peserta_kelas">
                            <option value="BELUM LULUS"  <?php if ($kelulusan == 'BELUM LULUS') echo "selected"; ?> >BELUM LULUS</option>
                            <option value="LULUS" <?php if ($kelulusan == 'LULUS') echo "selected"; ?> >LULUS</option>
                            <option value="MENGULANG" <?php if ($kelulusan == 'MENGULANG') echo "selected"; ?> >MENGULANG</option>
                        </select>
                    </div>
                </div>

                <?php for ($i=1; $i <= 10; $i++): ?>
                    <?php
                        $col_status = 'text'.$i.'_status';
                        $col_name   = 'text'.$i.'_name'  ;

                        $val        = 'ucv_text'.$i;
                        if($ucc[$col_status] == '1') { ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label"><?= strtoupper($ucc[$col_name]) ?></label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="<?= $val ?>" id="<?= $val ?>" style="height: 80px;"><?= $ucv[$val] ?></textarea>
                                </div>
                            </div>
                        <?php } ?>
                <?php endfor; ?>

                <?php for ($i=1; $i <= 10; $i++): ?>
                    <?php
                        $col_status = 'int'.$i.'_status';
                        $col_name   = 'int'.$i.'_name'  ;

                        $val        = 'ucv_int'.$i;
                        if($ucc[$col_status] == '1') { ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label"><?= strtoupper($ucc[$col_name]) ?></label>
                                <div class="col-sm-10">
                                    <input type="number" min="0" max="100" class="form-control" name="<?= $val ?>" id="<?= $val ?>" value="<?= $ucv[$val] ?>">
                                </div>
                            </div>
                        <?php } ?>
                <?php endfor; ?>
                <div class="text-right mt-2">
                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
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
            var data = {
                ucv_id: $('input#ucv_id').val(),
                peserta_id: $('input#peserta_id').val(),
                peserta_kelas_id: $('input#peserta_kelas_id').val(),
                angkatan: $('input#angkatan').val(),
                program: $('input#program').val(),
                status_peserta_kelas: $('select#status_peserta_kelas').val()
            };

            for (var i = 1; i <= 10; i++) {
                data['ucv_text' + i] = $('textarea#ucv_text' + i).val();
                data['ucv_int' + i] = $('input#ucv_int' + i).val();
            }

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: data,
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
                            text: "Berhasil Ubah Data Ujian",
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