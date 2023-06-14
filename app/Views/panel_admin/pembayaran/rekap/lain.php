<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>

<a href="<?= base_url('/pembayaran/rekap-lain-export') ?>"> 
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
                <th>Waktu Bayar</th>
                <th>Nominal</th>
                <th>Validator</th>
                <th>Ket. Peserta</th>
                <th>Ket. Admin</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 0;
            foreach ($lain as $data) :
                $nomor++;  ?>
                <tr>
                    <td width="2%"><?=$nomor?></td>
                    <td width="5%"><?= $data['bayar_id'] ?></td>
                    <td width="7%"><?= $data['nis'] ?></td>
                    <td width="10%"><?= $data['nama_peserta'] ?></td>
                    <td width="10%"><?= shortdate_indo($data['tgl_bayar'])?> <br> <?= $data['waktu_bayar']?></td>
                    <td width="10%">Rp <?= rupiah($data['bayar_lainnya'])?></td>
                    <td width="6%"><?= $data['validator']?></td>
                    <td width="10%"><?= $data['keterangan_bayar']?></td>
                    <td width="12%"><?= $data['keterangan_bayar_admin']?></td>
                    <td width="9%">
                        <button type="button" class="btn btn-warning mb-2" onclick="edit('<?= $data['biaya_lainnya_id'] ?>')" >
                        <i class=" fa fa-edit mr-1"></i>Edit</button>
                        <button type="button" class="btn btn-danger" onclick="hapus('<?= $data['biaya_lainnya_id'] ?>')" >
                        <i class=" fa fa-trash mr-1"></i>Hapus</button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
  </div>

  <div class="viewmodaldataedit">
</div>

<script>
    function edit(biaya_lainnya_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/pembayaran/rekap-lain-edit') ?>",
            data: {
                biaya_lainnya_id : biaya_lainnya_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaldataedit').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function hapus(biaya_lainnya_id) {
        Swal.fire({
            title: 'Hapus Data Pembayaran Lain?',
            text: `Apakah anda yakin mmenghapus data ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('/pembayaran/rekap-lain-delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        biaya_lainnya_id : biaya_lainnya_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus data pembayaran lain!",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location = response.sukses.link;
                        });
                        }
                    }
                });
            }
        })
    }
</script>

<?= $this->endSection('isi') ?>