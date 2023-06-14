<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?> ID <?= $bayar_id ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('pembayaran/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="bayar_id" value="<?= $bayar_id ?>" name="bayar_id" readonly>
                <p class="mt-3">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Semua form input wajib diisi, Isikan nominal 0 pada tipe pembayaran yang tidak diinginkan. <br>
                </p>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Nominal Bayar<code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="awal_bayar" name="awal_bayar" value="<?= $awal_bayar ?>">
                        <div class="invalid-feedback errorAwal_bayar"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Infaq<code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="awal_bayar_infaq" name="awal_bayar_infaq" value="<?= $awal_bayar_infaq ?>">
                        <div class="invalid-feedback errorInfaq"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Biaya Daftar<code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="awal_bayar_daftar" name="awal_bayar_daftar" value="<?= $awal_bayar_daftar ?>">
                        <div class="invalid-feedback errorDaftar"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-1<code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="awal_bayar_spp1" name="awal_bayar_spp1" value="<?= $awal_bayar_spp1 ?>">
                        <div class="invalid-feedback errorSpp1"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-2<code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="awal_bayar_spp2" name="awal_bayar_spp2" value="<?= $awal_bayar_spp2 ?>">
                        <div class="invalid-feedback errorSpp2"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-3<code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="awal_bayar_spp3" name="awal_bayar_spp3" value="<?= $awal_bayar_spp3 ?>">
                        <div class="invalid-feedback errorSpp3"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">SPP-4<code>*</code></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="awal_bayar_spp4" name="awal_bayar_spp4" value="<?= $awal_bayar_spp4 ?>">
                        <div class="invalid-feedback errorSpp4"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Keterangan Bayar Peserta</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="keterangan_bayar" name="keterangan_bayar" value="<?= $keterangan_bayar ?>">
                        <div class="invalid-feedback errorKeterangan_bayar"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Status Pembayaran<code>*</code></label>
                    <div class="col-sm-10">
                        <select class="form-control btn-square" id="status_bayar_admin" name="status_bayar_admin">
                            <option value="SESUAI BAYAR"  <?php if ($status_bayar_admin == 'SESUAI BAYAR') echo "selected"; ?> >SESUAI BAYAR</option>
                            <option value="KURANG BAYAR" <?php if ($status_bayar_admin == 'KURANG BAYAR') echo "selected"; ?>>KURANG BAYAR</option>
                            <option value="LEBIH BAYAR" <?php if ($status_bayar_admin == 'LEBIH BAYAR') echo "selected"; ?>>LEBIH BAYAR</option>
                            <option value="BELUM BAYAR" <?php if ($status_bayar_admin == 'BELUM BAYAR') echo "selected"; ?>>BELUM BAYAR</option>
                            <option value="BEBAS BIAYA" <?php if ($status_bayar_admin == 'BEBAS BIAYA') echo "selected"; ?>>BEBAS BIAYA</option>
                        </select>
                        <div class="invalid-feedback errorStatus_bayar_admin"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Keterangan Admin</label>
                    <div class="col-sm-10">
                        <input class="form-control text-uppercase" type="text-area" id="keterangan_bayar_admin" name="keterangan_bayar_admin" value="<?= $keterangan_bayar_admin ?>">
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
        });

        $(document).ready(function () {
            $('#awal_bayar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#awal_bayar_daftar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#awal_bayar_spp1').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#awal_bayar_infaq').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#awal_bayar_spp2').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#awal_bayar_spp3').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
            $('#awal_bayar_spp4').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
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
                        if (response.error.awal_bayar) {
                            $('#awal_bayar').addClass('is-invalid');
                            $('.errorAwal_bayar').html(response.error.awal_bayar);
                        } else {
                            $('#awal_bayar').removeClass('is-invalid');
                            $('.errorAwal_bayar').html('');
                        }

                        if (response.error.awal_bayar_infaq) {
                            $('#awal_bayar_infaq').addClass('is-invalid');
                            $('.errorInfaq').html(response.error.awal_bayar_infaq);
                        } else {
                            $('#awal_bayar_infaq').removeClass('is-invalid');
                            $('.errorInfaq').html('');
                        }

                        if (response.error.awal_bayar_daftar) {
                            $('#awal_bayar_daftar').addClass('is-invalid');
                            $('.errorDaftar').html(response.error.awal_bayar_daftar);
                        } else {
                            $('#awal_bayar_daftar').removeClass('is-invalid');
                            $('.errorDaftar').html('');
                        }

                        if (response.error.awal_bayar_spp1) {
                            $('#awal_bayar_spp1').addClass('is-invalid');
                            $('.errorSpp1').html(response.error.awal_bayar_spp1);
                        } else {
                            $('#awal_bayar_spp1').removeClass('is-invalid');
                            $('.errorSpp1').html('');
                        }

                        if (response.error.awal_bayar_spp2) {
                            $('#awal_bayar_spp2').addClass('is-invalid');
                            $('.errorSpp2').html(response.error.awal_bayar_spp2);
                        } else {
                            $('#awal_bayar_spp2').removeClass('is-invalid');
                            $('.errorSpp2').html('');
                        }

                        if (response.error.awal_bayar_spp3) {
                            $('#awal_bayar_spp3').addClass('is-invalid');
                            $('.errorSpp3').html(response.error.awal_bayar_spp3);
                        } else {
                            $('#awal_bayar_spp3').removeClass('is-invalid');
                            $('.errorSpp3').html('');
                        }

                        if (response.error.awal_bayar_spp4) {
                            $('#awal_bayar_spp4').addClass('is-invalid');
                            $('.errorSpp4').html(response.error.awal_bayar_spp4);
                        } else {
                            $('#awal_bayar_spp4').removeClass('is-invalid');
                            $('.errorSpp4').html('');
                        }

                        if (response.error.status_bayar_admin) {
                            $('#status_bayar_admin').addClass('is-invalid');
                            $('.errorStatus_bayar_admin').html(response.error.status_bayar_admin);
                        } else {
                            $('#status_bayar_admin').removeClass('is-invalid');
                            $('.errorStatus_bayar_admin').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Pembayaran",
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