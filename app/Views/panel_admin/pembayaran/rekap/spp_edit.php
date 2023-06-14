<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('pembayaran/rekap-spp-update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="peserta_kelas_id" value="<?= $peserta_kelas_id ?>" name="peserta_kelas_id" readonly>
                <input type="hidden" class="form-control" id="total_biaya" value="<?= $total_biaya ?>" name="total_biaya" readonly>
                <p class="mt-3">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Semua form input wajib diisi, Isikan nominal 0 pada tipe pembayaran yang tidak diinginkan. <br>
                </p>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">NIS / Nama</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="<?= $nis ?>" disabled>
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" value="<?= $nama_peserta ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nama Kelas</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $nama_kelas ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Pendaftaran</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="byr_daftar" name="byr_daftar" value="<?= $byr_daftar ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Modul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="byr_modul" name="byr_modul" value="<?= $byr_modul ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-1</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="byr_spp1" name="byr_spp1" value="<?= $byr_spp1 ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-2</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="byr_spp2" name="byr_spp2" value="<?= $byr_spp2 ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-3</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="byr_spp3" name="byr_spp3" value="<?= $byr_spp3 ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-4</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="byr_spp4" name="byr_spp4" value="<?= $byr_spp4 ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Keaktifan Peserta</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status_aktif_peserta" name="status_aktif_peserta">
                          <option value=""  <?php if ($status_aktif_peserta == NULL) echo "selected"; ?>>AKTIF</option>
                          <option value="OFF" <?php if ($status_aktif_peserta == 'OFF') echo "selected"; ?>>OFF</option>
                        </select>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single-edit').select2({
            theme: "bootstrap4"
        });

        $(document).ready(function () {
            $('#byr_daftar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
            $('#byr_modul').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#byr_spp1').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#byr_spp2').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#byr_spp3').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#byr_spp4').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
        });

        $('.formedit').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnsimpan').attr('disable', 'disable');
                    $('.btnsimpan').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnsimpan').removeAttr('disable', 'disable');
                    $('.btnsimpan').html('<i class="fa fa-share-square"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Rekap Pembayaran SPP",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                                window.location = response.sukses.link;
                        });
                    }
                }
            });
        })
    });
</script>