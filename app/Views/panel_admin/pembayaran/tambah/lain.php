<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>

<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Formulir Tambah Pembayaran Infaq & Pembayaran Lain Peserta</h6>
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
        
    
    <?php echo form_open_multipart('/pembayaran/save-lain');
    helper('text');
    ?>
    <?= csrf_field() ?>
    <div class="form-group">
      <div class="mb-3">
        <label class="form-label">Peserta<code>*</code></label>
          <select class="form-control js-example-basic-single" name="peserta_id" id="peserta_id" class="js-example-basic-single">
                <option value="" disabled selected>-- PILIH --</option>
            <?php foreach ($peserta as $key => $data) { ?>
                <option value="<?= $data['peserta_id'] ?>"><?= $data['nis'] ?> - <?= $data['nama'] ?></option>
            <?php } ?>
          </select>
      </div>
    </div>
    <div class="form-group">
      <div class="mb-3">
        <label class="form-label">Total Nominal Transfer<code>*</code></label>
          <input class="form-control number-separator" type="text" id="awal_bayar" name="awal_bayar" placeholder="Input Nominal Transfer">
      </div>
    </div>
    <div class="form-group">
      <div class="mb-3">
        <label class="form-label">Infaq <code>*</code></label>
        <input class="form-control number-separator" type="text" id="infaq" name="infaq" placeholder="(Masukan 0 jika tidak ada infaq)">
      </div>
    </div>
    <div class="form-group">
      <div class="mb-3">
        <label class="form-label">Biaya Lainnya (Tunggukan SPP, Merchandise, dsb) <code>*</code></label>
        <input class="form-control number-separator" type="text" id="lain" name="lain" placeholder="(Masukan 0 jika tidak biaya lainnya)">
      </div>
    </div>
    <div class="form-group">
      <div class="mb-3">
        <label class="form-label">Status Pembayaran<code>*</code></label>
        <select class="form-control btn-square" id="status_bayar_admin" name="status_bayar_admin">
            <option value="" disabled selected>-- PILIH --</option>
            <option value="SESUAI BAYAR" >SESUAI BAYAR</option>
            <option value="KURANG BAYAR">KURANG BAYAR</option>
            <option value="LEBIH BAYAR">LEBIH BAYAR</option>
            <option value="BELUM BAYAR">BELUM BAYAR</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <div class="mb-3">
        <label class="form-label">Keterangan Admin</label>
        <input class="form-control text-uppercase" type="text-area" id="keterangan_admin" name="keterangan_admin" placeholder="Masukan Keterangan Pengiring (jika ada)">
      </div>
    </div>
    <div class="form-group row">
      <label for="" class="col-sm-2 col-form-label">Upload Bukti Transfer<code>*</code></label>
      <div class="col-lg-6">
          <div class="input-group">
              <div class="custom-file">
                  <!-- <input type="file" class="custom-file-input"  id="foto" name="foto" onchange="previewimg()"> -->
                  <input type="file" class="form-control" name="foto" accept=".xls, .xlsx, .png, .jpg, .jpeg">
                  <!-- <input type="file"id="foto" name="foto">
                  <label class="custom-file-label">Upload Bukti Transfer</label> -->
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
  </div>
  </div>
</div>

<script>
  $(document).ready(function() {
        $('.js-example-basic-single').select2({
        });
    });

  $(document).ready(function () {
			$('#awal_bayar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
      $('#infaq').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#lain').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
  });

</script>

<?= $this->endSection('isi') ?>