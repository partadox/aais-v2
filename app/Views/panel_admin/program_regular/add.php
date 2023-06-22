<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('program-regular/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Program <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nama_program" name="nama_program">
                        <div class="invalid-feedback errorNamaprogram"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Jenis Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="jenis_program" name="jenis_program">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="UMUM">UMUM</option>
                            <option value="KHUSUS">KHUSUS</option>
                            <option value="KEMITRAAN">KEMITRAAN</option>
                        </select>
                        <div class="invalid-feedback errorJenisprogram"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kategori Program <code>*untuk jenis umum</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="kategori_program" name="kategori_program">
                            <option value="REGULER" selected >REGULER</option>
                            <option value="NON-REGULER">NON-REGULER</option>
                            <option value="PEMBINAAN">PEMBINAAN</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Program <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="biaya_program" name="biaya_program">
                        <div class="invalid-feedback errorBiayaprogram"></div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Bulanan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="biaya_bulanan" name="biaya_bulanan">
                        <div class="invalid-feedback errorBiayabulanan"></div>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Daftar <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="biaya_daftar" name="biaya_daftar">
                        <div class="invalid-feedback errorBiayadaftar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Modul <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="biaya_modul" name="biaya_modul">
                        <div class="invalid-feedback errorBiayamodul"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_program" name="status_program">
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="aktif">AKTIF</option>
                            <option value="nonaktif">NONAKTIF</option>
                        </select>
                        <div class="invalid-feedback errorStatusprogram"></div>
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
        $('.js-example-basic-single').select2({
            
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    nama_program: $('input#nama_program').val(),
                    jenis_program: $('select#jenis_program').val(),
                    kategori_program: $('select#kategori_program').val(),
                    biaya_program: $('input#biaya_program').val(),
                    // biaya_bulanan: $('input#biaya_bulanan').val(),
                    biaya_daftar: $('input#biaya_daftar').val(),
                    biaya_modul: $('input#biaya_modul').val(),
                    status_program: $('select#status_program').val(),
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
                        if (response.error.nama_program) {
                            $('#nama_program').addClass('is-invalid');
                            $('.errorNamaprogram').html(response.error.nama_program);
                        } else {
                            $('#nama_program').removeClass('is-invalid');
                            $('.errorNamaprogram').html('');
                        }

                        if (response.error.jenis_program) {
                            $('#jenis_program').addClass('is-invalid');
                            $('.errorJenisprogram').html(response.error.jenis_program);
                        } else {
                            $('#jenis_program').removeClass('is-invalid');
                            $('.errorJenisprogram').html('');
                        }

                        if (response.error.biaya_program) {
                            $('#biaya_program').addClass('is-invalid');
                            $('.errorBiayaprogram').html(response.error.biaya_program);
                        } else {
                            $('#biaya_program').removeClass('is-invalid');
                            $('.errorBiayaprogram').html('');
                        }

                        // if (response.error.biaya_bulanan) {
                        //     $('#biaya_bulanan').addClass('is-invalid');
                        //     $('.errorBiayabulanan').html(response.error.biaya_bulanan);
                        // } else {
                        //     $('#biaya_bulanan').removeClass('is-invalid');
                        //     $('.errorBiayabulanan').html('');
                        // }

                        if (response.error.biaya_daftar) {
                            $('#biaya_daftar').addClass('is-invalid');
                            $('.errorBiayadaftar').html(response.error.biaya_daftar);
                        } else {
                            $('#biaya_daftar').removeClass('is-invalid');
                            $('.errorBiayadaftar').html('');
                        }

                        if (response.error.biaya_modul) {
                            $('#biaya_modul').addClass('is-invalid');
                            $('.errorBiayamodul').html(response.error.biaya_modul);
                        } else {
                            $('#biaya_modul').removeClass('is-invalid');
                            $('.errorBiayamodul').html('');
                        }

                        if (response.error.status_program) {
                            $('#status_program').addClass('is-invalid');
                            $('.errorStatusprogram').html(response.error.status_program);
                        } else {
                            $('#status_program').removeClass('is-invalid');
                            $('.errorStatusprogram').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Tambah Data Program Baru",
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

    $(document).ready(function () {
    $('#biaya_program').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    $('#biaya_daftar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    // $('#biaya_bulanan').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    $('#biaya_modul').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
  });
</script>