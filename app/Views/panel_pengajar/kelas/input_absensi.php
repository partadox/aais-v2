<!-- Modal -->
<div class="modal fade" id="modaltm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?> <?= $tm_upper ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('/pengajar/save-absensi');
            ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="tatap_muka" value="<?= $tm ?>">
            <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
            <input type="hidden" name="absen_pengajar_id" value="<?= $absen_pengajar_id ?>">
            <div class="modal-body">
                <h5> <u>Pengajar: <?= $nama_pengajar ?></u> </h5>
                    <?php for ($i = 1; $i <= 16; $i++): ?>
                        <?php if($tm == 'tm'.$i): ?>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Absensi <?= $tm_upper ?><code>*</code></label>
                                <div class="col-sm-8">
                                    <input type="hidden" name="checkpgj<?= $i ?>" value="1">
                                    <label class="form-check-label" for="checkpgj<?= $i ?>"> HADIR</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal <?= $tm_upper ?></label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tgl_tm<?= $i ?>" name="tgl_tm<?= $i ?>" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-2 col-form-label">Catatan <?= $tm_upper ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control text-uppercase" id="note_tm<?= $i ?>" name="note_tm<?= $i ?>" value="<?= $absen_pengajar['note_tm'.$i] ?>">
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                <hr>
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

                <h5> <u>Peserta</u></h5>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                            <th width="2%">No.</th>
                            <th width="3%">NIS</th>
                            <th width="20%"class="name-col" >Nama Peserta</th>
                            <th width="4%" bgcolor="#87de9d">Hadir </th>
                            <th width="4%" bgcolor="#de8887">Tidak Hadir </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $counter = 0;
                            foreach ($absen_tm as $data) :
                                $counter++;
                                $isChecked = '';
                            ?>
                            <tr>
                                <td><?= $counter ?></td>
                                <td>
                                    <?= $data['nis'] ?>
                                    <input type="hidden" name="jml_psrt[]" value="<?= $data['peserta_kelas_id'] ?>">
                                </td>
                                <td>
                                    <?php if($data['status_aktif_peserta'] == 'OFF') : ?>
                                        <del>
                                    <?php endif; ?>
                                    <?= $data['nama_peserta'] ?>
                                    <?php if($data['status_aktif_peserta'] == 'OFF') : ?>
                                        </del>
                                        <a class="btn btn-sm btn-danger">OFF</a>
                                    <?php endif; ?>
                                    <input type="hidden" name="psrt<?= $counter ?>" value="<?= $data['data_absen'] ?>">
                                </td>
                                <?php for($i=1; $i <= 16; $i++): ?>
                                    <?php if($tm == 'tm'.$i) : ?>
                                        <td>
                                            <input type="hidden" name="check<?= $counter ?>" value="0">
                                            <input type="radio" name="check<?= $counter ?>" value="1" <?= $data['tm'.$i] == '1' ? 'checked' : ''; ?>>
                                        </td>
                                        <td>
                                            <input type="radio" name="check<?= $counter ?>" value="0" <?= ($data['tm'.$i] == '0' || $data['tm'.$i] == NULL) ? 'checked' : ''; ?>>
                                        </td>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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