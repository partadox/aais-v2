<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> <?= $detail_kelas['nama_kelas'] ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<!-- <a> 
    <button type="button" class="btn btn-primary mb-3" onclick="tambah('')" ><i class=" fa fa-plus-circle"></i> Masukan Peserta Pindah</button>
</a> -->
<a href="<?= base_url('kelas-regular') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<h5 style="text-align:center;">Kelas <?= $detail_kelas['nama_kelas'] ?></h5>
<h6 style="text-align:center;"><?= $detail_kelas['hari_kelas'] ?>, <?= $detail_kelas['waktu_kelas'] ?> - <?= $detail_kelas['metode_kelas'] ?></h6>
<h6 style="text-align:center;"><?= $pengajar['nama_pengajar'] ?></h6>
<h6 style="text-align:center;">Jumlah Peserta = <?= $jumlah_peserta ?></h6>

<div class="table-responsive">
    <table id="datatable" class="table table-striped table-bordered nowrap mt-1" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>No.</th>
                <th>NIS</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Domisili</th>
                <th>HP</th>
                <th>Status</th>
                <th>Status SPP</th>
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
                    <td width="10%"><?= $data['domisili_peserta'] ?></td>
                    <td width="10%"><?= $data['hp'] ?></td>
                    <td width="10%">
                        <?php if($data['status_peserta_kelas'] == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($data['status_peserta_kelas'] == 'MENGULANG') { ?>
                            <button class="btn btn-success btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    </td>
                    <td width="10%">
                        <?php if(($data['biaya_daftar'] + $data['biaya_program']) - ($data['byr_daftar'] + $data['byr_spp1'] + $data['byr_spp2'] + $data['byr_spp3'] + $data['byr_spp4'] ) != 0) { ?>
                            <button class="btn btn-warning btn-sm mb-2" disabled>BELUM LUNAS</button>
                        <?php } ?>
                        <?php if(($data['biaya_daftar'] + $data['biaya_program']) - ($data['byr_daftar'] + $data['byr_spp1'] + $data['byr_spp2'] + $data['byr_spp3'] + $data['byr_spp4'] ) == 0) { ?>
                            <button class="btn btn-success btn-sm mb-2" disabled>LUNAS</button>
                        <?php } ?>
                    </td>
                    <td width="8%">
                        <?php if($data['spp_status'] == 'BELUM BAYAR PENDAFTARAN') { ?>
                            
                        <?php } ?>
                        <?php if($data['spp_status'] != 'BELUM BAYAR PENDAFTARAN') { ?>
                            <button type="button" class="btn btn-warning btn-pindah" data-item="<?= $data['peserta_kelas_id'] ?>">
                            <i class=" fa fa-sign-in-alt mr-1"></i>Pindah</button>
                            <button type="button" class="btn btn-danger btn-hapus" data-item="<?= $data['peserta_kelas_id'] ?>,<?= $data['nama_peserta'] ?>">
                            <i class=" fa fa-trash"></i></button>
                        <?php } ?>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="viewmodalpindah">
</div>

<script>

    $(document).on('click','.btn-hapus',function(e){
        e.preventDefault()
        let peserta_kelas_id = $(this).data("item")
        let nama_peserta = $(this).data("item")
        hapus(peserta_kelas_id,nama_peserta)
    })

    $(document).on('click','.btn-pindah',function(e){
        e.preventDefault()
        let peserta_kelas_id = $(this).data("item")
        pindah(peserta_kelas_id)
    })


    function pindah(peserta_kelas_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('kelas-regular/input-move') ?>",
            data: {
                peserta_kelas_id : peserta_kelas_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalpindah').html(response.sukses).show();
                    $('#modalpindah').modal('show');
                }
            }
        });
    }

    function hapus(peserta_kelas_id,nama_peserta) {
        Swal.fire({
            title: 'Hapus Data Peserta di Kelas Ini?',
            text: `Hapus data ${nama_peserta} kelas ini akan berdampak pada terhapusnya data absen peserta`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('kelas-regular/delete-peserta') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        peserta_kelas_id : peserta_kelas_id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil menghapus peserta dari kelas ini ini!",
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