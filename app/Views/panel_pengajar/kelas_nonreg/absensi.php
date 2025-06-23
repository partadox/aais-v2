<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<a href="<?= base_url('/pengajar/kelas-nonreg') ?>">
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<br>


<h5 style="text-align:center;">Kelas <?= $kelas['nk_nama'] ?></h5>
<h6 style="text-align:center;"><?= $kelas['nk_hari'] ?>, <?= $kelas['nk_waktu'] ?> <?= $kelas['nk_timezone'] ?></h6>


<!-- <div class="row mt-2">
    <div class="col d-flex flex-column align-items-center">
        <label for=""><code>Pilih TM untuk Pengisian Absensi</code></label>
        <select onchange="inputAbsensi(this.value);" class="form-control select-single col-2" name="inputTM" id="inputTM">
            <option value="" selected disabled>--PILIH--</option>
            <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                <option value="<?= $i ?>">TATAP MUKA <?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div> -->
<div class="row mt-2">
    <div class="col d-flex flex-column align-items-center">
        <label for=""><code>Pilih TM untuk Pengisian Absensi</code></label>
        <select onchange="inputAbsensi(this.value);" class="form-control select2Search col-2" name="inputTM" id="inputTM" style="width: 60%;">
            <option value="" selected disabled>--PILIH--</option>
            <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                <option value="<?= $i ?>">TATAP MUKA <?= $i ?></option>
            <?php endfor; ?>
        </select>
        <small id="tmHint" class="text-muted mt-1"></small>
    </div>
</div>

