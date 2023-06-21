<!-- Modal -->
<div class="modal fade" id="modalabsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <h5 style="text-align:center;">Kelas <?= $detail_kelas[0]['nama_kelas'] ?></h5>
                <h6 style="text-align:center;"><?= $detail_kelas[0]['hari_kelas'] ?>, <?= $detail_kelas[0]['waktu_kelas'] ?> - <?= $detail_kelas[0]['metode_kelas'] ?></h6>
                <h6 style="text-align:center;"><?= $detail_kelas[0]['nama_pengajar'] ?></h6>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                            <th width="5%">TM-1</th>
                            <th width="5%">TM-2</th>
                            <th width="5%">TM-3</th>
                            <th width="5%">TM-4</th>
                            <th width="5%">TM-5</th>
                            <th width="5%">TM-6</th>
                            <th width="5%">TM-7</th>
                            <th width="5%">TM-8</th>
                            <th width="5%">TM-9</th>
                            <th width="5%">TM-10</th>
                            <th width="5%">TM-11</th>
                            <th width="5%">TM-12</th>
                            <th width="5%">TM-13</th>
                            <th width="5%">TM-14</th>
                            <th width="5%">TM-15</th>
                            <th width="5%">TM-16</th>
                            <th width="7%"class="missed-col">Jumlah <br> Kehadiran</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php ?>
                                <tr>
                                <td >
                                    <?php if($tm1 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm1 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i> 
                                    <?php } ?>
                                    <?php if($tm1 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm2 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm2 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm2 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm3 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm3 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm3 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm4 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm4 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm4 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm5 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm5 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm5 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm6 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm6 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm6 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm7 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm7 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm7 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm8 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm8 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm8 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm9 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm9 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm9 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm10 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm10 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm10 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm11 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm11 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm11 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm12 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm12 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm12 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm13 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm13 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm13 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm14 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm14 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm14 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm15 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm15 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm15 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td >
                                    <?php if($tm16 == NULL) { ?>
                                        <p></p>
                                    <?php } ?>
                                    <?php if($tm16 == '0') { ?>
                                        <i class=" fa fa-minus" style="color:red"></i>
                                    <?php } ?>
                                    <?php if($tm16 == '1') { ?>
                                        <i class=" fa fa-check" style="color:green"></i>
                                    <?php } ?>
                                </td>
                                <td ><?= $tm1+$tm2+$tm3+$tm4+$tm5+$tm6+$tm7+$tm8+$tm9+$tm10+$tm11+$tm12+$tm13+$tm14+$tm15+$tm16 ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm1'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm1'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm1']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm2'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm2'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm2']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm3'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm3'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm3']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm4'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm4'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm4']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm5'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm5'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm5']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm6'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm6'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm6']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm7'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm7'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm7']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm8'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm8'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm8']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm9'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm9'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm9']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm10'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm10'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm10']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm11'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm11'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm11']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm12'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm12'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm12']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm13'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm13'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm13']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm14'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm14'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm14']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm15'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm15'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm15']) ?></p>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($detail_kelas[0]['tgl_tm16'] == '2022-01-01') { ?>
                                            <p></p>
                                        <?php } ?>
                                        <?php if($detail_kelas[0]['tgl_tm16'] != '2022-01-01') { ?>
                                            <p><?= longdate_indo($detail_kelas[0]['tgl_tm16']) ?></p>
                                        <?php } ?>
                                    </td>
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
<script>
 
</script>