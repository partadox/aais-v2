<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<!-- <div class="row">
    <div class="col-sm-auto">
        <a href="<?= base_url('pembayaran-nonreg?tahun='.$tahun_pilih ) ?>"> 
            <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-file-download"></i> Export Excel (Download)</button>
        </a>
    </div>
</div> -->
<div class="row">
    <div class="col-sm-auto ml-4 mb-2">
        <label for="tahun_kelas">Pilih Tahun Perkuliahan</label>
        <select onchange="javascript:location.href = this.value;" class="form-control js-example-basic-single" name="tahun_kelas_filter" id="tahun_kelas_filter" class="js-example-basic-single mb-2">
            <?php foreach ($list_tahun as $key => $data) { ?>
            <option value="pembayaran-nonreg?tahun=<?= $data['nk_tahun'] ?>" <?php if ($tahun_pilih == $data['nk_tahun']) echo "selected"; ?> > <?= $data['nk_tahun'] ?> </option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="table-responsive">
<table id="datatable" class="table table-striped table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID Byr</th>
            <th>ID Kelas</th>
            <th>Kelas</th>
            <th>Tahun</th>
            <th>PIC</th>
            <th>Program</th>
            <th>Rincian <br> Pembayaran</th>
            <th>Status <br> Pembayaran</th>
            <th>Bukti Transfer</th>
            <th>Status <br> Konfirmasi</th>
            
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 0;
        foreach ($list as $data) :
            $nomor++;
        ?>
            <tr>
                <td><?= $nomor ?></td>
                <td width="2%"><?= $data['bayar_id'] ?></td>
                <td width="7%"><?= $data['nk_id'] ?></td>
                <td width="12%"><?= $data['nk_nama'] ?></td>
                <td width="3%"><?= $data['nk_tahun'] ?></td>
                <td width="5%"><?= $data['nk_pic_name'] ?></td>
                <td width="5%"><?= $data['nama_program'] ?></td>
                <td width="12%">
                    <strong>Total:</strong> Rp <?= rupiah($data['nominal_bayar']) ?> <br>
                    <strong>Jml TM Dibayar:</strong> <?= $data['awal_bayar_spp1'] ?> <br>
                    <strong>Tgl:</strong>  <?= shortdate_indo($data['tgl_bayar'])?> <br>
                    <strong>Jam:</strong> <?= $data['waktu_bayar'] ?> <br>
                    
                    <strong> Ket. Bayar:</strong> <?= $data['keterangan_bayar'] ?> <br>
                    <strong> Ket. Bayar Adm:</strong> <?= $data['keterangan_bayar_admin'] ?>
                </td>
                <td width="8%">
                    <h5>
                        <span class="badge <?php if ($data['status_bayar_admin'] == "SESUAI BAYAR") { ?> badge-success <?php } else { ?> badge-secondary <?php } ?>"><?= $data['status_bayar_admin'] ?></span>
                    </h5>
                </td>
                <td width="20%">
                    <style>
                        .zoom {
                            transition: transform .2s; /* Animation */
                        }

                        .zoom:hover {
                            transform: scale(3.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
                        }
                    </style>
                        <img class="zoom" src="<?= base_url('public/img/transfer/' . $data['bukti_bayar']) ?>" width="120px">
                </td>
                <td width="8%">
                    <h5>
                        <span class="badge <?php if ($data['status_konfirmasi'] == "Proses") {?> badge-secondary <?php }?> <?php if ($data['status_konfirmasi'] == "Terkonfirmasi") {?> badge-success <?php }?>"><?= $data['status_konfirmasi'] ?></span>
                    </h5>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
</div>


<div class="viewmodal"></div>

<script>

    $('#tahun_kelas_filter').bind('change', function () { // bind change event to select
        var url = $(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });
</script>


<?= $this->endSection('isi') ?>