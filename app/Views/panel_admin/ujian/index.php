<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <div class="col-sm-auto mb-2">
        <label for="absen_pilih">Export Excel (Download)</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="absen_pilih" id="absen_pilih" class="js-example-basic-single mb-2">
            <option value="" disabled selected>Download...</option>
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/ujian/export?angkatan=<?= $data['angkatan_kelas'] ?>"> Angkatan Kuliah <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <div class="col-sm-auto mb-2">
        <label for="angkatan_kelas">Pilih Angkatan Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="angkatan_kelas" id="angkatan_kelas" class="js-example-basic-single mb-2">
            <?php foreach ($list_angkatan as $key => $data) { ?>
            <option value="/ujian?angkatan=<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan_pilih == $data['angkatan_kelas']) echo "selected"; ?>> <?= $data['angkatan_kelas'] ?> </option>
            <?php } ?>
        </select>
    </div>
    <a class="ml-5"> 
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#importexcel" ><i class=" fa fa-file-excel"></i> Import File Excel</button>
    </a>
</div>

<?php
if (session()->getFlashdata('pesan_error')) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <strong>';
    echo session()->getFlashdata('pesan_error');
    echo ' </strong> </div>';
}
?>

<?php
if (session()->getFlashdata('pesan_sukses')) {
    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <strong>';
    echo session()->getFlashdata('pesan_sukses');
    echo ' </strong> </div>';
}
?>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>Peserta</th>
                <th>Jenis <br> Kelamin</th>
                <th>Kelas</th>
                <th>Angkatan <br> Perkuliahan</th>
                <th>Pengajar</th>
                <th>Hari <br> Kelas</th>
                <th>Waktu <br> Kelas</th>
                <th>Tgl. <br> Ujian</th>
                <th>Waktu <br> Ujian</th>
                <th>Nilai <br> Ujian</th>
                <th>Nilai <br> Akhir</th>
                <th>Rekom <br> Level Lanjut</th>
                <th>Kelulusan</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="1%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['nis'] ?></td>
                    <td width="12%"><?= $data['nama_peserta'] ?></td>
                    <td width="5%"><?= $data['jenkel'] ?></td>
                    <td width="12%"><?= $data['nama_kelas'] ?></td>
                    <td width="3%"><?= $data['angkatan_kelas'] ?></td>
                    <td width="4%"><?= $data['nama_pengajar'] ?></td>
                    <td width="3%"><?= $data['hari_kelas'] ?></td>
                    <td width="3%"><?= $data['waktu_kelas'] ?> <?= $data['zona_waktu_kelas'] ?></td>
                    <td width="3%">
                        <?php if($data['tgl_ujian'] != NULL) { ?>
                            <?= shortdate_indo($data['tgl_ujian']) ?>
                        <?php } ?>
                    </td>
                    <td width="3%"><?= $data['waktu_ujian'] ?></td>
                    <td width="3%"><?= $data['nilai_ujian'] ?></td>
                    <td width="3%"><?= $data['nilai_akhir'] ?></td>
                    <td width="3%"><?= $data['next_level'] ?></td>
                    <td width="5%">
                        <?php if($data['status_peserta_kelas'] == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'MENGULANG') { ?>
                            <button class="btn btn-warning btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    </td>
                    <td> <button type="button" class="btn btn-warning" onclick="edit(<?= $data['ujian_id'] ?>, <?= $data['peserta_id'] ?>, <?= $data['kelas_id'] ?>, <?= $data['peserta_kelas_id'] ?>)" > <i class="fa fa-edit"></i> Edit</button> </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodaldataedit">
</div>

<!-- Start Modal Import File Excel -->
<div class="modal fade" id="importexcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import File Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('/ujian/import');
            ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Data import Excel maximal berisi 300 Data/Baris. Jika lebih maka data selebihnya akan gagal ter-import ke dalam sistem.<br>
                    <i class="mdi mdi-information"></i> Data yang diproses pada menu import ini hanya data <b>Tgl Ujian, Waktu Ujian, Nilai Ujian, Nilai Akhir, Kelulusan.</b><br>
                    <i class="mdi mdi-information"></i> Harap Diperhatikan ketika import menggunakan excel <b>Tgl Ujian</b> harus berformat <b>Tahun-Bulan-Tgl (YYYY-MM-DD)</b> dan <b>Waktu Ujian</b> harus berformat <b>Jam:Menit:Detik (HH:MM:SS)</b>.<br>
                    <i class="mdi mdi-information"></i> Contoh penulisan Tgl Ujian dan Waktu Ujian yang benar adalah Tgl Ujian = 2021-11-21 dan Waktu Ujian 18:30:00<br>
                    <i class="mdi mdi-information"></i> Level diisi dengan nama Level rekomendasi dengan huruf kapital, cth: TAJWIDI.<br>
                    <i class="mdi mdi-information"></i> Penulisan Nilai Ujian dan Nilai Akhir menggunakan angka dan status kelulusan menggunakan format huruf kapital, cth: LULUS.<br>
                    <i class="mdi mdi-information"></i> Jika penulisan tidak sesuai format maka data akan gagal terexport.<br>
                </p>
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" class="form-control" name="file_excel" accept=".xls, .xlsx">
                    </div>
            </div>    
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan"><i class="fa fa-file-upload"></i> Import</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?php echo form_close() ?>
        </div>
    </div>
</div>
<!-- End Modal Import File Excel -->

<script>
    $('#angkatan_kelas').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    $('#absen_pilih').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    function edit(ujian_id, peserta_id, kelas_id, peserta_kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('ujian/edit') ?>",
            data: {
                ujian_id : ujian_id,
                peserta_id : peserta_id,
                kelas_id : kelas_id,
                peserta_kelas_id : peserta_kelas_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaldataedit').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>