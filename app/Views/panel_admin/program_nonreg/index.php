<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<a> 
    <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Tambah Program</button>
</a>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <!-- <th>No.</th> -->
                <th>ID Program</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Tipe Kelas</th>
                <th>Biaya Daftar</th>
                <th>SPP Pertemuan</th>
                <th>Biaya Modul</th>
                <th>Status</th>
                <!-- <th>Fitur Ujian</th>
                <th>Tampil Nilai Ujian</th> -->
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <!-- <td width="5%"><?= $nomor ?></td> -->
                    <td width="5%"><?= $data['program_id'] ?></td>
                    <td width="20%"><?= $data['nama_program'] ?></td>
                    <td width="10%"><?= $data['kategori_program'] ?></td>
                    <td width="12%"><?= $data['jenis_program'] ?></td>
                    
                    <td width="10%">Rp <?= rupiah($data['biaya_daftar']) ?></td>
                    <td width="10%">Rp <?= rupiah($data['biaya_bulanan']) ?></td>
                    <td width="10%">Rp <?= rupiah($data['biaya_modul']) ?></td>
                    <td width="5%">
                        <?php if($data['status_program'] == 'aktif') { ?>
                            <button class="btn btn-success btn-sm" disabled>Aktif</button> 
                        <?php } ?>
                        <?php if($data['status_program'] == 'nonaktif') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Nonaktif</button> 
                        <?php } ?>
                    </td>
                    <!-- <td width="10%">
                        <?php if($data['ujian_custom_status'] == NULL) { ?>
                            <button class="btn btn-primary btn-sm" disabled>Standart</button> 
                        <?php } ?>
                        <?php if($data['ujian_custom_status'] != NULL) { ?>
                            <button class="btn btn-info btn-sm" disabled>Custom</button> 
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if($data['ujian_show'] == 1) { ?>
                            <button class="btn btn-success btn-sm" disabled>TAMPIL</button> 
                        <?php } ?>
                        <?php if($data['ujian_show'] != 1) { ?>
                            <button class="btn btn-secondary btn-sm" disabled>TIDAK</button> 
                        <?php } ?>
                    </td> -->
                    <td width="10%">
                        <button type="button" class="btn btn-warning" onclick="edit('<?= $data['program_id'] ?>')" >
                        <i class=" fa fa-edit mr-1"></i>Edit</button>
                        <!-- <a href="/program-regular-ujian-setting?id=<?= $data['program_id'] ?>"  class="btn btn-info ml-2" ><i class=" fa fa-wrench mr-1"></i>Fitur Ujian</a> -->
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodaltambah">
</div>

<div class="viewmodaledit">
</div>


<script>
    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('program-nonreg/input') ?>",
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

    function edit(program_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('program-nonreg/edit') ?>",
            data: {
                program_id : program_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaledit').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }
</script>
<?= $this->endSection('isi') ?>