<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> <?= $detail_kelas['nk_nama'] ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<a href="<?= base_url('kelas-nonreg') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<div class="mb-3">
    <h5 style="text-align:center;">Kelas <?= $detail_kelas['nk_nama'] ?></h5>
    <h6 style="text-align:center;"><?= $detail_kelas['nk_hari'] ?>, <?= $detail_kelas['nk_waktu'] ?> <?= $detail_kelas['nk_timezone'] ?></h6>
    <h6 style="text-align:center;">Pengajar = <?= $pengajar['nama_pengajar'] ?></h6> 
    <h6 style="text-align:center;">Jumlah Peserta = <?= $jumlah_peserta ?></h6> 
</div>
<hr>

<div class="row">
    
    <div class="col-md-6">
        <div class="card card-body shadow-lg">
            <div class="card-title">
                <h6>PIC & Info Kelas</h6>
                <hr>
            </div>
            <div class="card-text">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td width="40%"><b>NIK</b></td>
                            <td><?= $detail_kelas['nk_id'] ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Nama</b></td>
                            <td><?= $detail_kelas['nk_pic_name'] ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><b>No. HP</b></td>
                            <td><?= $detail_kelas['nk_pic_hp'] ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Akses Edit Peserta</b></td>
                            <td>
                                <?php if($detail_kelas['nk_pic_otoritas'] == 0) { ?>
                                    <i style="color: red;" class="fa fa-ban"> TIDAK</i> 
                                <?php } ?>
                                <?php if($detail_kelas['nk_pic_otoritas'] == 1) { ?>
                                    <i style="color: green;" class="fa fa-check"> BISA</i>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Lokasi Kelas</b></td>
                            <td><?= $detail_kelas['nk_lokasi'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-body shadow-lg">
            <div class="card-title">
                <h6>Level Peserta</h6>
                <hr>
            </div>
            <div class="card-text">
                <button type="button" class="btn btn-warning mb-3" onclick="showModalLevel('<?= $detail_kelas['nk_id'] ?>')"><i class="fa fa-edit"></i> Edit Level</button>
                <table class="table table-bordered table-sm">
                    <tbody>
                        <?php foreach ($level as $data) : ?>
                            <tr>
                                <td><?= $data['nama_level'] ?></td>
                                <td><button class="btn btn-danger btn-sm" onclick="hapusLevel(event,'<?= $data['nkl_id'] ?>')"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>                            
    </div>
</div>

<div class="table-responsive">
    <button type="button" class="btn btn-primary mb-3" onclick="showAddQuotaModal('<?= $detail_kelas['nk_id'] ?>')"><i class="fa fa-plus-circle"></i> Tambah Kuota Peserta</button>

    <form id="save_form" action="<?= base_url('/kelas-nonreg/save-peserta') ?>" method="post">
        <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Peserta</th>
                    <td style="display: none;">ID</td>
                    <th>Level</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php $nomor = 0;
                foreach ($peserta_onkelas  as $index => $row) :
                    $nomor++; ?>
                    <tr data-row-id="<?= $index ?>">
                        <td width="5%"><?= $nomor ?></td>
                        <td width="15%" contenteditable="true" class="text-uppercase"><?= $row['np_nama'] ?></td>
                        <td style="display: none;"><?= $row['np_id'] ?></td>
                        <td width="15%">
                            <select name="np_level" id="np_level<?= $row['np_id'] ?>" required>
                                <option value="0" <?php if ($row['np_level'] == NULL || $row['np_level'] == "0") echo "selected"; ?> >BELUM DITENTUKAN</option>
                                <?php foreach ($level as $key => $data) { ?>
                                    <option value="<?= $data['peserta_level_id'] ?>" <?php if ($row['np_level'] == $data['peserta_level_id']) echo "selected"; ?> ><?= $data['nama_level'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td width="5%">
                            <button class="btn btn-danger btn-sm" onclick="hapus(event,'<?= $row['np_id'] ?>')"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>

                    <script>
                        $(document).ready(function () {
                            $('#np_level<?= $row['np_id'] ?>').select2({
                                minimumResultsForSearch: -1
                            });
                        });
                    </script>

                <?php endforeach; ?>
            </tbody>
        </table>
        <input type="hidden" name="data" id="data_input">
        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Simpan</button>
    </form>
</div>

<div class="viewmodal">
</div>

<div class="viewmodaledit">
</div>

<script>

    $('#save_form').on('submit', function(e) {
        e.preventDefault();

        // Show loading spinner while processing
        var loadingSpinner = Swal.fire({
            title: 'Loading...',
            text: 'Harap tunggu',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Get the table data
        var tableData = [];
        $('#datatable tbody tr').each(function() {
            var rowData = {};

            // Iterate through the cells in the current row
            $(this).find('td').each(function(index, element) {
                var columnName = 'column_' + index;

                // If the cell contains a select element, get the selected value
                if ($(this).find('select').length > 0) {
                    rowData[columnName] = $(this).find('select').val();
                } else {
                    // Otherwise, get the text content
                    rowData[columnName] = $(this).text().trim();
                }
            });

            tableData.push(rowData);
        });

        // Prepare the form data
        var formData = new FormData();
        formData.append('data', JSON.stringify(tableData));

        // Submit the form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                // Close loading spinner
                loadingSpinner.close();

                if (response.success == true) {
                    // Show SweetAlert 2 with the success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                        allowOutsideClick: false,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });
                } else {
                    // Show SweetAlert 2 with the error message
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: response.message,
                        allowOutsideClick: false,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });
                }
            },
            error: function(response) {
                // Close loading spinner
                loadingSpinner.close();

                // Show SweetAlert 2 with the error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi Error Dalam Proses Simpan Data.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/kelas-nonreg/detail?id=<?= $detail_kelas['nk_id'] ?>';
                    }
                });
            }
        });
    });

    function showAddQuotaModal(nk_id) {
        const maxQuota = 25;

        Swal.fire({
            title: 'Tambah Kuota Peserta',
            html: `<input type="number" id="nk_peserta_add" class="swal2-input" min="1" max="${maxQuota}">`,
            showCancelButton: true,
            confirmButtonText: 'Tambah',
            preConfirm: () => {
                const nk_peserta_add = Swal.getPopup().querySelector('#nk_peserta_add').value;
                if (!nk_peserta_add || nk_peserta_add < 1 || nk_peserta_add > maxQuota) {
                    Swal.showValidationMessage(`Nilai harus antara 1 dan ${maxQuota}`);
                    return false;
                }
                return { nk_peserta_add: nk_peserta_add };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                addQuota(nk_id, result.value.nk_peserta_add);
            }
        });
    }

    function addQuota(nk_id, nk_peserta_add) {
        Swal.fire({
            title: 'Processing...',
            text: 'Please wait',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '/kelas-nonreg/add-kuota',
            type: 'POST',
            data: {
                nk_id: nk_id,
                nk_peserta_add: nk_peserta_add
            },
            success: function(response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Anda berhasil menambah kuota!",
                        icon: "success",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                        confirmButtonText: 'Ya',
                        confirmButtonColor: '#3085d6',
                    }).then(function() {
                        window.location.reload();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan, coba lagi.'
                });
            }
        });
    }

    function hapus(e,np_id) {
        e.preventDefault();
        e.stopPropagation();
        Swal.fire({
            title: 'Yakin Mengurangi Kuota dan Hapus Data Terpilih?',
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('/kelas-nonreg/delete-peserta') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        np_id : np_id,
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil mengurangi kuota!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location = response.sukses.link;
                        });
                        }
                    }
                });
            }
        })
    }

    function showModalLevel(nk_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-nonreg/edit-level') ?>",
            data: {
                nk_id : nk_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaledit').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function hapusLevel(e,nkl_id) {
        e.preventDefault();
        e.stopPropagation();
        Swal.fire({
            title: 'Yakin Menghapus Level Ini?',
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('/kelas-nonreg/delete-level') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        nkl_id : nkl_id,
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus level!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location = response.sukses.link;
                        });
                        }
                    }
                });
            }
        })
    }
</script>

<?= $this->endSection('isi') ?>