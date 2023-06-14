<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>

<a href="<?= base_url('/pembayaran/rekap-infaq-export') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-file-download"></i> Export Excel (Download)</button>
</a>

  <div class="card-body">
  <div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Transaksi ID</th>
                <th>NIS</th>
                <th>Peserta</th>
                <th>Tgl Bayar</th>
                <th>Waktu Bayar</th>
                <th>Nominal</th>
                <th>Validator</th>
                <th>Ket. Peserta</th>
                <th>Ket. Admin</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($infaq as $data) :
                $nomor++;  ?>
                <tr>
                    <td width="2%"><?=$nomor?></td>
                    <td width="5%"><?= $data['bayar_id'] ?></td>
                    <td width="7%"><?= $data['nis'] ?></td>
                    <td width="10%"><?= $data['nama_peserta'] ?></td>
                    <td width="5%"><?= shortdate_indo($data['tgl_bayar'])?></td>
                    <td width="5%"><?= $data['waktu_bayar']?></td>
                    <td width="10%">Rp <?= rupiah($data['bayar_infaq'])?></td>
                    <td width="6%"><?= $data['validator']?></td>
                    <td width="12%"><?= $data['keterangan_bayar']?></td>
                    <td width="12%"><?= $data['keterangan_bayar_admin']?></td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
  </div>

<script>
 
</script>

<?= $this->endSection('isi') ?>