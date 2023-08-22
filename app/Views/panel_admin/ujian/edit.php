<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('/ujian/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <!-- <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Semua form input wajib diisi! <br>
                </p> -->
                <input type="hidden" class="form-control" id="peserta_kelas_id" value="<?= $peserta_kelas_id ?>" name="peserta_kelas_id" readonly>
                <input type="hidden" class="form-control" id="ujian_id" value="<?= $ujian['ujian_id'] ?>" name="ujian_id" readonly>
                <input type="hidden" class="form-control" id="peserta_id" value="<?= $peserta_id ?>" name="peserta_id" readonly>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">NIS / Nama</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="<?= $peserta['nis'] ?>" readonly>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="<?= $peserta['nama_peserta'] ?>" readonly>
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
                    <label for="" class="col-sm-2 col-form-label">Tanggal Ujian</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tgl_ujian" name="tgl_ujian" value="<?= $ujian['tgl_ujian'] ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Waktu Ujian</label>
                    <div class="col-sm-10">
                        <input type="time" class="form-control" id="waktu_ujian" name="waktu_ujian" value="<?= $ujian['waktu_ujian'] ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nilai Ujian</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nilai_ujian" name="nilai_ujian" value="<?= $ujian['nilai_ujian'] ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nilai Akhir</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nilai_akhir" name="nilai_akhir" value="<?= $ujian['nilai_akhir'] ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Rekomendasi Level Selanjutnya</label>
                    <div class="col-sm-10">
                        <select name="next_level" id="next_level" class="form-control btn-square">
                                <option Disabled=true Selected=true> Pilih... </option>
                            <?php foreach ($level as $key => $data) { ?>
                                <option value="<?= $data['nama_level'] ?>" <?php if ($ujian['next_level'] == $data['nama_level']) echo "selected"; ?> ><?= $data['nama_level'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Kelulusan</label>
                    <div class="col-sm-10">
                        <select class="form-control btn-square" id="status_peserta_kelas" name="status_peserta_kelas">
                          <option value="BELUM LULUS"  <?php if ($peserta_kelas['status_peserta_kelas'] == 'BELUM LULUS') echo "selected"; ?>>BELUM LULUS</option>
                          <option value="LULUS" <?php if ($peserta_kelas['status_peserta_kelas'] == 'LULUS') echo "selected"; ?>>LULUS</option>
                          <option value="MENGULANG" <?php if ($peserta_kelas['status_peserta_kelas'] == 'MENGULANG') echo "selected"; ?>>MENGULANG</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Kesan Pengajar</label>
                    
                    <div class="col-sm-10">
                        <textarea class="form-control" name="ujian_note" id="ujian_note" style="height: 150px;"><?= $ujian['ujian_note'] ?></textarea>
                    </div>
                </div>
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
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    peserta_kelas_id: $('input#peserta_kelas_id').val(),
                    ujian_id: $('input#ujian_id').val(),
                    peserta_id: $('input#peserta_id').val(),
                    tgl_ujian: $('input#tgl_ujian').val(),
                    waktu_ujian: $('input#waktu_ujian').val(),
                    nilai_ujian: $('input#nilai_ujian').val(),
                    nilai_akhir: $('input#nilai_akhir').val(),
                    next_level: $('select#next_level').val(),
                    status_peserta_kelas: $('select#status_peserta_kelas').val(),
                    ujian_note: $('textarea#ujian_note').val(),
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
                            text: "Berhasil Edit Data Ujian",
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