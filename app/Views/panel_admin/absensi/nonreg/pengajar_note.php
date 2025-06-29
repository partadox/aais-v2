<div class="modal fade" id="modalcatatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?? 'Catatan Kehadiran' ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>NIK : <?= $kelas['nk_id'] ?? '-' ?></h6>
                <h6>KELAS : <?= $kelas['nk_nama'] ?? '-' ?></h6>
                <h6>PIC : <?= ($kelas['nk_pic_name'] ?? '-') . ' (' . ($kelas['nk_pic_hp'] ?? '-') . ')' ?></h6>

                <div class="table-responsive">
                    <table id="datatable-tm" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>TM</th>
                                <th>TGL TM</th>
                                <th>WAKTU ISI</th>
                                <th>PENGISI ABSENSI</th>
                                <th>PENGAJAR HADIR</th>
                                <th>NOTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($absenTmNew)): ?>
                                <?php foreach ($absenTmNew as $record): ?>
                                    <tr>
                                        <td width="5%">
                                            <strong><?= $record['tm_sequence'] ?? '-' ?></strong>
                                        </td>
                                        <td width="10%">
                                            <?= isset($record['dt_tm']) ? shortdate_indo($record['dt_tm']) : '-' ?>
                                        </td>
                                        <td width="10%">
                                            <?php if (!empty($record['dt_isi'])): ?>
                                                <?= shortdate_indo(substr($record['dt_isi'], 0, 10)) ?>,
                                                <?= substr($record['dt_isi'], 11, 8) ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td width="15%"><?= $record['by'] ?? '-' ?></td>
                                        <td width="10%" class="text-center">
                                            <?php if (isset($record['status_kehadiran'])): // Ganti 'status_kehadiran' dengan nama kolom yang benar 
                                            ?>
                                                <?php if ($record['status_kehadiran'] == '1'): ?>
                                                    <i style="color: green;" class="mdi mdi-check-bold" title="Hadir"></i>
                                                    <small class="text-success">Hadir</small>
                                                <?php elseif ($record['status_kehadiran'] == '0'): ?>
                                                    <i style="color: red;" class="mdi mdi-minus" title="Tidak Hadir"></i>
                                                    <small class="text-danger">Tidak Hadir</small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td width="25%"><?= !empty($record['note']) ? htmlspecialchars(trim($record['note'])) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        <em>Belum ada data absensi TM</em>
                                    </td>
                                </tr>
                            <?php endif; ?>
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
    $(document).ready(function() {
        $('#datatable-tm').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "responsive": false,
            "pageLength": 25,
            "order": [
                [0, "asc"], // Urutkan berdasarkan kolom TM (indeks 0)
                [1, "asc"] // Kemudian urutkan berdasarkan TGL TM (indeks 1)
            ],
            "columnDefs": [{
                "targets": [4], // Targetkan kolom "PENGAJAR HADIR" (indeks 4)
                "orderable": false // Nonaktifkan pengurutan untuk kolom ini
            }]
        });
    });
</script>