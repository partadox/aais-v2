<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="5%">ID</th>
                <th width="10%">Code</th> 
                <th width="15%">Nama</th>
                <th width="10%">Type</th>
                <th width="10%">Status</th>
                <th width="5%">Biaya</th>
                <th width="5%">Pajak</th>
                <th width="10%">Detail</th>
                <th width="5%"></th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td><?= $nomor ?></td>
                    <td><?= $data['payment_id'] ?></td>
                    <td><?= $data['payment_code'] ?></td>
                    <td><?= $data['payment_name'] ?></td>
                    <td><?= $data['payment_type'] ?></td>
                    <td>
                        <?php if($data['payment_status'] == '0') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Nonaktif</button>  
                        <?php } ?>
                        <?php if($data['payment_status'] == '1') { ?>
                            <button class="btn btn-success btn-sm" disabled>Aktif</button> 
                        <?php } ?>
                        <?php if($data['payment_status'] == NULL) { ?>
                            <button class="btn btn-danger btn-sm" disabled>Belum Diatur</button> 
                        <?php } ?>
                    </td>
                    <td>Rp <?= rupiah($data['payment_price']) ?></td>
                    <td>Rp <?= rupiah(($data['payment_tax']/100)*$data['payment_price']) ?></td>
                    <td><?= $data['payment_rekening'] ?> - <?= $data['payment_atasnama'] ?></td>
                    <td>
                        <?php if($data['payment_status'] != NULL) { ?>
                            <button type="button" class="btn btn-warning btn-sm" onclick="edit('<?= $data['payment_id'] ?>')" >
                            <i class=" fa fa-edit"></i></button>
                        <?php } ?>
                        
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodaldataedit">
</div>

<script>

    function edit(payment_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('payment-methode/edit') ?>",
            data: {
                payment_id : payment_id
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

</script>
<?= $this->endSection('isi') ?>