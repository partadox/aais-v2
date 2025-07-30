<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row mb-3">
    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
        <label for="tahun_filter">Filter Tampilan (Pilih Tahun)</label>
        <select class="form-control js-example-basic-single" name="tahun_filter" id="tahun_filter">
            <option value="" disabled selected>Pilih Tahun</option>
            <?php foreach ($list_tahun as $key => $data) { ?>
                <option value="<?= $data['nk_tahun'] ?>" <?php if ($tahun_pilih == $data['nk_tahun']) echo "selected"; ?>>
                    <?= $data['nk_tahun'] ?>
                </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Export Data Excel</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <label for="tahun_export">Pilih Tahun <span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" name="tahun_export" id="tahun_export">
                            <option value="" disabled selected>Pilih Tahun</option>
                            <?php foreach ($list_tahun as $key => $data) { ?>
                                <option value="<?= $data['nk_tahun'] ?>">Tahun <?= $data['nk_tahun'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <label for="bulan_export">Pilih Bulan <span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" name="bulan_export" id="bulan_export" disabled>
                            <option value="" disabled selected>Pilih Tahun Terlebih Dahulu</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <label for="jenis_data">Pilih Data Berdasarkan Tanggal<span class="text-danger">*</span></label>
                        <select class="form-control js-example-basic-single" name="jenis_data" id="jenis_data">
                            <option value="tm" selected>TM</option>
                            <option value="input">Input</option>
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-success btn-block" id="btn_export" disabled>
                            <i class="mdi mdi-download"></i> Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Pengajar</th>
                <th>NIK Kelas</th>
                <th>Kelas</th>
                <th>Tahun</th>
                <th>Total Hadir</th>
                <th>Catatan</th>
                <?php for ($i = 1; $i <= $highest_tm_ambil; $i++): ?>
                    <th><?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($processed_lists as $data) :
                $nomor++; ?>
                <tr>
                    <td width="1%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['nama_pengajar'] ?></td>
                    <td width="10%"><?= $data['nk_id'] ?></td>
                    <td width="10%"><?= $data['nk_nama'] ?></td>
                    <td width="10%"><?= $data['nk_tahun'] ?></td>
                    <td width="10%">
                        <?php $totHadir = 0;
                        for ($i = 1; $i <= $highest_tm_ambil; $i++): ?>
                            <?php if (isset($data['napj' . $i])) { ?>
                                <?php if ($data['napj' . $i]['tm'] == '1') {
                                    $totHadir = $totHadir + 1; ?>
                                <?php } ?>
                            <?php } ?>
                        <?php endfor; ?>
                        <?= $totHadir ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info mb-2" onclick="catatan(<?= $data['napj_id'] ?>)">
                            <i class=" fa fa-file mr-1"></i>Catatan</button>
                    </td>
                    <?php for ($i = 1; $i <= $highest_tm_ambil; $i++): ?>
                        <td>
                            <?php if (isset($data['napj' . $i])) { ?>
                                <?php if ($data['napj' . $i]['tm'] == '1') { ?>
                                    <i style="color: green;" class="mdi mdi-check-bold"></i>
                                <?php } ?>
                                <?php if ($data['napj' . $i]['tm'] == '0') { ?>
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

<div class="viewmodalcatatan">
</div>

<script>
    // Daftar bulan untuk dropdown
    const months = [{
            value: 'all',
            text: 'SEMUA'
        },
        {
            value: '01',
            text: 'Januari'
        },
        {
            value: '02',
            text: 'Februari'
        },
        {
            value: '03',
            text: 'Maret'
        },
        {
            value: '04',
            text: 'April'
        },
        {
            value: '05',
            text: 'Mei'
        },
        {
            value: '06',
            text: 'Juni'
        },
        {
            value: '07',
            text: 'Juli'
        },
        {
            value: '08',
            text: 'Agustus'
        },
        {
            value: '09',
            text: 'September'
        },
        {
            value: '10',
            text: 'Oktober'
        },
        {
            value: '11',
            text: 'November'
        },
        {
            value: '12',
            text: 'Desember'
        }
    ];

    $(document).ready(function() {
        // Initialize Select2
        $('.js-example-basic-single').select2();

        // Filter tahun untuk tampilan
        $('#tahun_filter').on('change', function() {
            const tahun = $(this).val();
            if (tahun) {
                window.location.href = '/absensi-nonreg/pengajar?tahun=' + tahun;
            }
        });

        // Export tahun selection
        $('#tahun_export').on('change', function() {
            const tahun = $(this).val();
            const bulanSelect = $('#bulan_export');
            const btnExport = $('#btn_export');

            if (tahun) {
                // Enable bulan dropdown
                bulanSelect.prop('disabled', false);
                bulanSelect.empty();
                bulanSelect.append('<option value="" disabled selected>Pilih Bulan</option>');

                // Populate bulan options
                months.forEach(function(month) {
                    bulanSelect.append('<option value="' + month.value + '">' + month.text + '</option>');
                });

                // Reinitialize Select2 for bulan dropdown
                bulanSelect.select2();
            } else {
                // Disable bulan dropdown and export button
                bulanSelect.prop('disabled', true);
                bulanSelect.empty();
                bulanSelect.append('<option value="" disabled selected>Pilih Tahun Terlebih Dahulu</option>');
                btnExport.prop('disabled', true);
            }
        });

        // Bulan selection
        $('#bulan_export').on('change', function() {
            const bulan = $(this).val();
            const btnExport = $('#btn_export');

            if (bulan) {
                btnExport.prop('disabled', false);
            } else {
                btnExport.prop('disabled', true);
            }
        });

        // Export button click
        $('#btn_export').on('click', function() {
            const tahun = $('#tahun_export').val();
            const bulan = $('#bulan_export').val();
            const jenisData = $('#jenis_data').val();

            if (!tahun || !bulan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Mohon pilih tahun dan bulan terlebih dahulu.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Show loading alert
            Swal.fire({
                title: 'Memproses Export...',
                text: 'Mohon tunggu, sedang memproses data export Excel.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Construct export URL
            const exportUrl = '/absensi-nonreg/pengajar-export?tahun=' + tahun + '&bulan=' + bulan + '&jenis-data=' + jenisData;

            // Create hidden iframe for download
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = exportUrl;
            document.body.appendChild(iframe);

            // Close loading after a short delay (adjust as needed)
            setTimeout(function() {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Export Excel berhasil diunduh.',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Remove iframe after download
                setTimeout(function() {
                    document.body.removeChild(iframe);
                }, 1000);
            }, 2000);
        });
    });

    function catatan(napj_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/absensi-nonreg/pengajar-note') ?>",
            data: {
                napj_id: napj_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalcatatan').html(response.sukses).show();
                    $('#modalcatatan').modal('show');
                }
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>