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
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tatap Muka <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="hidden" id="bk_id" name="bk_id" value="<?= $kelas['bk_id'] ?>" readonly>
                        <input type="hidden" id="bs_id" name="bs_id" value="<?= $bs_id ?>" readonly>
                        <input type="hidden" id="metode" name="metode" value="Perwakilan" readonly>
                        <input type="hidden" id="func" name="func" value="<?= $func ?>" readonly>
                        <input class="form-control" type="text" id="bas_tm" name="bas_tm" value="<?= $tm ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <div class="input-group" id="datepicker2">
                            <input type="text" id="bas_tm_dt" name="bas_tm_dt" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                data-provide="datepicker" data-date-autoclose="true" value="<?= $tgl_tm ?>">
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

                <h5> <u>Peserta</u></h5>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                            <th width="2%">No.</th>
                            <th width="3%">NIS</th>
                            <th width="20%"class="name-col">Nama Peserta</th>
                            <th width="4%" bgcolor="#87de9d">Hadir </th>
                            <th width="4%" bgcolor="#de8887">Tidak Hadir </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php 
                            $counter = 0;
                            $b = 0;
                            foreach ($list as $data) :
                                $counter++;
                                $isChecked = '';
                            ?>
                            <tr>
                                <td><?= $counter ?></td>
                                <td>
                                    <?= $data['nis'] ?>
                                    <input type="hidden" name="jml_psrt[]" value="<?= $data['bs_id'] ?>">
                                    <?php if(isset($data['bas_id'])) : ?>
                                        <input type="hidden" name="jml_basid[]" value="<?= $data['bas_id'] ?>">
                                    <?php endif; ?>
                                    <?php if(!isset($data['bas_id'])) : ?>
                                        <input type="hidden" name="jml_basid_new[]" value="<?= $data['bs_id'] ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($data['bs_status_peserta'] == 'OFF') : ?>
                                        <del>
                                    <?php endif; ?>
                                    <?= $data['nama_peserta'] ?>
                                    <?php if($data['bs_status_peserta'] == 'OFF') : ?>
                                        </del>
                                        <a class="btn btn-sm btn-danger">OFF</a>
                                    <?php endif; ?>

                                    <input type="hidden" name="psrt<?= $counter ?>" value="<?= $data['bs_id'] ?>">

                                    <?php if(isset($data['bas_id'])) : ?>
                                        <input type="hidden" name="basid<?= $counter ?>" value="<?= $data['bas_id'] ?>">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <input type="radio" name="check<?= $counter ?>" value="1" <?php if(isset($data['bas_absen']) && $data['bas_absen'] == '1') : ?> checked <?php endif;?> >
                                </td>
                                <td>
                                    <input type="radio" name="check<?= $counter ?>" value="0" <?php if(isset($data['bas_absen'])&& $data['bas_absen'] == '0') : ?> checked <?php endif;?>  >
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <?php if ($tm <= $kelas['bk_tm_total']): ?>
                    <button type="submit" onclick="validateForm()" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <?php endif; ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<script>
    function validateForm() {
        var radioSets = <?php echo json_encode(count($list)); ?>; // Assuming $list is your PHP variable

        for (var i = 1; i <= radioSets; i++) {
            var radio1 = document.querySelector('input[name="check' + i + '"][value="1"]');
            var radio0 = document.querySelector('input[name="check' + i + '"][value="0"]');
            
            if (!radio1.checked && !radio0.checked) {
                radio1.setAttribute('required', 'required');
                radio0.setAttribute('required', 'required');
            } else {
                radio1.removeAttribute('required');
                radio0.removeAttribute('required');
            }
        }
    }
</script>
