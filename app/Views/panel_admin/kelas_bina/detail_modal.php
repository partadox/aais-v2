<!-- Modal -->
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('kelas-bina/detail/update', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="modul" value="<?= $modul ?>" name="modul" readonly>
                <input type="hidden" class="form-control" id="bk_id" value="<?= $bina['bk_id'] ?>" name="bk_id" readonly>
                <?php if($modul == 'peserta') { ?>
                    <div class="form-group row">
                        <label for="bs_peserta" class="col-sm-4 col-form-label">Peserta <code>*</code></label>
                        <div class="col-sm-8">
                            <select name="bs_peserta[]" multiple="multiple" id="bs_peserta" class="js-example-basic-single">
                                <?php foreach ($peserta as $key => $data) { ?>
                                    <option value="<?= $data['peserta_id'] ?>"><?= $data['nis'] ?> - <?= $data['nama_peserta'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback error_bs_peserta"></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($modul == 'pengajar') { ?> 
                    <div class="form-group row">
                        <label for="bj_pengajar" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                        <div class="col-sm-8">
                            <select name="bj_pengajar[]" multiple="multiple" id="bj_pengajar" class="js-example-basic-single">
                                <?php foreach ($pengajar as $key => $item) { ?>
                                    <option value="<?= $item['pengajar_id'] ?>"><?= $item['nama_pengajar'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback error_bj_pengajar"></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($modul == 'absensi') { ?> 
                    <div class="form-group row">
                        <label for="bk_absen_status" class="col-sm-4 col-form-label">Status Absen<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="bk_absen_status" name="bk_absen_status">
                                <option value="1" <?php if ($bina['bk_absen_status'] == '1') echo "selected"; ?> >Aktif</option>
                                <option value="0" <?php if ($bina['bk_absen_status'] == '0') echo "selected"; ?>>Nonaktif</option>
                            </select>
                            <div class="invalid-feedback error_bk_absen_status"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Metode Absensi</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?= $bina['bk_absen_methode'] ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bk_absen_methode" class="col-sm-4 col-form-label">Ganti Metode Absen<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="bk_absen_methode" name="bk_absen_methode" onchange="showDiv(this)">
                                <option value="<?= $bina['bk_absen_methode'] ?>" readonly> ...PILIH... </option>
                                <option value="Perwakilan"> Perwakilan</option>
                                <option value="Mandiri"> Mandiri</option>
                            </select>
                            <div class="invalid-feedback error_bk_absen_methode"></div>
                        </div>
                    </div>
                    <div id="bk_absen" class="form-group row" style="display: none;">
                        <label for="bk_absen_koor" class="col-sm-6 col-form-label">Koordinator Absen Peserta <code>*</code></label>
                        <div class="col-sm-10">
                            <select name="bk_absen_koor[]"id="bk_absen_koor" class="js-example-basic-single">
                                <?php foreach ($koor as $key => $kr) { ?>
                                    <option value="<?= $kr['peserta_id'] ?>"  <?php if ($bina['bk_absen_koor'] == $kr['peserta_id'] ) echo "selected"; ?> ><?= $kr['nis'] ?> - <?= $kr['nama_peserta'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback error_bk_absen_koor"></div>
                        </div>
                    </div>
                    <div id="bk_absen_expired" class="form-group row" style="display: none;">
                        <label for="bk_absen_koor" class="col-sm-10 col-form-label">Batas Pengisian Absen Mandiri (dalam WITA) <code>*</code></label>
                        <div class="row ml-1 mr-1">
                            <div class="col-sm-6">
                                <div class="input-group" id="datepicker2">
                                    <input type="text" id="bk_absen_expiredtgl" name="bk_absen_expiredtgl" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                        data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                        data-provide="datepicker" data-date-autoclose="true" value="<?= date("Y-m-d") ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    <div class="invalid-feedback error_bk_absen_expiredtgl"></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="bk_absen_expiredwaktu" name="bk_absen_expiredwaktu" type="text" class="form-control time ui-timepicker-input">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                    </div>
                                </div>
                                <div class="invalid-feedback error_bk_absen_expiredwaktu"></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
                
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
    $('#bk_absen_expiredwaktu').timepicker({ 'timeFormat': 'H:i:s' });
    function showDiv(select){
        if(select.value=="Perwakilan"){
            document.getElementById('bk_absen').style.display = "block";
            } else{
            document.getElementById('bk_absen').style.display = "none";
        }
        if(select.value=="Mandiri"){
            document.getElementById('bk_absen_expired').style.display = "block";
            } else{
            document.getElementById('bk_absen_expired').style.display = "none";
        }
    } 
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modaldetail')
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    modul: $('input#modul').val(),
                    bk_id: $('input#bk_id').val(),
                    bs_peserta: $('select#bs_peserta').val(),
                    bj_pengajar: $('select#bj_pengajar').val(),
                    bk_absen_status: $('select#bk_absen_status').val(),
                    bk_absen_methode: $('select#bk_absen_methode').val(),
                    bk_absen_koor: $('select#bk_absen_koor').val(),
                    bk_absen_expired: $('input#bk_absen_expiredtgl').val()+' '+$('input#bk_absen_expiredwaktu').val(),
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

                        // if (response.error.bk_name) {
                        //     $('#bk_name').addClass('is-invalid');
                        //     $('.error_bk_name').html(response.error.bk_name);
                        // } else {
                        //     $('#bk_name').removeClass('is-invalid');
                        //     $('.error_bk_name').html('');
                        // }


                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.sukses.pesan,
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