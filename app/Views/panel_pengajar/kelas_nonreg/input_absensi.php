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
                    <label class="form-label">TANGGAL </label>
                    <div class="input-group" id="datepicker2">
                        <input type="text" id="dt_tm" name="dt_tm" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                            data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                            data-provide="datepicker" data-date-autoclose="true" <?php if (isset($absenTm)) { ?> value="<?= $absenTm['dt_tm'] ?>" <?php } ?> <?php if (!isset($absenTm)) { ?> value="<?= date('Y-m-d') ?>" <?php } ?> required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                    </div>
                    <div id="date-error" class="text-danger"></div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">CATATAN</label>
                    <textarea class="form-control" id="note" name="note" rows="4"><?php if (isset($absenTm)) { ?><?= $absenTm['note'] ?> <?php } ?></textarea>
                </div>
                <hr>
                <style>
                    .table-responsive {
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

                <div class="table-responsive">
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
                <button type="submit" id="save" name="save" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
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
</script>