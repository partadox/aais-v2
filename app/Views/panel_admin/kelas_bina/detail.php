<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> <?= $detail_kelas['bk_name'] ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<a href="<?= base_url('kelas-bina') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<button type="button" class="btn btn-primary mb-3" onclick="modal('peserta','<?= $detail_kelas['bk_id'] ?>')" ><i class=" fa fa-plus-circle"></i> Tambah Peserta</button>


<div class="mb-3">
    <h5 style="text-align:center;">Kelas <?= $detail_kelas['bk_name'] ?></h5>
    <h6 style="text-align:center;"><?= $detail_kelas['bk_hari'] ?>, <?= $detail_kelas['bk_waktu'] ?> <?= $detail_kelas['bk_timezone'] ?> - <?= $detail_kelas['bk_tm_methode'] ?></h6>
    <h6 style="text-align:center;">Jumlah Peserta = <?= $jumlah_peserta ?></h6> 
</div>
<hr>

<div class="row">
    <div class="col-md-6">
        <div class="card card-body shadow-lg">
            <div class="card-title">
                <h6>Pengajar</h6>
                <button type="button" class="btn btn-primary btn-sm" onclick="modal('pengajar','<?= $detail_kelas['bk_id'] ?>')" ><i class=" fa fa-plus-circle"></i> Tambah Pengajar</button>
                <hr>
            </div>
            <div class="card-text">
                <table class="table table-borderless table-sm">
                    <tbody>
                        <?php $nmr = 0;
                        foreach ($pengajar as $item) :
                        $nmr++;?>
                            <tr>
                                <td><?= $nmr ?>.</td>
                                <td><?= $item['nama_pengajar'] ?></td>
                                <td><button class="btn btn-danger btn-sm" onclick="hapus('pengajar','<?= $detail_kelas['bk_id'] ?>','<?= $item['bj_id'] ?>','<?= $item['nama_pengajar'] ?>')"><i class="fa fa-trash"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-body shadow-lg">
            <div class="card-title">
                <h6>Pengaturan Absensi</h6>
                <button class="btn btn-sm btn-warning" onclick="modal('absensi','<?= $detail_kelas['bk_id'] ?>')"> <i class="fa fa-screwdriver"></i> Pengaturan</button>
                <hr>
            </div>
            <div class="card-text">
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <td width="40%"><b>Jumlah TM</b></td>
                            <td><?= $detail_kelas['bk_tm_total'] ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Metode Absen</b></td>
                            <td><?= $detail_kelas['bk_absen_methode'] ?></td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Status Absen</b></td>
                            <td>
                                <?php if($detail_kelas['bk_absen_status'] == '0') { ?>
                                    <button class="btn btn-secondary btn-sm" disabled>Nonaktif</button> 
                                <?php } ?>
                                <?php if($detail_kelas['bk_absen_status'] == '1') { ?>
                                    <button class="btn btn-success btn-sm" disabled>Aktif</button> 
                                <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%"><b>Koordinator</b></td>
                            <td><?= $koor  ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>HP</th>
                <th>Status</th>
                <th>Tindakan</th>
            </tr>
        </thead>

        <tbody>
            <?php $nomor = 0;
            foreach ($peserta_onkelas as $data) :
                $nomor++; ?>
                <tr>
                    <td width="5%"><?= $nomor ?></td>
                    <td width="10%"><?= $data['nis'] ?></td>
                    <td width="10%"><?= $data['nik'] ?></td>
                    <td width="15%"><?= $data['nama_peserta'] ?></td>
                    <td width="10%"><?= $data['hp'] ?></td>
                    <td width="10%">
                        <?php if($data['bs_status'] == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($data['bs_status'] == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($data['bs_status'] == 'MENGULANG') { ?>
                            <button class="btn btn-success btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    </td>
                    <td width="2%">
                        <button class="btn btn-danger btn-sm" onclick="hapus('peserta','<?= $detail_kelas['bk_id'] ?>','<?= $data['bs_id'] ?>','<?= $data['nama_peserta'] ?>')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodal">
</div>

<script>
    function modal(modul,bk_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/kelas-bina/detail/modal') ?>",
            data: {
                modul : modul,
                bk_id : bk_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaldetail').modal('show');
                }
            }
        });
    }

    function hapus(modul, bk_id, id, nama) {
        Swal.fire({
            title: 'Yakin Hapus Data ini?',
            text: `Hapus data ${modul} nama ${nama}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('/kelas-bina/delete') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        modul : modul,
                        bk_id: bk_id,
                        id: id,
                        nama: nama
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus data ini!",
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