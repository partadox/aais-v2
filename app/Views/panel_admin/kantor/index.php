<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<a> 
    <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Tambah Kantor / Cabang</button>
</a>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Kota</th> 
                <th>Alamat</th>
                <th>Kontak</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="5%"><?= $nomor ?></td>
                    <td width="5%"><?= $data['kantor_id'] ?></td>
                    <td width="14%"><?= $data['nama_kantor'] ?></td>
                    <td width="8%"><?= $data['kota_kantor'] ?></td>
                    <td width="10%"><?= $data['alamat_kantor'] ?></td>
                    <td width="8%"><?= $data['kontak_kantor'] ?></td>
                    <td width="10%">
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $data['kantor_id'] ?>')" >
                        <i class=" fa fa-edit"></i></button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodaltambah">
</div>

<div class="viewmodaldataedit">
</div>

<script>
    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('kantor/input') ?>",
            data: {
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaltambah').html(response.sukses).show();
                    $('#modaltambah').modal('show');
                }
            }
        });
    }

    function edit(kantor_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kantor/edit') ?>",
            data: {
                kantor_id : kantor_id
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