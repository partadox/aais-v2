<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h3 class="page-title">Dashboard - Angkatan Perkuliahan Saat ini : </h3>
</div>
<div class="col-sm-6">
    <ol class="breadcrumb float-right">
        <div id="clock"></div>
    </ol>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <i class="mdi mdi-account-multiple-outline"></i>
        <strong>Selamat Datang <?= $user['nama'] ?> </strong> Di Sistem Informasi Al-Haqq.
</div>
<div class="row">
</div>

<?= $this->endSection('isi') ?>