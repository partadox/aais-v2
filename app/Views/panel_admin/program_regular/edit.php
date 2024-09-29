<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('program-regular/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="program_id" value="<?= $program['program_id'] ?>" name="program_id" readonly>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Program <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" value="<?= $program['nama_program'] ?>" id="nama_program" name="nama_program">
                        <div class="invalid-feedback errorNamaprogram"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Jenis Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="jenis_program" name="jenis_program">
                            <option value="UMUM"  <?php if ($program['jenis_program'] == 'UMUM') echo "selected"; ?>>UMUM</option>
                            <option value="KHUSUS" <?php if ($program['jenis_program'] == 'KHUSUS') echo "selected"; ?>>KHUSUS</option>
                            <option value="KEMITRAAN" <?php if ($program['jenis_program'] == 'KEMITRAAN') echo "selected"; ?>>KEMITRAAN</option>
                        </select>
                        <div class="invalid-feedback errorJenisprogram"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kategori Program <code>*untuk jenis umum</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="kategori_program" name="kategori_program">
                            <option value="REGULER" <?php if ($program['kategori_program'] == 'REGULER') echo "selected"; ?> >REGULER</option>
                            <!-- <option value="NON-REGULER" <?php if ($program['kategori_program'] == 'NON-REGULER') echo "selected"; ?> >NON-REGULER</option> -->
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Program <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= rupiah($program['biaya_program']) ?>" id="biaya_program" name="biaya_program">
                        <div class="invalid-feedback errorBiayaprogram"></div>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Bulanan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= rupiah($program['biaya_bulanan']) ?>" id="biaya_bulanan" name="biaya_bulanan">
                        <div class="invalid-feedback errorBiayabulanan"></div>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Daftar <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= rupiah($program['biaya_daftar']) ?>" id="biaya_daftar" name="biaya_daftar">
                        <div class="invalid-feedback errorBiayadaftar"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Biaya Modul <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?= rupiah($program['biaya_modul']) ?>" id="biaya_modul" name="biaya_modul">
                        <div class="invalid-feedback errorBiayamodul"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Kode Program (utk Sertifikat max 3 huruf) <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" maxlength="3" value="<?= $program['kode_program'] ?>" id="kode_program" name="kode_program" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="status_program" name="status_program">
                            <option value="aktif" <?php if ($program['status_program'] == 'aktif') echo "selected"; ?> >AKTIF</option>
                            <option value="nonaktif" <?php if ($program['status_program'] == 'nonaktif') echo "selected"; ?> >NONAKTIF</option>
                        </select>
                        <div class="invalid-feedback errorStatusprogram"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">List Pengajuan Sertifikat <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="sert_status" name="sert_status">
                            <option value="1" <?php if ($program['sert_status'] == '1') echo "selected"; ?> >TAMPIL</option>
                            <option value="0" <?php if ($program['sert_status'] != '1') echo "selected"; ?> >TIDAK</option>
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
        $('.js-example-basic-single').select2({
            
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
                            text:  "Berhasil Edit Data Program",
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