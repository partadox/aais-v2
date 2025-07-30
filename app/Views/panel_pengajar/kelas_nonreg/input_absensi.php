<!-- Modal -->
<div class="modal fade" id="modaltm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?= form_open('/pengajar/save-absensi-nonreg', ['class' => 'formtambah',  'enctype' => 'multipart/form-data']) ?>
            <?= csrf_field(); ?>
            <input type="hidden" name="tm" value="<?= $tm ?>">
            <input type="hidden" name="kelasId" value="<?= $kelas['nk_id'] ?>">
            <input type="hidden" name="napjId" value="<?= $absenKelas['napj_id'] ?>">
            <div class="modal-body">
                <h5> <u>Pengajar: <?= $pengajar['nama_pengajar'] ?></u> </h5>
                <div class="form-group mb-3">
                    <label class="form-label">KELAS</label>
                    <input type="text" class="form-control" value="<?= $kelas['nk_nama'] ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">TANGGAL</label>
                    <div class="input-group" id="datepicker2">
                        <input type="text"
                            id="dt_tm"
                            name="dt_tm"
                            class="form-control"
                            placeholder="Tahun-Bulan-Tanggal"
                            data-date-format="yyyy-mm-dd"
                            data-date-container='#datepicker2'
                            data-provide="datepicker"
                            data-date-autoclose="true"
                            readonly
                            <?php if (isset($absenTm)) { ?>
                            value="<?= $absenTm['dt_tm'] ?>"
                            <?php } else { ?>
                            value="<?= date('Y-m-d') ?>"
                            <?php } ?>
                            required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="mdi mdi-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div id="date-error" class="text-danger"></div>
                </div>

                <div class="form-group mb-3">
                    <label for="" class="form-label">METODE TTM <code>*</code></label>
                    <select class="form-control btn-square" id="metode_ttm" name="metode_ttm">
                        <option value="OFFLINE" <?php if (isset($absenTm) & isset($absenTM['metode_ttm']) && $absenTM['metode_ttm'] == 'OFFLINE') { ?> selected <?php } ?>>OFFLINE</option>
                        <option value="ONLINE" <?php if (isset($absenTm) & isset($absenTM['metode_ttm']) && $absenTM['metode_ttm'] == 'ONLINE') { ?> selected <?php } ?>>ONLINE</option>
                    </select>
                </div>

                <!-- <div class="form-group mb-3">
                    <label for="" class="form-label">AKTIVITAS <code>*</code></label>
                    <select class="form-control btn-square" id="aktivitas" name="aktivitas">
                        <option value="MENGAJAR NON-REGULER" <?php if (isset($absenTm) & isset($absenTM['aktivitas']) && $absenTM['aktivitas'] == 'MENGAJAR NON-REGULER') { ?> selected <?php } ?>>MENGAJAR NON-REGULER</option>
                        <option value="MENGAJAR REGULER" <?php if (isset($absenTm) & isset($absenTM['aktivitas']) && $absenTM['aktivitas'] == 'MENGAJAR REGULER') { ?> selected <?php } ?> disabled>MENGAJAR REGULER</option>
                    </select>
                </div> -->

                <div class="form-group mb-3">
                    <label class="form-label">CATATAN</label>
                    <textarea class="form-control" id="note" name="note" rows="4"><?php if (isset($absenTm)) { ?><?= $absenTm['note'] ?> <?php } ?></textarea>
                </div>
                <hr>
                <style>
                    .table-responsive-md {
                        max-height: 300px;
                    }

                    .wrapper {
                        position: relative;
                    }

                    .overlay th {
                        position: absolute;
                        top: 0;
                    }
                </style>

                <h5> <u>Peserta</u></h5>

                <div class="table-responsive-md">
                    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th width="2%">No.</th>
                                <th width="20%" class="name-col">Nama</th>
                                <th width="4%" bgcolor="#87de9d">Hadir </th>
                                <th width="4%" bgcolor="#de8887">Tidak Hadir </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $counter = 0;
                            foreach ($listAbsensi as $data) :
                                $counter++;
                                $isChecked = '';
                            ?>
                                <tr>
                                    <td><?= $counter ?></td>
                                    <td>
                                        <?= $data['nama'] ?>
                                        <input type="hidden" name="arNp[]" value="<?= $data['np_id'] ?>">
                                        <input type="hidden" name="arNaps[]" value="<?= $data['naps_id'] ?>">
                                    </td>
                                    <td>
                                        <input type="radio" name="cek<?= $data['naps_id'] ?>" value="1"
                                            <?php if (isset($data['naps' . $tm])) { ?>
                                            <?php if ($data['naps' . $tm]['tm'] == '1') { ?>
                                            checked
                                            <?php } ?>
                                            <?php if ($data['naps' . $tm]['tm'] == '0') { ?>
                                            <?php } ?>
                                            <?php } ?>>
                                    </td>
                                    <td>
                                        <input type="radio" name="cek<?= $data['naps_id'] ?>" value="0"
                                            <?php if (isset($data['naps' . $tm])) { ?>
                                            <?php if ($data['naps' . $tm]['tm'] == '0') { ?>
                                            checked
                                            <?php } ?>
                                            <?php } ?>
                                            <?php if (!isset($data['naps' . $tm])) { ?>
                                            checked
                                            <?php } ?>>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                if (isset($absenTm['dt_tm']) && date('Y-m', strtotime($absenTm['dt_tm'])) < date('Y-m')) { ?>
                    <button class="btn btn-secondary" disabled><i class="fa fa-lock"></i></button>
                <?php } else { ?>
                    <button type="submit" id="save" name="save" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <?php } ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Get existing dates from the data passed from backend
    //     const existingDates = <?= json_encode($existing_dates) ?>;
    //     const dateInput = document.getElementById('dt_tm');
    //     const dateForm = dateInput.closest('form');

    //     dateForm.addEventListener('submit', function(e) {
    //         const selectedDate = dateInput.value;

    //         // Check if the date already exists
    //         if (existingDates.includes(selectedDate)) {
    //             e.preventDefault();
    //             document.getElementById('date-error').textContent = 'Tanggal ini sudah ada. Silakan pilih tanggal lain.';
    //         } else {
    //             document.getElementById('date-error').textContent = '';
    //         }
    //     });

    //     // Clear error when the date changes
    //     dateInput.addEventListener('change', function() {
    //         document.getElementById('date-error').textContent = '';
    //     });
    // });
    $(document).ready(function() {
        $(".formtambah").submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin semua isian absensi sudah benar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e1be0d',
                cancelButtonColor: '#aba2a2',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    // User clicked "Simpan", proceed with form submission
                    var loadingSpinner = Swal.fire({
                        title: 'Loading...',
                        text: 'Harap tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    var formData = new FormData($(this)[0]);
                    $.ajax({
                        type: "post",
                        url: $(this).attr("action"),
                        data: formData,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $("#save").attr("disabled", true);
                            $("#save").html('<span class="mdi mdi-18px mdi-spin mdi-loading" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                        },
                        success: function(response) {
                            // Close loading spinner
                            loadingSpinner.close();

                            if (response.success == false) {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.message,
                                    icon: "error",
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonColor: '#e1be0d',
                                    timer: 9000,
                                });
                            }

                            if (response.success == true) {
                                Swal.fire({
                                    title: response.data.title,
                                    text: response.message,
                                    icon: response.data.icon,
                                    allowOutsideClick: false,
                                    showConfirmButton: true,
                                    confirmButtonColor: '#e1be0d',
                                    timer: 1250,
                                }).then(function() {
                                    window.location = response.data.link;
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Close loading spinner
                            loadingSpinner.close();
                            Swal.fire({
                                title: "Error!",
                                text: "Terjadi kesalahan dalam request.",
                                icon: "error",
                                allowOutsideClick: false,
                                showConfirmButton: true,
                                confirmButtonColor: '#e1be0d',
                                timer: 9000,
                            });
                        },
                        complete: function() {
                            // This part is removed from here
                            $("#save").removeAttr("disabled", false);
                            $("#save").html("Simpan");
                        },
                    });
                }
            });
        });

    });

    $(document).ready(function() {
        // Dapatkan tanggal hari ini
        var today = new Date();
        var currentYear = today.getFullYear();
        var currentMonth = today.getMonth();

        // Fungsi helper untuk format tanggal
        function formatDate(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        // Tentukan tanggal awal dan akhir (hanya bulan dan tahun yang sama)
        var startDate = new Date(currentYear, currentMonth, 1); // Tanggal 1 bulan ini
        var endDate = new Date(currentYear, currentMonth + 1, 0); // Tanggal terakhir bulan ini

        // Buat array tanggal yang diizinkan (seluruh bulan ini)
        var availableDatesArray = [];
        var lastDayCurrentMonth = endDate.getDate();

        for (var i = 1; i <= lastDayCurrentMonth; i++) {
            availableDatesArray.push(formatDate(new Date(currentYear, currentMonth, i)));
        }

        // Inisialisasi datepicker
        $('#dt_tm').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            language: 'id', // opsional, untuk bahasa Indonesia
            startDate: startDate,
            endDate: endDate,
            orientation: 'bottom auto',
            beforeShowDay: function(date) {
                var dateString = formatDate(date);
                // Return true jika tanggal ada dalam array tanggal yang diizinkan
                return availableDatesArray.indexOf(dateString) !== -1;
            }
        });

        // Mencegah input manual
        $('#dt_tm').on('keydown keypress keyup', function(e) {
            e.preventDefault();
            return false;
        });

        // Mencegah paste
        $('#dt_tm').on('paste', function(e) {
            e.preventDefault();
            return false;
        });

        // Fokus ke datepicker ketika input diklik
        $('#dt_tm').on('focus click', function() {
            $(this).datepicker('show');
        });

        // Validasi tambahan saat tanggal berubah
        $('#dt_tm').on('changeDate', function(e) {
            var selectedDate = e.date;
            var selectedDateString = formatDate(selectedDate);

            // Clear error message
            $('#date-error').text('');

            // Validasi apakah tanggal yang dipilih ada dalam daftar yang diizinkan
            if (availableDatesArray.indexOf(selectedDateString) === -1) {
                var currentMonthName = new Date(currentYear, currentMonth, 1).toLocaleDateString('id-ID', {
                    month: 'long',
                    year: 'numeric'
                });
                var errorMessage = 'Hanya dapat memilih tanggal dalam bulan ' + currentMonthName + '.';
                $('#date-error').text(errorMessage);
                $(this).val(''); // Clear invalid date
            }
        });
    });
</script>