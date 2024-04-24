<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<a> 
    <button type="button" class="btn btn-success mb-3" onclick="waTm('')" ><i class="mdi mdi-whatsapp"></i> Template Footer WA Notif</button>
</a>

<div class="table-responsive">
    <table id="datatable" class="table table-bordered mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th width="10%">NO.</th>
                <th width="40%">JENIS NOTIFIKASI</th>
                <th width="20%">STATUS</th>
                <th width="20%">TINDAKAN</th> 
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++;
                ?>
                <tr>
                    <td><?= $nomor ?></td>
                    <td><?= $data['name'] ?></td>
                    <td>
                        <?php if($data['status'] == '0') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>NONAKTIF</button>  
                        <?php } ?>
                        <?php if($data['status'] == '1') { ?>
                            <button class="btn btn-success btn-sm" disabled>AKTIF</button> 
                        <?php } ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-warning mb-2" onclick="waAction('<?=$data['code']?>', 'edit')" >
                            <i class="mdi mdi-pencil"></i></button>
                        <button type="button" class="btn btn-info mb-2" onclick="waAction('<?=$data['code']?>', 'preview')" >
                            <i class="mdi mdi-eye"></i></button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="viewmodalwa"></div>
<div class="viewmodalaction"></div>
<script>
    function waTm() {
        $.ajax({
            type: "post",
            url: "<?= site_url('wa-input-footer') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalwa').html(response.sukses).show();
                    $('#modalwa').modal('show');
                }
            }
        });
    }

    function waAction(code, modul) {
        $.ajax({
            type: "post",
            url: "<?= site_url('wa-input-action') ?>",
            data: {
                code: code,
                modul: modul,
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalaction').html(response.sukses).show();
                    $('#modalaction').modal('show');
                }
            }
        });
    }
</script>
<?= $this->endSection('isi') ?>