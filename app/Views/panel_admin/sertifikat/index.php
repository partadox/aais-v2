<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="row">
    <!-- <div class="col-sm-auto mb-2">
        <label for="exportSertifikat">Export Excel (Download)</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single  mb-2" name="exportSertifikat" id="exportSertifikat">
            <option value="" disabled selected>--Pilih--</option>
            <?php foreach ($list_periode as $key => $data) { ?>
            <option value="/sertifikat/export?angkatan=<?= $data['periode_cetak'] ?>">Download </option>
            <?php } ?>
        </select>
    </div> -->

    <!-- <div class="col-sm-auto ml-4 mb-2">
        <label for="angkatan_kelas">Pilih Periode Cetak Sertifikat</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="periode_cetak" id="periode_cetak" class="js-example-basic-single mb-2">
            <?php foreach ($list_periode as $key => $data) { ?>
            <option value="/sertifikat?periode=<?= $data['periode_cetak'] ?>" <?php if ($periode_pilih == $data['periode_cetak']) echo "selected"; ?> > <?= $data['periode_cetak'] ?> </option>
            <?php } ?>
        </select>
    </div> -->

    <!-- <a class="ml-5"> 
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#importexcel" ><i class=" fa fa-file-excel"></i> Import File Excel</button>
    </a> -->
    <div class="col-sm-auto">
        <a type="button" class="btn btn-success mb-3" href="/sertifikat/export?angkatan=1" ><i class="fa fa-file-excel"></i> Export</a>
    </div>

    <div class="col-sm-auto">
        <button type="button" class="btn btn-warning mb-3" onclick="AturSertifikat('')" ><i class="fa fa-screwdriver"></i> Pengaturan Menu Sertifikat</button>
    </div>
    
</div>

<!-- <p class="mt-1">Catatan :<br> 
    <i class="mdi mdi-information"></i> Status Cetak <b>"Proses"</b> = Sudah bayar dan input form tapi belum dikonfirmasi admin. <br>
    <i class="mdi mdi-information"></i> Status Cetak <b>"Terkonfirmasi"</b> = Sudah bayar sudah dikonfirmasi admin, hanya tinggal dilakukan proses pembuatan sertifikat dan upload link download. <br>
</p> -->

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
                <th>Nomor Sertifikat</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jenis <br> Kelamin</th>
                <th>Program</th>
                <th>Tgl Sertifikat</th>
                <th>Status <br> Sertifikat</th>
                <th>Biaya</th>
                <th>Transaksi ID</th>
                <th>Keterangan</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="1%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['nomor_sertifikat'] ?></td>
                    <td width="5%"><?= $data['nis'] ?></td>
                    <td width="10%"><?= $data['nama_peserta'] ?></td>
                    <td width="5%"><?= $data['jenkel'] ?></td>
                    <td width="4%"><?= $data['nama_program'] ?></td>
                    <td width="4%"><?= $data['sertifikat_tgl'] ?></td>
                    <td width="5%">
                        <?php if($data['status'] == 0) { ?>
                            <button class="btn btn-warning btn-sm" disabled>Proses</button> 
                        <?php } ?>
                        <?php if($data['status'] == 1) { ?>
                            <button class="btn btn-success btn-sm" disabled>Terkonfirmasi</button> 
                        <?php } ?>
                    </td>
                    <td width="5%">Rp <?= rupiah($data['nominal_bayar_cetak']) ?></td>
                    <td width="5%"><?= $data['bukti_bayar_cetak'] ?></td>
                    <td width="10%">
                        <?= $data['keterangan_cetak'] ?>
                    </td>
                    <td width="5%"> 
                            <?php if($data['status'] == 1) { ?>
                                <button class="btn btn-info mt-2" onclick="modal('show','<?= $data['sertifikat_id'] ?>')"> <i class="mdi mdi-certificate"></i> e-Sertifikat</button> <br>
                                <!-- <button class="btn btn-warning mt-2" onclick="modal('edit','<?= $data['sertifikat_id'] ?>')"> <i class="fa fa-edit"></i> Edit</button>  <br> -->
                            <?php } ?>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodalkonfirmasi">
</div>

<div class="viewmodal">
</div>

<div class="viewmodalatur">
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
            <?php echo form_open_multipart('/sertifikat/import');
            ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Data import Excel maximal berisi 300 Data/Baris. Jika lebih maka data selebihnya akan gagal ter-import ke dalam sistem.<br>
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

<script>
    $('#periode_cetak').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });

    function AturSertifikat() {
        $.ajax({
            type: "post",
            url: "<?= site_url('/sertifikat/input-atur') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalatur').html(response.sukses).show();
                    $('#modalatur').modal('show');
                }
            }
        });
    }

    function konfirmasi() {
        $.ajax({
            type: "post",
            url: "<?= site_url('/sertifikat/input-konfirmasi') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalkonfirmasi').html(response.sukses).show();
                    $('#modalkonfirmasi').modal('show');
                }
            }
        });
    }

    function modal(form, sertifikat_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/sertifikat/edit') ?>",
            data: {
                form : form,
                sertifikat_id : sertifikat_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modal').modal('show');
                }
            }
        });
    }
</script>

<?= $this->endSection('isi') ?>