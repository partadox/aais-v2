<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
<a> 
    <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Tambah Rek. Bank</button>
</a>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Bank</th>
                <th>Rekening Bank</th> 
                <th>Atas Nama</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="5%"><?= $nomor ?></td>
                    <td width="14%"><?= $data['nama_bank'] ?></td>
                    <td width="10%"><?= $data['rekening_bank'] ?></td>
                    <td width="10%"><?= $data['atas_nama_bank'] ?></td>
                    <td width="10%">
                        <button type="button" class="btn btn-warning btn-sm" onclick="edit('<?= $data['bank_id'] ?>')" >
                        <i class=" fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $data['bank_id'] ?>','<?= $data['nama_bank'] ?>')" >
                        <i class=" fa fa-trash"></i></button>
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
            url: "<?= site_url('bank/input') ?>",
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

    function edit(bank_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('bank/edit') ?>",
            data: {
                bank_id : bank_id
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

    function hapus(bank_id, nama_bank) {
        Swal.fire({
            title: 'Hapus Data Rekening Bank?',
            text: `Apakah anda yakin mmenghapus rekening bank ${nama_bank}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('bank/delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        bank_id : bank_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus rekening ini!",
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