<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="table-responsive">
<table id="datatable" class="table table-striped table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Peserta</th>
            <th>Rincian Transfer</th>
            <th>Program</th>
            <th>Upload Bukti</th>
            <th>Status</th>
            <th>Bukti Transfer</th>
            <th>Konfirmasi</th>
        </tr>
    </thead>


    <tbody>
        <?php
        foreach ($list as $data) :
        ?>
            <tr>
                <td width="5%"><?= $data['bayar_id'] ?></td>
                <td width="15%">
                    <?= $data['nama_peserta'] ?> <br>
                    <p>NIS = <?= $data['nis'] ?></p>
                </td>
                <td width="15%">
                    Sertifikat = Rp <?= rupiah($data['awal_bayar_spp1'])?> <br>
                    Infaq = Rp <?= rupiah($data['awal_bayar_infaq'])?> <br>
                    Total = Rp <?= rupiah($data['nominal_bayar'])?>
                </td>
                <td width="14%">
                    <?php if ($data['sertifikat_kelas'] == "1") {?>
                        <p><strong>PROGRAM</strong> <?= $data['nama_program'] ?></p>
                    <?php }?>
                    <?php if ($data['sertifikat_kelas'] != "1" ) {?>
                        <p><strong>PROGRAM</strong> <?= $data['nama_program'] ?></p>
                        <p><strong>LULUS KELAS</strong> = <?= $data['nama_kelas'] ?></p>
                    <?php }?>
                </td>
                <td width="14%">
                    <p>Tgl:  <?= shortdate_indo($data['tgl_bayar'])?></p>
                    <p>Jam: <?= $data['waktu_bayar'] ?></p>
                </td>
                <td width="8%">
                    <h5>
                        <span class="badge badge-warning"><?= $data['status_konfirmasi'] ?></span>
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
                <td width="20%">
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="modal('<?= $data['bayar_id'] ?>', '<?= $data['sertifikat_id']?>', '<?= $data['sertifikat_kelas']?>','konfirmasi')" >
                        <i class=" fa fa-check"></i> Konfirmasi
                    </button>
                    <?php if ($data['sertifikat_kelas'] != "1" ) {?>
                        <button type="button" class="btn btn-info btn-sm" onclick="modal('<?= $data['bayar_id'] ?>', '<?= $data['sertifikat_id']?>', '<?= $data['sertifikat_kelas']?>', 'kelas')" >
                            <i class="fa fa-file"></i> Data Kelulusan
                        </button>
                    <?php }?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
</div>


<div class="viewmodal"></div>

<script>

    function modal(bayar_id, sertifikat_id, kelas_id, jenisModal) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pembayaran/input-konfirmasi-sertifikat') ?>",
            data: {
                bayar_id : bayar_id,
                sertifikat_id : sertifikat_id,
                kelas_id: kelas_id,
                jenis : jenisModal,
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