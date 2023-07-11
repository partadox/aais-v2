<!-- Modal -->
<div class="modal fade" id="modalAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('/peserta/absensi-regular-save');
            ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
            <?php if (strtotime(date('Y-m-d H:i:s')) <= strtotime($kelas['expired_absen'])): ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tatap Muka <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="hidden" id="absen_peserta_id" name="absen_peserta_id" value="<?= $absensi['absen_peserta_id'] ?>" readonly>
                        <input type="hidden" id="metode" name="metode" value="<?= $kelas['metode_absen'] ?>" readonly>
                        <input type="hidden" id="kelas_id" name="kelas_id" value="<?= $kelas['kelas_id'] ?>" readonly>
                        <input class="form-control" type="text" id="tm" name="tm" value="<?= $kelas['tm_absen'] ?>" readonly>
                    </div>
                </div>

                <style>
                    .table-responsive {
                        max-height:300px;
                    }

                    .wrapper {
                        position: relative;
                    }

                    .overlay th {
                        position: absolute;
                        top:0;
                    }
                </style>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                            <th width="3%">NIS</th>
                            <th width="20%"class="name-col">Nama Peserta</th>
                            <th width="4%" bgcolor="#87de9d">Hadir </th>
                            <th width="4%" bgcolor="#de8887">Tidak Hadir </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    <?= $peserta['nis'] ?>
                                </td>
                                <td>
                                    <?= $peserta['nama_peserta'] ?>
                                </td>
                                <td>
                                    <input type="radio" name="check" value="1">
                                </td>
                                <td>
                                    <input type="radio" name="check" value="0">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Catatan TM</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="note_ps_tm" id="note_ps_tm" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (strtotime(date('Y-m-d H:i:s')) > strtotime($kelas['expired_absen'])): ?>
                <h5>Sudah Melebihi Batas Waktu Isi Absen</h5>
                <br>Batas Waktu: <p style="color: red;"><?= shortdate_indo(substr($kelas['expired_absen'],0,10)) ?>, <?= substr($kelas['expired_absen'],11,5) ?> WITA</p>
            <?php endif; ?>
            <div class="modal-footer">
                <?php if (strtotime(date('Y-m-d H:i:s')) <= strtotime($kelas['expired_absen'])): ?>
                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
