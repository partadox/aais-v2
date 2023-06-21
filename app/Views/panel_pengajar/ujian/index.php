<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> <?= $detail_kelas[0]['nama_kelas'] ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<a href="<?= base_url('/pengajar/kelas') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<h5 style="text-align:center;">Kelas <?= $detail_kelas[0]['nama_kelas'] ?></h5>
<h6 style="text-align:center;"><?= $detail_kelas[0]['hari_kelas'] ?>, <?= $detail_kelas[0]['waktu_kelas'] ?> - <?= $detail_kelas[0]['metode_kelas'] ?></h6>
<h6 style="text-align:center;"><?= $detail_kelas[0]['nama_pengajar'] ?></h6>



<div class="table-responsive">
    <table class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
            <th width="3%">No.</th>
            <th width="7%">NIS</th>
            <th width="12%">Nama</th>
            <th width="20%">Tanggal Ujian</th>
            <th width="12%">Waktu Ujian</th>
            <th width="12%">Nilai Ujian</th>
            <th width="12%">Nilai Akhir</th>
            <th width="16%">Status Kelulusan</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($peserta_onkelas as $data) :
                $nomor++; ?>
                <tr>
                <td ><?= $nomor ?></td>
                <td ><?= $data['nis'] ?></td>
                <td ><?= $data['nama_peserta'] ?></td>
                <td ><?= $data['tgl_ujian'] ?></td>
                <td ><?= $data['waktu_ujian'] ?></td>
                <td ><?= $data['nilai_ujian'] ?></td>
                <td ><?= $data['nilai_akhir'] ?></td>
                <td ><?= $data['status_peserta_kelas'] ?></td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection('isi') ?>