<!-- Modal -->
<div class="modal fade" id="modalujian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <h5 style="text-align:center;">Kelas <?= $kelas['nama_kelas'] ?></h5>
                <h6 style="text-align:center;"><?= $nama_pengajar ?></h6>
                <h6 style="text-align:center;"><?= $kelas['hari_kelas'] ?>, <?= $kelas['waktu_kelas'] ?> <?= $kelas['zona_waktu_kelas'] ?> - <?= $kelas['metode_kelas'] ?></h6>
                <hr>
                <?php if($program['ujian_show'] == NULL || $program['ujian_show'] =='0' ) { ?>
                    <h6 style="text-align:center;">BELUM ADA DATA</h6>
                <?php } ?>
                <?php if($ujian_status != '1' && $program['ujian_show'] == '1') { ?>
                    <strong>Status Kelulusan: </strong>
                        <?php if($kelulusan == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'MENGULANG') { ?>
                            <button class="btn btn-warning btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    <table class="table table-bordered mt-4">
                        <tbody>
                            <tr>
                                <th width="5%">Pelaksanaan Ujian: </th>
                                <th width="95%"><?= $ujian['tgl_ujian'] ?> <?= $ujian['waktu_ujian'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Nilai Ujian: </th>
                                <th width="95%"><?= $ujian['nilai_ujian'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Nilai Akhir: </th>
                                <th width="95%"><?= $ujian['nilai_akhir'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Rekomendasi level</th>
                                <th width="95%"><?= $ujian['next_level'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Note dari Pengajar</th>
                                <th width="95%"><?= $ujian['ujian_note'] ?></th>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
                <?php if($ujian_status == '1' && $program['ujian_show'] == '1') { ?>
                    <strong>Status Kelulusan: </strong>
                        <?php if($kelulusan == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'MENGULANG') { ?>
                            <button class="btn btn-warning btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    <table class="table table-bordered mt-4">
                        <tbody>
                            <?php for ($i=1; $i <= 10; $i++): ?>
                                <?php
                                    $col_status = 'text'.$i.'_status';
                                    $col_name   = 'text'.$i.'_name'  ;

                                    $val        = 'ucv_text'.$i;
                                    if($ucc[$col_status] == '1') { ?>
                                        <tr>
                                            <th width="5%"><?= $ucc[$col_name] ?>: </th>
                                            <th width="95%"><?= $ujian[$val] ?></th>
                                        </tr>
                                    <?php } ?>
                            <?php endfor; ?>

                            <?php for ($i=1; $i <= 10; $i++): ?>
                                <?php
                                    $col_status = 'int'.$i.'_status';
                                    $col_name   = 'int'.$i.'_name'  ;

                                    $val        = 'ucv_int'.$i;
                                    if($ucc[$col_status] == '1') { ?>
                                        <tr>
                                            <th width="5%"><?= $ucc[$col_name] ?>: </th>
                                            <th width="95%"><?= $ujian[$val] ?></th>
                                        </tr>
                                    <?php } ?>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
 
</script>