<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>
<?php if ($form != "pilih") { ?>
  <a href="<?= base_url('/pembayaran/add-sertifikat') ?>"> 
      <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
  </a>
<?php } ?>

<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Formulir Tambah Pembayaran Sertifikat</h6>
    <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
  </div>
  <div class="card-body">
  <div class="swal" data-swal="<?= session()->get('pesan'); ?>"></div>
    
    <?php
      if (session()->getFlashdata('pesan_eror')) {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button> <i class="mdi mdi-alert-circle"></i> <strong>';
          echo session()->getFlashdata('pesan_eror');
          echo ' </strong> </div>';
      }
      ?>

      <?php
      if (session()->getFlashdata('pesan_sukses')) {
          echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button> <i class="mdi mdi-check-circle"></i> <strong>';
          echo session()->getFlashdata('pesan_sukses');
          echo ' </strong> </div>';
      }
      ?>
        
    
    <?php echo form_open_multipart('/pembayaran/save-sertifikat');
    helper('text');
    ?>
    <?= csrf_field() ?>
    <?php if ($form == "pilih") { ?>
      <p class="mt-1">Catatan :<br>
        <i class="mdi mdi-information"></i> Data Kelulusan <b>Tidak Ada</b> di AAIS merupakan pembuatan sertifikat untuk data peserta yang lulus pada program di Al-Haqq sebelum adanya sistem AAIS.<br>
        <i class="mdi mdi-information"></i> Data Kelulusan <b>Ada</b> di AAIS merupakan pembuatan sertifikat untuk data peserta yang lulus pada program di Al-Haqq yang telah tersimpan AAIS.<br>
      </p>
      <div class="form-group">
        <div class="mb-3">
          <label class="form-label">Pembayaran Sertifikat untuk Peserta <code>*</code></label>
          <select class="form-control no-search"  id="jenis" name="jenis_nonreg" style="width:100%!important;" onchange="showDiv(this)">
            <option selected disabled>--PILIH--</option>
            <option value="aais">Data Kelulusan Ada di AAIS</option>
            <option value="nonaais">Data Kelulusan Tidak Ada di AAIS</option>
          </select>
        </div>
      </div>
      <div class="form-group" id="byrNonaais" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Pilih Peserta<code>*</code></label>
          <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="peserta_id" id="peserta_id" class="js-example-basic-single" style="width:100%!important;">
                  <option value="" disabled selected>-- PILIH --</option>
              <?php foreach ($peserta as $key => $data) { ?>
                <option value="/pembayaran/add-sertifikat?type=nonaais&&id=<?= $data['peserta_id'] ?>"> <?= $data['nis'] ?> - <?= $data['nama_peserta'] ?> </option>
              <?php } ?>
            </select>
        </div>
      </div>
      <div class="form-group" id="byrAais" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Pilih Peserta Lulus pada Kelas<code>*</code></label>
          <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="peserta_kelas" id="peserta_kelas" class="js-example-basic-single" style="width:100%!important;">
                  <option value="" disabled selected>-- PILIH --</option>
              <?php foreach ($peserta_kelas as $key => $data) { ?>
                <option value="/pembayaran/add-sertifikat?type=aais&&id=<?= $data['peserta_kelas_id'] ?>"> <?= $data['nis'] ?> - <?= $data['nama_peserta'] ?> | <?= $data['nama_program'] ?> | <?= $data['nama_kelas'] ?> | Angkatan Kelas = <?= $data['angkatan_kelas'] ?> </option>
              <?php } ?>
            </select>
        </div>
      </div>
    <?php } ?>
    <?php if ($form == "nonaais" || $form == "aais") { ?>
      <input type="hidden" name="typeForm" id="typeForm" value="<?= $form ?>">
      <?php if ($form == "aais") { ?>
        <input type="hidden" name="peserta_kelas_id" id="peserta_kelas_id" value="<?= $pk['peserta_kelas_id'] ?>">
      <?php } ?>
      <?php if ($form == "nonaais") { ?>
        <input type="hidden" name="peserta_id" id="peserta_id" value="<?= $peserta['peserta_id'] ?>">
      <?php } ?>
      <div id="infoKelas">
        <table class="table table-bordered table-sm">
          <tbody>
            <tr>
                <td width="40%"><b>NIS</b></td>
                <td><?= $peserta['nis'] ?></td>
            </tr>
            <tr>
                <td width="40%"><b>Nama Peserta</b></td>
                <td><?= $peserta['nama_peserta'] ?></td>
            </tr>
            <?php if ($form == "aais") { ?>
              <tr>
                  <td width="40%"><b>Program</b></td>
                  <td><?= $program['nama_program'] ?></td>
              </tr>
              <tr>
                  <td width="40%"><b>Kelas Lulus</b></td>
                  <td><?= $kelas['nama_kelas'] ?></td>
              </tr>
              <tr>
                  <td width="40%"><b>Angkatan Kelas</b></td>
                  <td><?= $kelas['angkatan_kelas'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <?php if ($form == "nonaais") { ?>
        <div class="form-group">
          <div class="mb-3">
            <label class="form-label">Lulus Program <code>*</code></label>
            <select class="form-control js-example-basic-single" name="program_id" id="program_id" style="width:100%!important;" required>
                  <option value="" disabled selected>-- PILIH --</option>
              <?php foreach ($program as $key => $data) { ?>
                <option value="<?= $data['program_id'] ?>"> <?= $data['nama_program'] ?> </option>
              <?php } ?>
            </select>
          </div>
        </div>
      <?php } ?>
      
      <div class="form-group">
        <div class="mb-3">
          <label class="form-label">Biaya Sertifikat <code>*</code></label>
          <input type="hidden" name="nominal_bayar_cetak" id="nominal_bayar_cetak" value="<?= $biaya_sertifikat ?>">
          <input class="form-control number-separator" value="Rp <?= rupiah($biaya_sertifikat) ?>" readonly>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-3">
          <label class="form-label">Infaq <code>*</code></label>
          <input class="form-control number-separator" type="text" id="infaq" name="infaq" value="0">
        </div>
      </div>
      
      <div class="form-group" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Status Pembayaran<code>*</code></label>
          <select class="form-control btn-square" id="status_bayar_admin" name="status_bayar_admin">
              <!-- <option value="" disabled selected>-- PILIH --</option> -->
              <option value="SESUAI BAYAR" selected >SESUAI BAYAR</option>
              <option value="KURANG BAYAR">KURANG BAYAR</option>
              <option value="LEBIH BAYAR">LEBIH BAYAR</option>
              <option value="BELUM BAYAR">BELUM BAYAR</option>
              <option value="BEBAS BIAYA">BEBAS BIAYA</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-3">
          <label class="form-label">Keterangan Admin</label>
          <textarea class="form-control" id="keterangan_admin" name="keterangan_admin" placeholder="Masukan Keterangan Pengiring (jika ada)"></textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="mb-3 align-left">
          <input type="hidden" name="total" id="total">
          <h1 id=totalVar></h1>
        </div>
      </div>
      <hr>
      <div class="form-group row">
        <label for="" class="col-sm-2 col-form-label">Upload Bukti Transfer<code>*</code></label>
        <div class="col-lg-6">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input"  id="foto" name="foto" onchange="previewimg()" accept=".jpg,.jpeg,.png" required>
                    <label class="custom-file-label">Upload Bukti Transfer</label>
                </div>
            </div>
        </div>
        <div class="invalid-feedback errorFoto"></div>
        <div class="col-lg-6 mt-2">
          <div class="media">
              <img src="" class="img-preview img-thumbnail rounded img-fluid" width="50%" alt >
          </div>
        </div>
      </div>
      <button class="btn btn-primary mt-5" type="submit">Simpan Pembayaran</button>
      <?php echo form_close() ?>

    <?php } ?>
    
  </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });

        $('.no-search').select2({
          minimumResultsForSearch: Infinity
        });
    });

    function showDiv(select){
      if(select.value=="nonaais"){
          document.getElementById('byrNonaais').style.display = "block";
          document.getElementById('byrAais').style.display = "none";
      }
      else if (select.value=="aais") {
        document.getElementById('byrNonaais').style.display = "none";
        document.getElementById('byrAais').style.display = "block";
      }
    }

  $('#peserta').bind('change', function () { // bind change event to select
      var url = $(this).val(); // get selected value
      if (url != '') { // require a URL
          window.location = url; // redirect
      }
      return false;
  });

  $('#peserta_kelas').bind('change', function () { // bind change event to select
      var url = $(this).val(); // get selected value
      if (url != '') { // require a URL
          window.location = url; // redirect
      }
      return false;
  });

  document.addEventListener('DOMContentLoaded', function () {
    // Function to update total based on selected value
    function updateTotal() {
      var sertifikat = parseFloat(document.getElementById('nominal_bayar_cetak').value);
      var infaq = parseFloat(document.getElementById('infaq').value.replace('Rp. ', '').replace('.', '').replace(',', '.'));

      var total = sertifikat + infaq ;
      var formattedTotal = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
      // Set the value to the hidden input with id 'total'
      document.getElementById('total').value = total;
      document.getElementById('totalVar').innerHTML = '<b>Total = </b>' + formattedTotal; // Format total as currency
    }

    
    updateTotal();

    // Initialize MaskMoney for infaq and lain inputs
    $('#infaq').maskMoney({ prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0, allowZero: true });

    // Attach event listeners to infaq and lain inputs for real-time updates
    $('#infaq').on('change', updateTotal);
  });

</script>

<?= $this->endSection('isi') ?>