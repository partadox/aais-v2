<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>
<?php if ($form != "pilih") { ?>
  <a href="<?= base_url('/pembayaran/add-nonreg') ?>"> 
      <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
  </a>
<?php } ?>

<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Formulir Tambah Pembayaran Program Non Reguler</h6>
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
        
    
    <?php echo form_open_multipart('/pembayaran/save-nonreg');
    helper('text');
    ?>
    <?= csrf_field() ?>
    <?php if ($form == "pilih") { ?>
      <p class="mt-1">Catatan :<br>
        <i class="mdi mdi-information"></i> Pilih jenis pembayaran program non-reguler.<br>
        <i class="mdi mdi-information"></i> Pilih kelas non-reguler yang akan dibayar.<br>
      </p>
      <div class="form-group">
        <div class="mb-3">
          <label class="form-label">Jenis Pembayaran <code>*</code></label>
          <select class="form-control no-search"  id="jenis_nonreg" name="jenis_nonreg" style="width:100%!important;" onchange="showDiv(this)">
            <option selected disabled>--PILIH--</option>
            <option value="daftar">PENDAFTARAN</option>
            <option value="extend">EXTEND</option>
          </select>
        </div>
      </div>
      <div class="form-group" id="byrDaftar" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Pembayaran Pendaftaran Kelas<code>*</code></label>
          <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="kelas_daftar" id="kelas_daftar" class="js-example-basic-single" style="width:100%!important;">
                  <option value="" disabled selected>-- PILIH --</option>
              <?php foreach ($kelas_daftar as $key => $data) { ?>
                <option value="/pembayaran/add-nonreg?id=<?= $data['nk_id'] ?>"> <?= $data['nk_id'] ?> | <?= $data['nk_nama'] ?> | <?= $data['nk_pic_name'] ?> </option>
              <?php } ?>
            </select>
        </div>
      </div>
      <div class="form-group" id="byrExtend" style="display: none;">
        <div class="mb-3">
          <label class="form-label">Pembayaran Extend Kelas<code>*</code></label>
          <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="kelas_extend" id="kelas_extend" class="js-example-basic-single" style="width:100%!important;">
                  <option value="" disabled selected>-- PILIH --</option>
              <?php foreach ($kelas_extend as $key => $data) { ?>
                <option value="/pembayaran/add-nonreg?id=<?= $data['nk_id'] ?>"  <?php if ($data['nk_tm_ambil'] == $data['nk_tm_total']) {echo "disabled";} ?>> <?= $data['nk_id'] ?> | <?= $data['nk_nama'] ?> | <?= $data['nk_pic_name'] ?> | Pertemuan Terambil = <?= $data['nk_tm_ambil'] ?> / Maks TM = <?= $data['nk_tm_total'] ?> </option>
              <?php } ?>
            </select>
        </div>
      </div>
    <?php } ?>
    <?php if ($form == "daftar" || $form == "extend") { ?>
      <input type="hidden" name="nk_id" id="nk_id" value="<?= $nk['nk_id'] ?>">
      <div id="infoKelas">
        <table class="table table-bordered table-sm">
          <tbody>
            <tr>
                <td width="40%"><b>NIK</b></td>
                <td><?= $nk['nk_id'] ?></td>
            </tr>
            <tr>
                <td width="40%"><b>Nama Kelas</b></td>
                <td><?= $nk['nk_nama'] ?></td>
            </tr>
            <tr>
                <td width="40%"><b>Nama PIC</b></td>
                <td><?= $nk['nk_pic_name'] ?></td>
            </tr>
            <tr>
                <td width="40%"><b>No. HP PIC</b></td>
                <td><?= $nk['nk_pic_hp'] ?></td>
            </tr>
            <tr>
                <td width="40%"><b>Lokasi Kelas</b></td>
                <td><?= $nk['nk_lokasi'] ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <?php if ($form == "daftar") { ?>
        <div class="form-group">
          <div class="mb-3">
            <label class="form-label">Pendaftaran <code>*</code></label>
            <input type="hidden" id="daftar" name="daftar" value="<?= $nk_prog['biaya_daftar'] ?>">
            <input type="text" class="form-control" value="Rp. <?= rupiah($nk_prog['biaya_daftar']) ?>" readonly>
          </div>
        </div>
      <?php } ?>
      <div class="form-group row">
        <div class="col-5">
          <div class="mb-3">
            <label class="form-label">SPP Pertemuan</label>
            <input type="hidden" id="spp" name="spp" value="<?= $nk_prog['biaya_bulanan'] ?>">
            <input class="form-control" type="text" value="Rp. <?= rupiah($nk_prog['biaya_bulanan']) ?>" readonly >
          </div>
        </div>
        <div class="col-7">
          <div class="mb-3">
            <label class="form-label"> <b>X</b> Pertemuan Yang Akan Diambil <code>*</code></label>
            <select class="form-control" id="spp1" name="spp1" style="width:100%!important;">
              <?php for ($i = 1; $i <= ($nk['nk_tm_total']-$nk['nk_tm_ambil']); $i++) { ?>
                <option value="<?= $i ?>"> <?= $i ?> </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group row">
        <div class="col-5">
          <div class="mb-3">
            <label class="form-label">Modul</label>
            <input class="form-control" type="text" value="Rp. <?= rupiah($nk_prog['biaya_modul']) ?>" readonly >
          </div>
        </div>
        <div class="col-7">
          <div class="mb-3">
            <label class="form-label">Dengan Modul <code>*</code></label>
            <select class="form-control" id="modul" name="modul" style="width:100%!important;">
              <option value="<?= $nk_prog['biaya_modul'] ?>" <?php if ($form == "daftar") {echo "selected";} ?> >Termasuk</option>
              <option value="0" <?php if ($form != "daftar") {echo "selected";} ?>>Tidak Termasuk</option>
            </select>
          </div>
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
          <label class="form-label">Biaya Lainnya (Tunggukan SPP, Merchandise, dsb) <code>*</code></label>
          <input class="form-control number-separator" type="text" id="lain" name="lain" value="0">
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
        // Initialize Select2 for modulSelect
        $('#modul').select2({minimumResultsForSearch: Infinity});

        // Initialize Select2 for spp1
        $('#spp1').select2({minimumResultsForSearch: Infinity});
    });

    function showDiv(select){
      if(select.value=="daftar"){
          document.getElementById('byrDaftar').style.display = "block";
          document.getElementById('byrExtend').style.display = "none";
      }
      else if (select.value=="extend") {
        document.getElementById('byrDaftar').style.display = "none";
        document.getElementById('byrExtend').style.display = "block";
      }
    }

  $('#kelas_daftar').bind('change', function () { // bind change event to select
      var url = $(this).val(); // get selected value
      if (url != '') { // require a URL
          window.location = url; // redirect
      }
      return false;
  });

  $('#kelas_extend').bind('change', function () { // bind change event to select
      var url = $(this).val(); // get selected value
      if (url != '') { // require a URL
          window.location = url; // redirect
      }
      return false;
  });

  document.addEventListener('DOMContentLoaded', function () {
    // Function to update total based on selected value
    function updateTotal() {
      var sppValue = parseFloat(document.getElementById('spp').value.replace('Rp. ', '').replace('.', '').replace(',', '.'));
      var selectedValue = parseFloat(document.getElementById('spp1').value);
      <?php if ($form == "daftar") { ?>
        var daftar = parseFloat(document.getElementById('daftar').value.replace('Rp. ', '').replace('.', '').replace(',', '.'));
      <?php } ?>
      <?php if ($form == "extend") { ?>
        var daftar = 0;
      <?php } ?>
      var modul = parseFloat(document.getElementById('modul').value);

      // Extract numeric values from MaskMoney inputs
      var infaq = parseFloat(document.getElementById('infaq').value.replace('Rp. ', '').replace('.', '').replace(',', '.'));
      var lain = parseFloat(document.getElementById('lain').value.replace('Rp. ', '').replace('.', '').replace(',', '.'));

      var total = daftar + (sppValue * selectedValue) + modul + infaq + lain;
      var formattedTotal = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
      // Set the value to the hidden input with id 'total'
      document.getElementById('total').value = total;
      document.getElementById('totalVar').innerHTML = '<b>Total = </b>' + formattedTotal; // Format total as currency
    }

    //console.log('Attaching event listener...');
    $('#spp1').on('change', updateTotal);
    $('#modul').on('change', updateTotal);
    // Attach event listener to the select element using the change event
    document.getElementById('spp1').addEventListener('change', updateTotal);
    document.getElementById('modul').addEventListener('change', updateTotal);
    // Initial calculation on page load
    updateTotal();

    // Initialize MaskMoney for infaq and lain inputs
    $('#infaq').maskMoney({ prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0, allowZero: true });
    $('#lain').maskMoney({ prefix: 'Rp. ', thousands: '.', decimal: ',', precision: 0, allowZero: true });

    // Attach event listeners to infaq and lain inputs for real-time updates
    $('#infaq, #lain').on('change', updateTotal);
  });

</script>

<?= $this->endSection('isi') ?>