<!-- Modal -->
<div class="modal fade" id="modaldatadiri" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Nama </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['nama_peserta'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">NIS </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['nis'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">NIK </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['nik'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">TTL / Usia </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['tmp_lahir']  ?>, <?= shortdate_indo($peserta['tgl_lahir'])?> / <?= umur($peserta['tgl_lahir']) ?> Tahun" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Pendidikan </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['pendidikan'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Jurusan </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['jurusan'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Status Kerja </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" 
                        value="<?php if ($peserta['status_kerja'] == '0') echo "TIDAK BEKERJA" ?> <?php if ($peserta['status_kerja'] == '1') echo "BEKERJA" ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Pekerjaan </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['pekerjaan'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">HP </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['hp'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Email </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['email'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tgl. Daftar </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= shortdate_indo($peserta['tgl_gabung']) ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Domisili </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['domisili_peserta'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Alamat </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $peserta['alamat'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Catatan </label>
                    <div class="col-sm-8">
                        <textarea class="form-control" readonly><?= $peserta['peserta_note'] ?> </textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>