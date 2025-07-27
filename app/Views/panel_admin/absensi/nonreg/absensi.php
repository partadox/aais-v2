<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<a href="<?= base_url('/kelas-nonreg/detail?id=' . $kelas['nk_id']) ?>">
    <button type="button" class="btn btn-secondary mb-3"><i class="fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<h5 style="text-align:center;">Kelas <?= esc($kelas['nk_nama']) ?></h5>
<h6 style="text-align:center;"><?= esc($kelas['nk_hari']) ?>, <?= esc($kelas['nk_waktu']) ?> <?= esc($kelas['nk_timezone']) ?></h6>
<style>
    /* Memberi warna latar abu-abu pada opsi yang tidak bisa dipilih (disabled) di Select2 */
    .select2-container--bootstrap4 .select2-results__option[aria-disabled=true] {
        background-color: #e9ecef;
        /* Warna abu-abu terang */
        cursor: not-allowed;
        /* Mengubah kursor untuk menandakan tidak bisa diklik */
    }
</style>
<div class="row mt-3">
    <div class="col-lg-6 offset-lg-3 d-flex flex-column align-items-center">
        <h5><code>Admin Masuk Sebagai: <?= $pengajar['nama_pengajar'] ?></code></h5>
        <label for="inputTM"><code>Pilih TM untuk Pengisian Absensi</code></label>
        <select onchange="inputAbsensi(this.value);" class="form-control select2Search" name="inputTM" id="inputTM" style="width: 60%;">
            <option value="" selected disabled>--PILIH--</option>
            <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++) : ?>
                <option value="<?= $i ?>">TATAP MUKA <?= $i ?></option>
            <?php endfor; ?>
        </select>
        <small id="tmHint" class="text-muted mt-1"></small>
    </div>
</div>

<div class="table-responsive mt-3">
    <table id="datatable-absen" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="20%">NAMA</th>
                <th width="10%">JML. HADIR</th>
                <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++) : ?>
                    <th class="text-center"><?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($peserta_onkelas as $nomor => $data) : ?>
                <tr>
                    <td><?= $nomor + 1 ?></td>
                    <td><?= esc($data['nama']) ?></td>
                    <td class="text-center">
                        <?php
                        $totHadir = 0;
                        for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++) {
                            if (isset($data['naps' . $i]) && $data['naps' . $i]['tm'] == '1') {
                                $totHadir++;
                            }
                        }
                        echo $totHadir;
                        ?>
                    </td>
                    <?php for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++) : ?>
                        <td class="text-center">
                            <?php // IMPROVEMENT: Cleaner logic with ternary operator
                            if (isset($data['naps' . $i])) {
                                echo ($data['naps' . $i]['tm'] == '1')
                                    ? '<i style="color: green;" class="mdi mdi-check-bold" title="Hadir"></i>'
                                    : '<i style="color: red;" class="mdi mdi-minus" title="Tidak Hadir"></i>';
                            }
                            ?>
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<hr>

<h5>Absensi dan Catatan Pengajar</h5>

<?php
// Grouping data by TM is a good practice for structured display
$groupedByTM = [];
if (isset($absenTmNew) && !empty($absenTmNew)) {
    foreach ($absenTmNew as $record) {
        $tmNumber = $record['tm_sequence'];
        if (!isset($groupedByTM[$tmNumber])) {
            $groupedByTM[$tmNumber] = [];
        }
        $groupedByTM[$tmNumber][] = $record;
    }
    ksort($groupedByTM, SORT_NUMERIC); // Sort by TM number
}
?>

<div class="table-responsive mt-3">
    <table id="datatable-tm" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
        <thead>
            <tr>
                <th>TM</th>
                <th>TGL TM</th>
                <th>WAKTU ISI</th>
                <th>KELAS</th>
                <th>PENGISI</th>
                <th>METODE TM</th>
                <th>CATATAN</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($groupedByTM)) : ?>
                <?php foreach ($groupedByTM as $tmNumber => $tmRecords) : ?>
                    <?php foreach ($tmRecords as $record) : ?>
                        <tr>
                            <td class="text-center"><strong><?= esc($record['tm_sequence']) ?></strong></td>
                            <td><?= !empty($record['dt_tm']) ? shortdate_indo($record['dt_tm']) : '-' ?></td>
                            <td>
                                <?php if (!empty($record['dt_isi'])) : ?>
                                    <?= shortdate_indo(substr($record['dt_isi'], 0, 10)) ?>, <?= substr($record['dt_isi'], 11, 8) ?>
                                <?php else : ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?= esc($kelas['nk_nama']) ?></td>
                            <td><?= esc($record['by'] ?? '-') ?></td>
                            <td><?= esc($record['metode_ttm'] ?? '-') ?></td>
                            <td><?= !empty(trim($record['note'])) ? esc($record['note']) : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        <em>Belum ada data absensi dari pengajar.</em>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modalIsi"></div>
<div class="modalIsiNote"></div>

