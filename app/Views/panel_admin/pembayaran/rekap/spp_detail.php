<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<a href="<?= base_url('/pembayaran/rekap-spp') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<div class="table-responsive">
<table id="datatable" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Transaksi ID</th>
            <th>Peserta</th>
            <th>Program/Kelas</th>
            <th>Pembayaran</th>
            <th>Rincian Bayar</th>
            <th>Status <br> Pembayaran</th>
            <th>Bukti Transfer</th>
            <th>Status Konfirmasi</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++;  ?>
            <tr>
                <td width="2%"><?=$nomor?></td>
                <td width="5%"><?= $data['bayar_id'] ?></td>
                <td width="15%">
                    <h6>Nama: <?= $data['nama_peserta'] ?></h6>
                    <p>NIS: <?= $data['nis'] ?></p>
                </td>
                <td width="15%">
                <?php if($data['kelas_id'] != NULL) { ?>
                        <p>Prgram: <?= $data['nama_program'] ?></p>
                        <p>Kelas: <?= $data['nama_kelas'] ?></p>
                        <p>Hari: <?= $data['hari_kelas'] ?></p>
                        <p>Waktu: <?= $data['waktu_kelas'] ?></p>
                        <p>Pengajar: <?= $data['nama_pengajar'] ?></p>
                    <?php } ?>
                    <?php if($data['kelas_id'] == NULL) { ?>
                        <p>-</p>
                    <?php } ?>
                </td>
                <td width="10%">
                    <p><b>Metode: 
                        <?php if($data['metode'] == NULL) { ?>
                        transfer manual
                        <?php } ?>
                        <?php if($data['metode'] != NULL) { ?>
                        <?= $data['metode'] ?>
                        <?php } ?></b>
                    </p>
                    <p>Tgl:  <?= shortdate_indo($data['tgl_bayar'])?></p>
                    <p>Jam: <?= $data['waktu_bayar'] ?></p>
                </td>
                <td width="13%">
                    <?php if($data['status_konfirmasi'] == 'Terkonfirmasi') { ?>
                        <a>Total: Rp <?= rupiah($data['nominal_bayar']) ?></a> <br>
                        <a>Daftar: Rp <?= rupiah($data['awal_bayar_daftar']) ?></a> <br>
                        <a>SPP1: Rp <?= rupiah($data['awal_bayar_spp1']) ?></a> <br>
                        <a>SPP2: Rp <?= rupiah($data['awal_bayar_spp2']) ?></a> <br>
                        <a>SPP3: Rp <?= rupiah($data['awal_bayar_spp3']) ?></a> <br>
                        <a>SPP4: Rp <?= rupiah($data['awal_bayar_spp4']) ?></a><br>
                        <a>Modul: Rp <?= rupiah($data['awal_bayar_modul']) ?></a> <br>
                        <a>Infaq: Rp <?= rupiah($data['awal_bayar_infaq']) ?></a> <br>
                        <a>Lain: Rp <?= rupiah($data['awal_bayar_lainnya']) ?></a> <br>
                        <a>Ket: <?= $data['keterangan_bayar'] ?></a> 
                    <?php } ?>
                    <?php if($data['status_konfirmasi'] == 'Proses') { ?>
                        <button class="btn btn-warning btn-sm mb-2" disabled>Proses</button>
                    <?php } ?>
                </td>
                <td width="8%">
                    <?php if($data['status_bayar_admin'] == 'SESUAI BAYAR') { ?>
                        <button class="btn btn-success btn-sm mb-2" disabled>SESUAI BAYAR</button>
                    <?php } ?>
                    <?php if($data['status_bayar_admin'] != 'SESUAI BAYAR') { ?>
                        <button class="btn btn-secondary btn-sm mb-2" disabled><?= $data['status_bayar_admin'] ?></button>
                    <?php } ?>
                    <p>Ket Adm: <br> <?= $data['keterangan_bayar_admin'] ?></p>
                </td>
                <td width="18%">
                <style>
                    .zoom {
                        transition: transform .2s; /* Animation */
                    }

                    .zoom:hover {
                        transform: scale(2.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
                    }
                </style>
                <img class="zoom" title="" src="<?= base_url('public/img/transfer/' . $data['bukti_bayar']) ?>" alt="" width="150" align="right" border="1" hspace="" vspace="" />
                </td>
                <td width="10%">
                    <?php if($data['status_konfirmasi'] == 'Proses') { ?>
                        <button class="btn btn-secondary btn-sm" disabled>Proses</button> 
                    <?php } ?>
                    <?php if($data['status_konfirmasi'] == 'Terkonfirmasi') { ?>
                        <button class="btn btn-success btn-sm mb-2" disabled>Terkonfirmasi</button>
                        <p>Validator: <?= $data['validator'] ?></p> 
                    <?php } ?>
                    <?php if($data['status_konfirmasi'] == 'Tolak') { ?>
                        <button class="btn btn-danger btn-sm mb-2" disabled>Tolak</button>
                        <p>Validator: <?= $data['validator'] ?></p> 
                    <?php } ?>
                    <?php if($data['tgl_bayar_konfirmasi'] == '1000-01-01') { ?>
                        <p>Belum Terkonfirmasi</p> 
                    <?php } ?>
                    <?php if($data['tgl_bayar_konfirmasi'] != '1000-01-01') { ?>
                        <p>Tgl:  <?= shortdate_indo($data['tgl_bayar_konfirmasi'])?></p>
                        <p>Jam: <?= $data['waktu_bayar_konfirmasi'] ?></p>
                    <?php } ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
</div>

<script>

</script>


<?= $this->endSection('isi') ?>