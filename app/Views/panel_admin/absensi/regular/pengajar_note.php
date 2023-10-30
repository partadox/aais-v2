<!-- Modal -->
<div class="modal fade" id="modalcatatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Pengajar : <?= $pengajar ?></h6>
                <div class="table-responsive">
                <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                        <th width="8%">Tatap Muka (TM)</th>
                        <th width="5%">Tanggal Tatap Muka</th>
                        <th width="30%">Catatan Tatap Muka</th>
                        <th width="10%">Timestamp Pengajar <br> Isi Absensi</th>
                        </tr>
                    </thead>

                    <tbody>
                            <tr>
                                <td > 
                                    Tatap Muka ke-1
                                </td>
                                
                                <td > 
                                    <?php if($tgl_tm1 == '2022-01-01' || $tgl_tm1 == NULL ) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm1 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm1) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm1 ?> </td>
                                <td > <?= $ts1 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-2</td>
                                
                                <td > 
                                    <?php if($tgl_tm2 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm2 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm2) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm2 ?> </td>
                                <td > <?= $ts2 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-3</td>
                                
                                <td > 
                                    <?php if($tgl_tm3 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm3 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm3) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm3 ?> </td>
                                <td > <?= $ts3 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-4</td>
                                
                                <td > 
                                    <?php if($tgl_tm4 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm4 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm4) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm4 ?> </td>
                                <td > <?= $ts4 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-5</td>
                                
                                <td > 
                                    <?php if($tgl_tm5 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm5 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm5) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm5 ?> </td>
                                <td > <?= $ts5 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-6</td>
                                
                                <td > 
                                    <?php if($tgl_tm6 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm6 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm6) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm6 ?> </td>
                                <td > <?= $ts6 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-7</td>
                                
                                <td > 
                                    <?php if($tgl_tm7 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm7 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm7) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm7 ?> </td>
                                <td > <?= $ts7 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-8</td>
                                
                                <td > 
                                    <?php if($tgl_tm8 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm8 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm8) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm8 ?> </td>
                                <td > <?= $ts8 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-9</td>
                                
                                <td > 
                                    <?php if($tgl_tm9 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm9 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm9) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm9 ?> </td>
                                <td > <?= $ts9 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-10</td>
                                
                                <td > 
                                    <?php if($tgl_tm10 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm10 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm10) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm10 ?> </td>
                                <td > <?= $ts10 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-11</td>
                                
                                <td > 
                                    <?php if($tgl_tm11 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm11 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm11) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm11 ?> </td>
                                <td > <?= $ts11 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-12</td>
                                
                                <td > 
                                    <?php if($tgl_tm12 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm12 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm12) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm12 ?> </td>
                                <td > <?= $ts12 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-13</td>
                                
                                <td > 
                                    <?php if($tgl_tm13 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm13 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm13) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm13 ?> </td>
                                <td > <?= $ts13 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-14</td>
                               
                                <td > 
                                    <?php if($tgl_tm14 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm14 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm14) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm14 ?> </td>
                                <td > <?= $ts14 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-15</td>
                                
                                <td > 
                                    <?php if($tgl_tm15 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm15 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm15) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm15 ?> </td>
                                <td > <?= $ts15 ?> </td>
                            </tr>
                            <tr>
                                <td > Tatap Muka ke-16</td>
                               
                                <td > 
                                    <?php if($tgl_tm16 == '2022-01-01' || $tgl_tm1 == NULL) { ?>
                                        <p>-</p>
                                    <?php } ?> 
                                    <?php if($tgl_tm16 != NULL) { ?>
                                        <?= longdate_indo($tgl_tm16) ?>
                                    <?php } ?> 
                                </td>
                                <td > <?= $note_tm16 ?> </td>
                                <td > <?= $ts16 ?> </td>
                            </tr>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>