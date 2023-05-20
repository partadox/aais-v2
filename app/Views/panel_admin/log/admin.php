<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="table-responsive">
    <table id="datatable" class="table table-sm table-bordered mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th width="10%">Tanggal</th>
                <th width="10%">Jam</th> 
                <th width="10%">Admin</th>
                <th width="10%">Status</th>
                <th width="55%">Aktivitas</th>
            </tr>
        </thead>

        <tbody>
        <?php $nomor = 0;
            foreach ($list as $data) :
                $nomor++; ?>
                <tr>
                    <td width="2%"><?= $nomor ?></td>
                    <td width="5%"><?= shortdate_indo($data['tgl_log']) ?></td>
                    <td width="5%"><?= $data['waktu_log'] ?></td>
                    <td width="8%"><?= $data['username_log'] ?></td>
                    <td width="4%">
                        <?php if($data['status_log'] == NULL) { ?>
                           <p></p> 
                        <?php } ?>
                        <?php if($data['status_log'] == 'BERHASIL') { ?>
                            <button class="btn btn-success btn-sm" disabled>BERHASIL</button> 
                        <?php } ?>
                        <?php if($data['status_log'] == 'GAGAL') { ?>
                            <button class="btn btn-danger btn-sm" disabled>GAGAL</button> 
                        <?php } ?>
                    </td>
                    <td width="25%"><?= $data['aktivitas_log'] ?></td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<?= $this->endSection('isi') ?>