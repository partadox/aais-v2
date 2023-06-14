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
            <th>Kelas</th>
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
                    <?php if($data['nis'] == '') { ?>
                        NIS = <button type="button" class="btn btn-primary btn-sm" onclick="nis('<?= $data['peserta_id'] ?>')">Buat NIS</button>
                        <p>Peserta Baru. Isi NIS dahulu sebelum konfirmasi</p>
                    <?php } ?>
                    <?php if($data['nis'] != '') { ?>
                        <p>NIS = <?= $data['nis'] ?></p>
                    <?php } ?>
                </td>
                <td width="15%">
                    <p>Total Transfer = Rp <?= rupiah($data['awal_bayar'])?></p>
                    <p>Pendaftaran = Rp <?= rupiah($data['awal_bayar_daftar'])?></p>
                    <p>SPP-1 = Rp <?= rupiah($data['awal_bayar_spp1'])?></p>
                    <p>SPP-2 = Rp <?= rupiah($data['awal_bayar_spp2'])?></p>
                    <p>SPP-3 = Rp <?= rupiah($data['awal_bayar_spp3'])?></p>
                    <p>SPP-4 = Rp <?= rupiah($data['awal_bayar_spp4'])?></p>
                    <p>Infaq = Rp <?= rupiah($data['awal_bayar_infaq'])?></p>
                    <p>Modul = Rp <?= rupiah($data['awal_bayar_modul'])?></p>
                    <p>Biaya Lain = Rp <?= rupiah($data['awal_bayar_lainnya'])?></p>
                </td>
                <td width="14%">
                    <p>Program: <?= $data['nama_program'] ?></p>
                    <p>Kelas: <?= $data['nama_kelas'] ?></p>
                    <p>Hari: <?= $data['hari_kelas'] ?></p>
                    <p>Waktu: <?= $data['waktu_kelas'] ?>  <?= $data['zona_waktu_kelas'] ?></p>
                    <p>Pengajar: <?= $data['nama_pengajar'] ?></p>
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
                    <?php if($data['nis'] == '') { ?>
                        <p>Peserta Baru. Isi NIS dahulu sebelum konfirmasi</p>
                    <?php } ?>
                    <?php if($data['nis'] != '') { ?>
                        <button type="button" class="btn btn-success btn-sm btn-konfirmasi" data-item="<?= $data['bayar_id'] ?>">
                       <i class="fa fa-check"></i> Konfirmasi
                    </button>
                    <!-- Untuk level admin dan super admin -->
                    <!-- <button type="button" class="btn btn-danger btn-sm mt-2" onclick="edit('<?= $data['bayar_id'] ?>')">
                       <i class="fa fa-trash"></i> Hapus
                    </button> -->
                    <?php } ?>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
</div>


<div class="viewmodalnis">
</div>

<div class="viewmodalkonfirmasi">
</div>

<script>
    $(document).on('click','.btn-konfirmasi',function(e){
        e.preventDefault()
        let bayar_id = $(this).data("item")
        konfirmasi(bayar_id)
    })

    function konfirmasi(bayar_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pembayaran/input-konfirmasi') ?>",
            data: {
                bayar_id: bayar_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalkonfirmasi').html(response.sukses).show();
                    $('#modalkonfirmasi').modal('show');
                }
            }
        });
    }

    
</script>


<?= $this->endSection('isi') ?>