<div class="table-responsive mt-3">
    <table id="datatable-absen" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA</th>
                <!-- <th>NOTE</th> -->
                <th>JML. HADIR</th>
                <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                    <th><?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($peserta_onkelas as $data) :
                $nomor++; ?>
                <tr>
                    <td width="5%"><?= $nomor ?></td>
                    <td width="15%">
                        <?= $data['nama'] ?>
                    </td>
                    <!-- <td width="5%">
                        <button class="btn btn-sm btn-info" onclick="inputNote(<?= $data['naps_id'] ?>)"> <i class="mdi mdi-file"></i> </button>
                    </td> -->
                    <td width="10%">
                        <?php $totHadir = 0;
                        for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                            <?php if (isset($data['naps' . $i])) { ?>
                                <?php if ($data['naps' . $i]['tm'] == '1') {
                                    $totHadir = $totHadir + 1; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php endfor; ?>
                        <?= $totHadir ?>
                    </td>
                    <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                        <td>
                            <?php if (isset($data['naps' . $i])) { ?>
                                <?php if ($data['naps' . $i]['tm'] == '1') { ?>
                                    <i style="color: green;" class="mdi mdi-check-bold"></i>
                                <?php } ?>
                                <?php if ($data['naps' . $i]['tm'] == '0') { ?>
                                    <i style="color: red;" class="mdi mdi-minus"></i>
                                <?php } ?>
                            <?php } ?>
                        </td>
                    <?php endfor; ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<hr>

<h5>Absensi dan Catatan Pengajar</h5>

<!-- <div class="table-responsive">
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
            <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++): ?>
                <tr>
                    <td width="5%"><?= $i ?></td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj' . $i]['dt_tm'])) { ?>
                            <?= shortdate_indo($absenTm['napj' . $i]['dt_tm']) ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj' . $i]['dt_isi'])) { ?>
                            <?= shortdate_indo(substr($absenTm['napj' . $i]['dt_isi'], 0, 10)) ?>, <?= substr($absenTm['napj' . $i]['dt_isi'], 11, 15) ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj' . $i]['by'])) { ?>
                            <?= $absenTm['napj' . $i]['by'] ?>
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if (isset($absenTm['napj' . $i]['tm'])) { ?>
                            <?php if ($absenTm['napj' . $i]['tm'] == '1') { ?>
                                <i style="color: green;" class="mdi mdi-check-bold"></i>
                            <?php } ?>
                            <?php if ($absenTm['napj' . $i]['tm'] == '0') { ?>
                                <i style="color: red;" class="mdi mdi-minus"></i>
                            <?php } ?>
                        <?php } ?>
                    </td>
                    <td width="20%">
                        <?php if (isset($absenTm['napj' . $i]['dt_isi'])) { ?>
                            <?= $absenTm['napj' . $i]['note'] ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php endfor; ?>

        </tbody>
    </table>
</div> -->

<?php

// Group data by TM untuk tampilan yang lebih terstruktur (optional)
$groupedByTM = [];
foreach ($absenTmNew as $record) {
    $tmNumber = $record['tm'];
    if (!isset($groupedByTM[$tmNumber])) {
        $groupedByTM[$tmNumber] = [];
    }
    $groupedByTM[$tmNumber][] = $record;
}
ksort($groupedByTM); // Sort by TM number
?>

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
                <?php foreach ($groupedByTM as $tmNumber => $tmRecords): ?>
                    <?php foreach ($tmRecords as $index => $record): ?>
                        <tr>
                            <!-- TM Number -->
                            <td width="5%">
                                <strong><?= $record['tm_sequence'] ?></strong>
                            </td>

                            <!-- Tanggal TM -->
                            <td width="10%">
                                <?php if (!empty($record['dt_tm'])): ?>
                                    <?= shortdate_indo($record['dt_tm']) ?>
                                <?php endif; ?>
                            </td>

                            <!-- Waktu Input -->
                            <td width="10%">
                                <?php if (!empty($record['dt_isi'])): ?>
                                    <?= shortdate_indo(substr($record['dt_isi'], 0, 10)) ?>,
                                    <?= substr($record['dt_isi'], 11, 8) ?>
                                <?php endif; ?>
                            </td>

                            <!-- Pengisi Absensi -->
                            <td width="15%">
                                <?= $record['by'] ?? '' ?>
                            </td>

                            <!-- Status Kehadiran Pengajar -->
                            <td width="10%" class="text-center">
                                <?php if (!empty($record['tm'])): ?>
                                    <?php if ($record['tm'] == '1'): ?>
                                        <i style="color: green;" class="mdi mdi-check-bold" title="Hadir"></i>
                                        <small class="text-success">Hadir</small>
                                    <?php elseif ($record['tm'] == '0'): ?>
                                        <i style="color: red;" class="mdi mdi-minus" title="Tidak Hadir"></i>
                                        <small class="text-danger">Tidak Hadir</small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>

                            <!-- Note -->
                            <td width="25%">
                                <?= !empty($record['note']) ? trim($record['note']) : '-' ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        <em>Belum ada data absensi TM</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modalIsi"></div>
<div class="modalIsiNote"></div>

<script>
    $(document).ready(function() {
        $('#datatable-absen').DataTable({
            "paging": false,
            "searching": true,
            "info": true,
            "responsive": false,
            "scrollX": true,
            "fixedColumns": {
                "leftColumns": 0
            },
            "pageLength": 25,
            "order": [
                [0, "asc"],
                [1, "asc"]
            ], // Sort by TM then by date
            "columnDefs": [{
                    "targets": [4], // Status column
                    "orderable": false
                },
                {
                    "targets": [6], // Entry sequence column
                    "orderable": true,
                    "type": "num"
                }
            ]
        });

        $('#datatable-tm').DataTable({
            "paging": true,
            "searching": true,
            "info": true,
            "responsive": false,
            "pageLength": 25,
            "order": [
                [0, "asc"],
                [1, "asc"]
            ], // Sort by TM then by date
            "columnDefs": [{
                    "targets": [4], // Status column
                    "orderable": false
                },
                {
                    "targets": [6], // Entry sequence column
                    "orderable": true,
                    "type": "num"
                }
            ]
        });
    });

    $(document).ready(function() {
        $('.select2Search').select2({});
    });

    function inputAbsensi(tm) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('/pengajar/input-absensi-nonreg') ?>",
            data: {
                nk_id: "<?= $kelas['nk_id'] ?>",
                tm: tm,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.modalIsi').html(response.sukses).show();
                    $('#modaltm').modal('show');
                }
            }
        });
    }

    function inputNote(absen_pesertaId) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('/pengajar/absensi-note') ?>",
            data: {
                absen_pesertaId: absen_pesertaId,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.modalIsiNote').html(response.sukses).show();
                    $('#isiNote').modal('show');
                }
            }
        });
    }

    const pesertaData = <?php echo json_encode($peserta_onkelas); ?>;
    const maxTM = <?php echo $kelas['nk_tm_ambil']; ?>;

    /**
     * Calculate next TM that should be filled
     */
    function calculateNextTM() {
        let maxFilledTM = 0;

        for (const student of pesertaData) {
            if (!student.nama) continue;

            for (let i = maxTM; i >= 1; i--) {
                const napsKey = `naps${i}`;
                if (student[napsKey] !== null && student[napsKey] !== undefined) {
                    maxFilledTM = Math.max(maxFilledTM, i);
                    break;
                }
            }
        }

        const nextTM = Math.min(maxFilledTM + 1, maxTM);
        const allFilled = maxFilledTM >= maxTM;

        return {
            maxFilledTM,
            nextTM,
            allFilled
        };
    }

    /**
     * Setup sequential select options
     */
    function setupSequentialSelect() {
        const select = document.getElementById('inputTM');
        const hint = document.getElementById('tmHint');

        // Wait for element to exist
        if (!select) {
            setTimeout(setupSequentialSelect, 100);
            return;
        }

        const {
            maxFilledTM,
            nextTM,
            allFilled
        } = calculateNextTM();
        const options = select.querySelectorAll('option');

        if (allFilled) {
            select.disabled = true;
            options[0].textContent = '--SEMUA TM SUDAH TERISI--';
            if (hint) hint.textContent = 'Semua TM sudah terisi lengkap';

            for (let i = 1; i < options.length; i++) {
                options[i].disabled = true;
            }
            return;
        }

        // Enable/disable options
        for (let i = 1; i < options.length; i++) {
            const tmNumber = parseInt(options[i].value);
            const canSelect = tmNumber <= maxFilledTM || tmNumber === nextTM;
            const isNext = tmNumber === nextTM;
            const isFilled = tmNumber <= maxFilledTM;

            options[i].disabled = !canSelect;

            let optionText = `TATAP MUKA ${tmNumber}`;
            if (isNext && !allFilled) {
                // optionText += ' (Selanjutnya)';
                optionText += '';
            } else if (isFilled) {
                // optionText += ' (Terisi)';
                optionText += '';
            }
            options[i].textContent = optionText;
        }

        if (hint) hint.textContent = `Silakan isi TM ${nextTM} selanjutnya`;

        console.log(`Sequential setup complete: Next TM = ${nextTM}`);
    }

    /**
     * Your existing inputAbsensi function - keep it exactly as is
     * Just add validation before the AJAX call
     */
    function inputAbsensi(tm) {
        // Don't interfere with your existing logic
        if (!tm) return;

        console.log(`inputAbsensi called with TM: ${tm}`);

        // Your original AJAX call
        $.ajax({
            type: "POST",
            url: "<?= site_url('/pengajar/input-absensi-nonreg') ?>",
            data: {
                nk_id: "<?= $kelas['nk_id'] ?>",
                tm: tm,
            },
            dataType: "json",
            success: function(response) {
                console.log('AJAX response:', response);
                if (response.sukses) {
                    $('.modalIsi').html(response.sukses).show();
                    $('#modaltm').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
    }

    /**
     * Call this after modal closes and attendance is saved
     */
    function refreshAfterAttendanceSave() {
        // Reset select
        const select = document.getElementById('inputTM');
        if (select) {
            select.selectedIndex = 0;
            select.disabled = false;
        }

        // Recalculate sequential logic
        setupSequentialSelect();
    }

    // Initialize after DOM is ready
    $(document).ready(function() {
        console.log('DOM ready, setting up sequential select');
        setupSequentialSelect();
    });

    // Alternative initialization if jQuery is loaded after
    if (typeof $ === 'undefined') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up sequential select');
            setupSequentialSelect();
        });
    }

    // Also try immediate execution if DOM already loaded
    if (document.readyState === 'loading') {
        // Do nothing, wait for DOMContentLoaded
    } else {
        // DOM already loaded
        console.log('DOM already loaded, setting up sequential select immediately');
        setupSequentialSelect();
    }

    // function tm(tm, kelas_id, data_absen_pengajar) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('/pengajar/input-absensi') ?>",
    //         data: {
    //             tm : tm,
    //             kelas_id : kelas_id,
    //             data_absen_pengajar : data_absen_pengajar,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.viewmodaltm').html(response.sukses).show();
    //                 $('#modaltm').modal('show');
    //             }
    //         }
    //     });
    // }

    // function aturAbsen(kelas_id) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('/pengajar/atur-absensi') ?>",
    //         data: {
    //             kelas_id : kelas_id
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.viewmodalaturabsen').html(response.sukses).show();
    //                 $('#modalatur').modal('show');
    //             }
    //         }
    //     });
    // }

    // function note(absen_peserta_id, nis, nama, kelas_id) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('/pengajar/absensi-note') ?>",
    //         data: {
    //             absen_peserta_id: absen_peserta_id,
    //             nis: nis,
    //             nama: nama,
    //             kelas_id: kelas_id,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.editNote').html(response.sukses).show();
    //                 $('#modalNote').modal('show');
    //             }
    //         }
    //     });
    // }

    // function tm_pengajar(tm, kelas_id, data_absen_pengajar) {
    //     $.ajax({
    //         type: "post",
    //         url: "<?= site_url('absen/input_tm_pengajar') ?>",
    //         data: {
    //             tm : tm,
    //             kelas_id : kelas_id,
    //             data_absen_pengajar : data_absen_pengajar
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.viewmodaltmpgj').html(response.sukses).show();
    //                 $('#modaltmpgj').modal('show');
    //             }
    //         }
    //     });
    // }
</script>

<?= $this->endSection('isi') ?>