<script>
    // FIX: Consolidate all document ready functions into one for reliability.
    $(document).ready(function() {

        // Simple function to initialize DataTable with fixed first column
        function initDataTable(selector) {
            // Check if table exists
            if (!$(selector).length) return;

            // Destroy if already initialized
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().destroy();
            }

            try {
                $(selector).DataTable({
                    "scrollX": true,
                    "fixedColumns": {
                        "start": 1 // Fixed first column
                    },
                    "responsive": false,
                    "autoWidth": false,
                    "ordering": false,
                    "paging": false,
                    "searching": true,
                    "info": true
                });
            } catch (error) {
                console.error('DataTable init error:', error);
            }
        }

        // Initialize both tables with same configuration
        initDataTable('#datatable-absen');
        initDataTable('#datatable-tm');

        // Initialize Select2
        $('.select2Search').select2({
            theme: "bootstrap4"
        });

        // Setup sequential select
        setupSequentialSelect();
    });

    // --- DATA & CONSTANTS ---
    const pesertaData = <?= json_encode($peserta_onkelas ?? []) ?>;
    const maxTM = <?= $kelas['nk_tm_ambil'] ?? 0 ?>;
    const kelasId = "<?= $kelas['nk_id'] ?>";
    const npjId = "<?= $npjId  ?>"; // Use empty string if not set

    /**
     * Finds the highest meeting (TM) number that has been filled for any student.
     * @returns {number} The last filled TM number.
     */
    function findMaxFilledTM() {
        // Jika tidak ada data peserta, langsung kembalikan 0.
        if (!pesertaData || pesertaData.length === 0) {
            return 0;
        }

        // Gunakan array.reduce() untuk menemukan nilai TM maksimum dari semua peserta.
        return pesertaData.reduce((maxKeseluruhan, peserta) => {

            // 1. Dapatkan semua 'key' dari objek peserta (cth: "nama", "naps1", "naps10").
            const keysPeserta = Object.keys(peserta);

            // 2. Dari semua key itu, cari yang merupakan TM tertinggi UNTUK PESERTA INI SAJA.
            const maxTmPesertaIni = keysPeserta.reduce((maxLokal, key) => {
                // Cek apakah key adalah 'naps' dan datanya valid (objek).
                if (key.startsWith('naps') && typeof peserta[key] === 'object' && peserta[key] !== null) {
                    // Ekstrak nomor TM dari key (cth: "naps12" -> 12).
                    const tmNumber = parseInt(key.substring(4), 10);
                    // Kembalikan nilai yang lebih besar antara maxLokal saat ini dengan tmNumber yg baru ditemukan.
                    return Math.max(maxLokal, tmNumber);
                }
                // Jika bukan key 'naps', kembalikan maxLokal tanpa perubahan.
                return maxLokal;
            }, 0); // Nilai awal untuk maxLokal adalah 0.

            // 3. Kembalikan nilai yang lebih besar antara maxKeseluruhan sejauh ini dengan maxTmPesertaIni.
            return Math.max(maxKeseluruhan, maxTmPesertaIni);

        }, 0); // Nilai awal untuk maxKeseluruhan adalah 0.
    }

    /**
     * Configures the TM dropdown to only allow sequential filling.
     * It enables options up to the next unfilled TM and disables the rest.
     */
    function setupSequentialSelect() {
        const select = document.getElementById('inputTM');
        const hint = document.getElementById('tmHint');
        if (!select) return;

        const maxFilledTM = findMaxFilledTM();
        const nextTM = Math.min(maxFilledTM + 1, maxTM);
        const allFilled = maxFilledTM >= maxTM;

        if (allFilled) {
            select.disabled = true;
            // Use jQuery to update Select2 text
            $(select).find('option:first').text('-- SEMUA TM SUDAH TERISI --');
            if (hint) hint.textContent = 'Semua TM telah diisi lengkap. Terima kasih.';
            $(select).val(null).trigger('change'); // Reset selection
            return;
        }

        // Enable/disable options
        $('#inputTM option').each(function() {
            const tmValue = parseInt($(this).val());
            if (isNaN(tmValue)) return; // Skip the placeholder option

            const canSelect = tmValue <= nextTM;
            $(this).prop('disabled', !canSelect);
        });

        if (hint) hint.textContent = `Silakan lanjutkan pengisian untuk TM ${nextTM}.`;

        // Refresh Select2 to apply changes
        $(select).select2({
            theme: "bootstrap4"
        });
    }

    /**
     * Handles the AJAX request to open the attendance input modal.
     * @param {string|number} tm - The Tatap Muka (TM) number selected.
     */
    function inputAbsensi(tm) {
        if (!tm) return;

        $.ajax({
            type: "POST",
            url: "<?= site_url('absensi-nonreg/input') ?>",
            data: {
                nk_id: kelasId,
                npj_id: npjId,
                tm: tm,
            },
            dataType: "json",
            beforeSend: function() {
                // Optional: Show a loading indicator
            },
            success: function(response) {
                if (response.sukses) {
                    $('.modalIsi').html(response.sukses).show();
                    $('#modaltm').modal('show');
                } else {
                    // IMPROVEMENT: Handle cases where 'sukses' is not returned
                    Swal.fire('Error', response.error || 'Gagal memuat data modal.', 'error');
                }
            },
            error: function(xhr, status, error) {
                // IMPROVEMENT: Better error handling
                console.error("AJAX Error:", error);
                Swal.fire('Terjadi Kesalahan', 'Tidak dapat menghubungi server. Silakan coba lagi nanti.', 'error');
            }
        });
    }

    // This function seems unused in the main table but is kept for completeness
    // function inputNote(absen_pesertaId) {
    //     $.ajax({
    //         type: "POST",
    //         url: "<?= site_url('/pengajar/absensi-note') ?>",
    //         data: {
    //             absen_pesertaId: absen_pesertaId,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.sukses) {
    //                 $('.modalIsiNote').html(response.sukses).show();
    //                 $('#isiNote').modal('show');
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error("AJAX Error:", error);
    //             Swal.fire('Terjadi Kesalahan', 'Gagal memuat catatan.', 'error');
    //         }
    //     });
    // }
</script>

<?= $this->endSection('isi') ?>