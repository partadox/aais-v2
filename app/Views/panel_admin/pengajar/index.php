<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<?php if ($user['level'] == 1) { ?>
    <a> 
        <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Tambah Pengajar</button>
    </a>

    <a> 
        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#importexcel" ><i class=" fa fa-file-excel"></i> Import File Excel</button>
    </a>
<?php } ?>

<a href="<?= base_url('pengajar/export') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-file-download"></i> Export Excel (Download)</button>
</a>

<?php if ($user['level'] == 1) { ?>
    <a> 
        <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#editbatch" ><i class=" fa fa-edit"></i> Multiple Edit</button>
    </a>
<?php } ?>

<div class="dropdown d-inline float-right">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class=" fa fa-file-alt mr-1"></i>
    Template
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="<?= base_url('public/assets/template/Template_Pengajar_v2.xlsx') ?>"> <i class=" fa fa-file-excel"></i> Import File Excel</a>
    <a class="dropdown-item" href="<?= base_url('public/assets/template/Template_Multiple_Edit_Pengajar_V2.xlsx') ?>"> <i class=" fa fa-edit"></i> Multiple Edit</a>
  </div>
</div>

<?php
if (session()->getFlashdata('pesan_error')) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <strong>';
    echo session()->getFlashdata('pesan_error');
    echo ' </strong> </div>';
}
?>

<?php
if (session()->getFlashdata('pesan_sukses')) {
    echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <strong>';
    echo session()->getFlashdata('pesan_sukses');
    echo ' </strong> </div>';
}
?>

<?= form_open('pengajar/deleteselect', ['class' => 'formhapus']) ?>

<?php if ($user['level'] == 1) { ?>
    <button type="submit" class="btn btn-danger btn">
        <i class="fa fa-trash"></i> Hapus yang Diceklist
    </button>
<?php } ?>

<hr>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="centangSemua">
                </th>
                <th>ID</th>
                <th>Nama</th>
                <th>Kantor</th>
                <th>Tipe</th> 
                <th>Jenis <br>Kelamin</th>
                <th>NIK</th>
                <th>Usia</th>
                <th>User Akun</th>
                <th>No. HP</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td  width="1%">
                        <input type="checkbox" name="pengajar_id[]" class="centangPengajarid" value="<?= $data['pengajar_id'] ?>"><?= $nomor ?>
                    </td>
                    <td width="1%"><?= $data['pengajar_id'] ?></td>
                    <td width="14%"><?= $data['nama_pengajar'] ?></td>
                    <td width="8%"><?= $data['nama_kantor'] ?></td>
                    <td width="8%">
                        <?php if($data['tipe_pengajar'] == 'PENGAJAR') { ?>
                            <button class="btn btn-success btn-sm" disabled>PENGAJAR</button> 
                        <?php } ?>
                        <?php if($data['tipe_pengajar'] == 'PENGUJI') { ?>
                            <button class="btn btn-info btn-sm" disabled>PENGUJI</button> 
                        <?php } ?>
                        <?php if($data['tipe_pengajar'] == 'PENGAJAR & PENGUJI') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>PENGAJAR & PENGUJI</button> 
                        <?php } ?>
                    </td>
                    <td width="8%"><?= $data['jenkel_pengajar'] ?></td>
                    <td width="8%"><?= $data['nik_pengajar'] ?></td>
                    <td width="5%"><?= umur($data['tgl_lahir_pengajar']) ?> Tahun</td>
                    <td width="8%">ID:<?= $data['user_id'] ?> - <b><?= $data['username'] ?> - 
                        <?php if($data['active'] == 0) { ?>
                            <span class="badge badge-secondary">Disable</span>
                        <?php } ?>
                        <?php if($data['active'] == 1) { ?>
                            <span class="badge badge-success">Aktif</span>
                        <?php } ?>
                    </b></td>
                    <td width="8%"><?= $data['hp_pengajar'] ?></td>
                    <td width="10%">
                        <button type="button" class="btn btn-sm btn-secondary" onclick="datadiri('<?= $data['pengajar_id'] ?>')" >
                        <i class=" fa fa-info"></i></button>
                        <?php if ($user['level'] == 1) { ?>
                            <button type="button" class="btn btn-sm btn-warning" onclick="edit('<?= $data['pengajar_id'] ?>')" >
                            <i class=" fa fa-edit"></i></button>
                            <button type="button" class="btn btn-sm btn-info" onclick="edit_akun('<?= $data['user_id'] ?>')" >
                            <i class=" fa fa-user"></i></button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $data['pengajar_id'] ?>', '<?= $data['nama_pengajar'] ?>')" >
                            <i class=" fa fa-trash"></i></button>
                        <?php } ?>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
    <?= form_close() ?>
