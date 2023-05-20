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
                        <input type="text" class="form-control" value="<?= $pengajar['nama_pengajar'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tempat Lahir </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['tmp_lahir_pengajar'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tanggal Lahir </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= shortdate_indo($pengajar['tgl_lahir_pengajar']) ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Suku Bangsa </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['suku_bangsa'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Status Nikah </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['status_nikah'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Jumlah Anak </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['jumlah_anak'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Pendidikan </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['pendidikan_pengajar'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Jurusan </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['jurusan_pengajar']?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Email </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['email_pengajar'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Alamat </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $pengajar['alamat_pengajar']?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tanggal Gabung </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= shortdate_indo($pengajar['tgl_gabung_pengajar']) ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>