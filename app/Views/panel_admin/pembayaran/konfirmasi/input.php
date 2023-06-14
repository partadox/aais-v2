<!-- Modal -->
<div class="modal fade" id="modalkonfirmasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('pembayaran/save-konfirmasi', ['class' => 'formkonfirmasi']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                
                <p class="mt-3">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Lihat Bukti Bayar Dengan Teliti. <br>
                    <i class="mdi mdi-information"></i> Semua form input wajib diisi, jika nominal 0 input kembali dengan nominal 0. <br>
                </p>
                <input type="hidden" class="form-control" id="bayar_id" name="bayar_id" value="<?= $bayar_id ?>" disabled>
                <input type="hidden" class="form-control" id="kelas_id" name="kelas_id" value="<?= $kelas_id ?>" disabled>
                <input type="hidden" class="form-control" id="peserta_id" name="peserta_id" value="<?= $bayar_peserta_id ?>" disabled>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Total Nominal Transfer<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nominal_bayar" name="nominal_bayar" value="Rp <?= rupiah($awal_bayar) ?>">
                        <div class="invalid-feedback errorNominal_bayar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Daftar<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_daftar" name="bayar_daftar"  value="Rp <?= rupiah($awal_bayar_daftar) ?>">
                        <div class="invalid-feedback errorBayar_daftar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">SPP-1<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_spp1" name="bayar_spp1" value="Rp <?= rupiah($awal_bayar_spp1) ?>">
                        <div class="invalid-feedback errorBayar_spp1"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">SPP-2<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_spp2" name="bayar_spp2" value="Rp <?= rupiah($awal_bayar_spp2) ?>">
                        <div class="invalid-feedback errorBayar_spp2"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">SPP-3<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_spp3" name="bayar_spp3" value="Rp <?= rupiah($awal_bayar_spp3) ?>">
                        <div class="invalid-feedback errorBayar_spp3"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">SPP-4<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_spp4" name="bayar_spp4" value="Rp <?= rupiah($awal_bayar_spp4) ?>">
                        <div class="invalid-feedback errorBayar_spp4"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Infaq<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_infaq" name="bayar_infaq" value="Rp <?= rupiah($awal_bayar_infaq) ?>">
                        <div class="invalid-feedback errorBayar_infaq"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Modul<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_modul" name="bayar_modul" value="Rp <?= rupiah($awal_bayar_modul) ?>">
                        <div class="invalid-feedback errorBayar_modul"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Lainnya (Marchendise, dsb)<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="bayar_lain" name="bayar_lain" value="Rp <?= rupiah($awal_bayar_lainnya) ?>">
                        <div class="invalid-feedback errorBayar_lain"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Pembayaran<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_bayar_admin" name="status_bayar_admin">
                            <option value="" disabled selected>-- PILIH --</option>
                            <option value="SESUAI BAYAR" >SESUAI BAYAR</option>
                            <option value="KURANG BAYAR">KURANG BAYAR</option>
                            <option value="LEBIH BAYAR">LEBIH BAYAR</option>
                            <option value="BELUM BAYAR">BELUM BAYAR</option>
                            <option value="BEBAS BIAYA">BEBAS BIAYA</option>
                        </select>
                        <div class="invalid-feedback errorStatus_bayar_admin"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Keterangan Dari Peserta</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= $keterangan_bayar ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Keterangan Admin</label>
                    <div class="col-sm-8">
                        <input class="form-control text-uppercase" type="text-area" id="keterangan_bayar_admin" name="keterangan_bayar_admin" placeholder="Masukan Keterangan Pengiring (jika ada)">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan"><i class="fa fa-check"></i> Konfirmasi</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
    $('#nominal_bayar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    $('#bayar_daftar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#bayar_spp1').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#bayar_spp2').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#bayar_spp3').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#bayar_spp4').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#bayar_infaq').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#bayar_modul').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
      $('#bayar_lain').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
  });


    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: "bootstrap4"
        });
        $('.formkonfirmasi').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    bayar_id: $('input#bayar_id').val(),
                    kelas_id: $('input#kelas_id').val(),
                    peserta_id: $('input#peserta_id').val(),
                    nominal_bayar: $('input#nominal_bayar').val(),
                    bayar_daftar: $('input#bayar_daftar').val(),
                    bayar_spp1: $('input#bayar_spp1').val(),
                    bayar_spp2: $('input#bayar_spp2').val(),
                    bayar_spp3: $('input#bayar_spp3').val(),
                    bayar_spp4: $('input#bayar_spp4').val(),
                    bayar_infaq: $('input#bayar_infaq').val(),
                    bayar_modul: $('input#bayar_modul').val(),
                    bayar_lain: $('input#bayar_lain').val(),
                    status_bayar_admin: $('select#status_bayar_admin').val(),
                    keterangan_bayar_admin: $('input#keterangan_bayar_admin').val(),
                },
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
                        if (response.error.nominal_bayar) {
                            $('#nominal_bayar').addClass('is-invalid');
                            $('.errorNominal_bayar').html(response.error.nominal_bayar);
                        } else {
                            $('#nominal_bayar').removeClass('is-invalid');
                            $('.errorNominal_bayar').html('');
                        }
                        if (response.error.bayar_daftar) {
                            $('#bayar_daftar').addClass('is-invalid');
                            $('.errorBayar_daftar').html(response.error.bayar_daftar);
                        } else {
                            $('#bayar_daftar').removeClass('is-invalid');
                            $('.errorBayar_daftar').html('');
                        }
                        if (response.error.bayar_infaq) {
                            $('#bayar_infaq').addClass('is-invalid');
                            $('.errorBayar_infaq').html(response.error.bayar_infaq);
                        } else {
                            $('#bayar_infaq').removeClass('is-invalid');
                            $('.errorBayar_infaq').html('');
                        }
                        if (response.error.bayar_spp3) {
                            $('#bayar_spp3').addClass('is-invalid');
                            $('.errorBayar_spp3').html(response.error.bayar_spp3);
                        } else {
                            $('#bayar_spp3').removeClass('is-invalid');
                            $('.errorBayar_spp3').html('');
                        }
                        if (response.error.bayar_spp1) {
                            $('#bayar_spp1').addClass('is-invalid');
                            $('.errorBayar_spp1').html(response.error.bayar_spp1);
                        } else {
                            $('#bayar_spp1').removeClass('is-invalid');
                            $('.errorBayar_spp1').html('');
                        }
                        if (response.error.bayar_spp2) {
                            $('#bayar_spp2').addClass('is-invalid');
                            $('.errorBayar_spp2').html(response.error.bayar_spp2);
                        } else {
                            $('#bayar_spp2').removeClass('is-invalid');
                            $('.errorBayar_spp2').html('');
                        }
                        if (response.error.bayar_spp4) {
                            $('#bayar_spp4').addClass('is-invalid');
                            $('.errorBayar_spp4').html(response.error.bayar_spp4);
                        } else {
                            $('#bayar_spp4').removeClass('is-invalid');
                            $('.errorBayar_spp4').html('');
                        }
                        if (response.error.bayar_modul) {
                            $('#bayar_modul').addClass('is-invalid');
                            $('.errorBayar_modul').html(response.error.bayar_modul);
                        } else {
                            $('#bayar_modul').removeClass('is-invalid');
                            $('.errorBayar_modul').html('');
                        }
                        if (response.error.bayar_lain) {
                            $('#bayar_lain').addClass('is-invalid');
                            $('.errorBayar_lain').html(response.error.bayar_lain);
                        } else {
                            $('#bayar_lain').removeClass('is-invalid');
                            $('.errorBayar_lain').html('');
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
                            text: "Pembayaran Berhasil Dikonfirmasi",
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