<!-- Modal -->
<div class="modal fade" id="modalabsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <?= form_open('/penguji/save-absen', ['class' => 'formatur']) ?>
            <?= csrf_field(); ?>
                <input type="hidden" class="form-control" id="kelas_id" value="<?= $kelas['kelas_id'] ?>" name="kelas_id" readonly>

                <?php if($kelas['absen_penguji'] != NULL) { ?>
                    <b>SUDAH ABSEN PADA:</b> <br>
                    <i class=" fa fa-check" style="color:green"></i> <?= longdate_indo(substr($kelas['absen_penguji'],0,10)) ?> <br> Pukul : <?= substr($kelas['absen_penguji'],11,5) ?> WITA
                    <br>
                    <hr>
                <?php } ?>

                <div id="expired_absen" class="form-group row">
                    <label for="bk_absen_koor" class="col-sm-10 col-form-label">Form Absensi Penguji (dalam WITA) <code>*</code></label>
                    <div class="row ml-1 mr-1">
                        <div class="col-sm-6 mb-2">
                            <div class="input-group" id="datepicker2">
                                <input type="text" id="absen_tgl" name="absen_tgl" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                    data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                    data-provide="datepicker" data-date-autoclose="true" value="<?= date("Y-m-d") ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-2">
                            <div class="input-group">
                                <input id="absen_waktu" name="absen_waktu" type="text" class="form-control time ui-timepicker-input">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                </div>
                                <div class="invalid-feedback error_absen_waktu"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnsimpan align-items-end mb-3"><i class="fa fa-share-square"></i> Simpan</button>
            <?= form_close() ?>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>

<script>
    $('#absen_waktu').timepicker({ 'timeFormat': 'H:i:s' });
    // function showDiv(select){
    //     if(select.value=="Mandiri"){
    //         document.getElementById('expired_absen').style.display = "block";
    //         document.getElementById('tm_absen').style.display = "block";
    //         } else{
    //         document.getElementById('expired_absen').style.display = "none";
    //         document.getElementById('tm_absen').style.display = "none";
    //     }
    // } 
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modalabsen'),
            minimumResultsForSearch: Infinity,
        });
        $('.formatur').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    kelas_id: $('input#kelas_id').val(),
                    absen_tgl: $('input#absen_tgl').val(),
                    absen_waktu: $('input#absen_waktu').val()
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

                        if (response.error.absen_tgl) {
                            $('#absen_tgl').addClass('is-invalid');
                            $('.error_absen_tgl').html(response.error.absen_tgl);
                        } else {
                            $('#absen_tgl').removeClass('is-invalid');
                            $('.error_absen_tgl').html('');
                        }

                        if (response.error.absen_waktu) {
                            $('#absen_waktu').addClass('is-invalid');
                            $('.error_absen_waktu').html(response.error.absen_waktu);
                        } else {
                            $('#absen_waktu').removeClass('is-invalid');
                            $('.error_absen_waktu').html('');
                        }


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