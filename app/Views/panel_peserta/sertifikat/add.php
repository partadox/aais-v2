<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>

<a href="<?= base_url('/peserta/sertifikat') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<?php if ($status_sertifikat == "TUTUP") { ?>
  <div class="card shadow-lg">
      <div class="card-title">
          Layanan Pengajuan Sertifikat Belum Dibuka.
      </div>
  </div>
<?php } ?>

<?php if ($status_sertifikat == "BUKA") { ?>
<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Formulir Pembayaran Sertifikat</h6>
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
        
    
    <?php echo form_open_multipart('/peserta/save-sertifikat');
    helper('text');
    ?>
    <?= csrf_field() ?>

      <input type="hidden" name="peserta_id" id="peserta_id" value="<?= $peserta['peserta_id'] ?>">
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
          </tbody>
        </table>
      </div>
      <div class="form-group">
        <div class="mb-3">
          <label class="form-label">Apakah Data Kelas Anda Sudah Ada di AAIS? <code>*</code></label>
          <select class="form-control no-search"  id="jenis" name="jenis" style="width:100%!important;" required>
            <option value="" selected disabled>--PILIH--</option>
            <option value="aais">DATA KELAS ADA AAIS (SUDAH LULUS)</option>
            <option value="nonaais">DATA LULUS KELAS TIDAK ADA DI AAIS</option>
          </select>
        </div>
      </div>
      <div class="form-group" id="findProgram" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Lulus Pada Program <code>*</code></label>
          <select class="form-control js-example-basic-single" name="program_id" id="program_id" style="width:100%!important;" required>
                <option value="" disabled selected>-- PILIH --</option>
            <?php foreach ($program as $key => $data) { ?>
              <option value="<?= $data['program_id'] ?>"> <?= $data['nama_program'] ?> </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="form-group" id="findKelas" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Lulus Pada Kelas (Data Kelas Sudah di AAIS)<code>*</code></label>
          <select class="form-control js-example-basic-single" name="kelas_id" id="kelas_id" style="width:100%!important;">
                  <option value="" disabled selected>-- PILIH --</option>
              <?php foreach ($list_lulus as $key => $data) { ?>
                <option value="<?= $data['kelas_id'] ?>"> <?= $data['nama_kelas'] ?> - PROGRAM <?= $data['nama_program'] ?> - <?= $data["nama_pengajar"] ?> - ANGKATAN KELAS <?= $data['angkatan_kelas'] ?> (<?= $data['status_peserta_kelas'] ?>) </option>
              <?php } ?>
            </select>
        </div>
      </div>
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
      
      <div class="form-group">
        <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <textarea class="form-control" id="keterangan_bayar" name="keterangan_bayar" placeholder="Masukan Keterangan Pengiring (jika ada)"></textarea>
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
      <button class="btn btn-primary mt-5" type="submit">Simpan Pembayaran Sertifikat</button>
      <?php echo form_close() ?>
    
  </div>
</div>
<?php } ?>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });

        $('.no-search').select2({
          minimumResultsForSearch: Infinity
        });
    });

    $(document).ready(function() {
      $('#jenis').change(function() {
          var selectedValue = $(this).val(); // Get the selected value

          if (selectedValue === 'aais') {
              // Show the findKelas div and set kelas_id as required
              $('#findKelas').show();
              $('#kelas_id').attr('required', true);
              
              // Hide the findProgram div and remove required from program_id
              $('#findProgram').hide();
              $('#program_id').removeAttr('required');
          } else if (selectedValue === 'nonaais') {
              // Show the findProgram div and set program_id as required
              $('#findProgram').show();
              $('#program_id').attr('required', true);

              // Hide the findKelas div and remove required from kelas_id
              $('#findKelas').hide();
              $('#kelas_id').removeAttr('required');
          }
      });
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