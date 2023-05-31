<!-- Modal -->
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('kelas-nonreg/detail/update', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="modul" value="<?= $modul ?>" name="modul" readonly>
                <input type="hidden" class="form-control" id="nk_id" value="<?= $nonreg['nk_id'] ?>" name="nk_id" readonly>
                <?php if($modul == 'peserta') { ?>
                    <div class="form-group row">
                        <label for="ns_peserta" class="col-sm-4 col-form-label">Peserta <code>*</code></label>
                        <div class="col-sm-8">
                            <select name="ns_peserta[]" multiple="multiple" id="ns_peserta" class="js-example-basic-single">
                                <?php foreach ($peserta as $key => $data) { ?>
                                    <option value="<?= $data['peserta_id'] ?>"><?= $data['nis'] ?> - <?= $data['nama_peserta'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback error_ns_peserta"></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($modul == 'pengajar') { ?> 
                    <div class="form-group row">
                        <label for="nj_pengajar" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                        <div class="col-sm-8">
                            <select name="nj_pengajar[]" multiple="multiple" id="nj_pengajar" class="js-example-basic-single">
                                <?php foreach ($pengajar as $key => $item) { ?>
                                    <option value="<?= $item['pengajar_id'] ?>"><?= $item['nama_pengajar'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback error_nj_pengajar"></div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($modul == 'absensi') { ?> 
                    <div class="form-group row">
                        <label for="nk_absen_status" class="col-sm-4 col-form-label">Status Absen<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="nk_absen_status" name="nk_absen_status">
                                <option value="1" <?php if ($nonreg['nk_absen_status'] == '1') echo "selected"; ?> >Aktif</option>
                                <option value="0" <?php if ($nonreg['nk_absen_status'] == '0') echo "selected"; ?>>Nonaktif</option>
                            </select>
                            <div class="invalid-feedback error_nk_absen_status"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nk_absen_methode" class="col-sm-4 col-form-label">Metode Absen<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="nk_absen_methode" name="nk_absen_methode" onchange="showDiv(this)">
                                <option value="Perwakilan" <?php if ($nonreg['nk_absen_methode'] == 'Perwakilan') echo "selected"; ?> >Perwakilan</option>
                                <option value="Mandiri" <?php if ($nonreg['nk_absen_methode'] == 'Mandiri') echo "selected"; ?> >Mandiri</option>
                            </select>
                            <div class="invalid-feedback error_nk_absen_methode"></div>
                        </div>
                    </div>
                    <div id="nk_absen" class="form-group row" style="display: none;">
                        <label for="nk_absen_koor" class="col-sm-6 col-form-label">Koordinator Absen Peserta <code>*</code></label>
                        <div class="col-sm-10">
                            <select name="nk_absen_koor[]"id="nk_absen_koor" class="js-example-basic-single">
                                <?php foreach ($koor as $key => $kr) { ?>
                                    <option value="<?= $kr['peserta_id'] ?>"  <?php if ($nonreg['nk_absen_koor'] == $kr['peserta_id'] ) echo "selected"; ?> ><?= $kr['nis'] ?> - <?= $kr['nama_peserta'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback error_nk_absen_koor"></div>
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
    function showDiv(select){
        if(select.value=="Perwakilan"){
            document.getElementById('nk_absen').style.display = "block";
            } else{
            document.getElementById('nk_absen').style.display = "none";
        }
    } 
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: "bootstrap4"
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    modul: $('input#modul').val(),
                    nk_id: $('input#nk_id').val(),
                    ns_peserta: $('select#ns_peserta').val(),
                    nj_pengajar: $('select#nj_pengajar').val(),
                    nk_absen_status: $('select#nk_absen_status').val(),
                    nk_absen_methode: $('select#nk_absen_methode').val(),
                    nk_absen_koor: $('select#nk_absen_koor').val(),
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

                        // if (response.error.nk_name) {
                        //     $('#nk_name').addClass('is-invalid');
                        //     $('.error_nk_name').html(response.error.nk_name);
                        // } else {
                        //     $('#nk_name').removeClass('is-invalid');
                        //     $('.error_nk_name').html('');
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