</div>

<div class="viewmodaltambah">
</div>

<div class="viewmodaldatadiri">
</div>

<div class="viewmodaldataedit">
</div>

<div class="viewmodaleditakun">
</div>

<!-- Start Modal Import File Excel -->
<div class="modal fade" id="importexcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import File Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('/pengajar/import');
            ?>
            <?= csrf_field() ?>
            <input type="hidden" class="form-control" id="pst_or_pgj" value="peserta" name="pst_or_pgj" readonly>
            <div class="modal-body">
                <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Data import Excel maximal berisi 300 Data/Baris. Jika lebih maka data selebihnya akan gagal ter-import ke dalam sistem.<br>
                </p>
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" class="form-control" name="file_excel" accept=".xls, .xlsx">
                    </div>
            </div>    
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan"><i class="fa fa-file-upload"></i> Import</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?php echo form_close() ?>
        </div>
    </div>
</div>
<!-- End Modal Import File Excel -->

<!-- Start Modal Multiple Edit -->
<div class="modal fade" id="editbatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Multiple Edit Data Pengajar via File Excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('/pengajar/edit-multiple');
            ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Download file template yang disediakan untuk multiple edit data pengajar dari file excel.<br>
                    <i class="mdi mdi-information"></i> Download / Export Excel terlebih dahulu untuk mendapatkan <b>PENGAJAR ID</b>.<br>
                    <i class="mdi mdi-information"></i> Data multiple edit via Excel maximal berisi 300 Data/Baris. Jika lebih maka data selebihnya akan gagal ter-import ke dalam sistem.<br>
                </p>
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" class="form-control" name="file_excel" accept=".xls, .xlsx">
                    </div>
            </div>    
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning btnsimpan"><i class="fa fa-edit"></i> Edit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?php echo form_close() ?>
        </div>
    </div>
</div>
<!-- End Modal Multiple Edit -->

<script>

    $(document).ready(function() {

    $('#datatable').DataTable({
        "scrollY": "500px",
        "scrollX":  true,
        "scrollCollapse": true,
    });

    $('#centangSemua').click(function(e) {
        if ($(this).is(':checked')) {
            $('.centangPengajarid').prop('checked', true);
        } else {
            $('.centangPengajarid').prop('checked', false);
        }
    });

    $('.formhapus').submit(function(e) {
        e.preventDefault();
        let jmldata = $('.centangPengajarid:checked');
        if (jmldata.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Ooops!',
                text: 'Silahkan pilih data!',
                showConfirmButton: false,
                timer: 1500
            })
        } else {
            Swal.fire({
                title: 'Hapus data',
                text: `Apakah anda yakin ingin menghapus sebanyak ${jmldata.length} data?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil dihapus!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                            window.location = response.sukses.link;
                    });
                        }
                    });
                }
            })
        }
    });
    });

    function tambah() {
        $.ajax({
            type: "post",
            url: "<?= site_url('pengajar/input') ?>",
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

    function datadiri(pengajar_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pengajar/detail') ?>",
            data: {
                pengajar_id : pengajar_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaldatadiri').html(response.sukses).show();
                    $('#modaldatadiri').modal('show');
                }
            }
        });
    }

    function edit(pengajar_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pengajar/edit') ?>",
            data: {
                pengajar_id: pengajar_id
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

    function edit_akun(user_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('pengajar/edit_akun') ?>",
            data: {
                user_id: user_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaleditakun').html(response.sukses).show();
                    $('#modaleditakun').modal('show');
                }
            }
        });
    }

    function hapus(pengajar_id, nama_pengajar) {
        Swal.fire({
            title: 'Yakin Hapus Data Pengajar ini?',
            text: `Hapus Data ${nama_pengajar}? Data Kelas Terkait Data Pengajar ini Akan Hilang Juga.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('pengajar/delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        pengajar_id : pengajar_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus data pengajar ini!",
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