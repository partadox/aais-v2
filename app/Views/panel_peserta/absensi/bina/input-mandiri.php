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
            <?php echo form_open_multipart('/peserta/absensi-bina-save');
            ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
            <?php if ($tm > $kelas['bk_tm_total']): ?>
                <h5>Sudah Terisi Sesuai Jumlah Max. TM</h5>
            <?php endif; ?>
            <?php if ($tm <= $kelas['bk_tm_total'] && strtotime(date('Y-m-d H:i:s')) <= strtotime($kelas['bk_absen_expired'])): ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tatap Muka <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="hidden" id="bk_id" name="bk_id" value="<?= $kelas['bk_id'] ?>" readonly>
                        <input type="hidden" id="bs_id" name="bs_id" value="<?= $bs_id ?>" readonly>
                        <input type="hidden" id="metode" name="metode" value="Mandiri" readonly>
                        <input class="form-control" type="text" id="bas_tm" name="bas_tm" value="<?= $tm ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <div class="input-group" id="datepicker2">
                            <input type="text" id="bas_tm_dt" name="bas_tm_dt" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                data-provide="datepicker" data-date-autoclose="true" value="<?= date("Y-m-d") ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                            <div class="invalid-feedback error_bas_tm_dt"></div>
                        </div>
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
                                    <?php if($bs['bs_status_peserta'] == 'OFF') : ?>
                                        <del>
                                    <?php endif; ?>
                                    <?= $peserta['nama_peserta'] ?>
                                    <?php if($bs['bs_status_peserta'] == 'OFF') : ?>
                                        </del>
                                        <a class="btn btn-sm btn-danger">OFF</a>
                                    <?php endif; ?>
                                    <input type="hidden" name="psrt" value="<?= $bs['bs_id'] ?>">
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
                        <textarea class="form-control" name="bas_note" id="bas_note" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (strtotime(date('Y-m-d H:i:s')) > strtotime($kelas['bk_absen_expired'])): ?>
                <h5>Sudah Melebihi Batas Waktu Isi Absen</h5>
                <br>Batas Waktu: <p style="color: red;"><?= shortdate_indo(substr($kelas['bk_absen_expired'],0,10)) ?>, <?= substr($kelas['bk_absen_expired'],11,5) ?> WITA</p>
            <?php endif; ?>
            <div class="modal-footer">
                <?php if ($tm <= $kelas['bk_tm_total'] && strtotime(date('Y-m-d H:i:s')) <= strtotime($kelas['bk_absen_expired'])): ?>
                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
