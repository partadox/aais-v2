<!-- Modal -->
<div class="modal fade" id="modalatur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Pengajar Dapat Mengubah</button>
                        <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Absen Mandiri</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <?= form_open('/kelas-regular/update-atur-absensi-config', ['class' => 'formaturconf']) ?>
                        <?= csrf_field(); ?>
                        <input type="hidden" class="form-control" id="kelas_id" value="<?= $kelas['kelas_id'] ?>" name="kelas_id" readonly>
                        <label for="bk_absen_methode" class="col-sm-12 col-form-label">Pengajar Dapat Mengganti Metode Absen?</label>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <select class="form-control btn-square js-example-basic-single" id="config_absen" name="config_absen">
                                    <option value=1 <?php if ($kelas['config_absen'] == 1) echo "selected"; ?> > BISA</option>
                                    <option value=0 <?php if ($kelas['config_absen'] != 1) echo "selected"; ?> > TIDAK BISA</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary btnubah"><i class="fa fa-share-square"></i> Ubah</button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <?= form_open('/kelas-regular/update-atur-absensi', ['class' => 'formatur']) ?>
                        <?= csrf_field(); ?>
                            <input type="hidden" class="form-control" id="kelas_id" value="<?= $kelas['kelas_id'] ?>" name="kelas_id" readonly>
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <p><strong>
                                            <?php if(strtotime(date('Y-m-d H:i:s')) > strtotime($kelas['expired_absen'])) { ?>
                                                <a style="color: red;">TIDAK AKTIF</a>
                                            <?php } ?>
                                            <?php if(strtotime(date('Y-m-d H:i:s')) <= strtotime($kelas['expired_absen'])) { ?>
                                                <a style="color: green;">AKTIF</a> <br>
                                                TM Ke-<?= $kelas['tm_absen'] ?> <br>
                                                Batas Waktu: <?= $kelas['expired_absen'] ?> WITA
                                            <?php } ?>
                                        </strong></p>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none;">
                                    <label for="bk_absen_methode" class="col-sm-4 col-form-label">Ganti Metode Absen</label>
                                    <div class="col-sm-8">
                                        <select class="form-control btn-square js-example-basic-single" id="metode_absen" name="metode_absen">
                                            <option value="Mandiri" selected> Mandiri</option>
                                        </select>
                                        <div class="invalid-feedback error_metode_absen"></div>
                                    </div>
                                </div>
                                
                                <div id="tm_absen" class="form-group row">
                                    <label for="bk_absen_methode" class="col-sm-4 col-form-label">Pilih TM<code>*</code></label>
                                    <div class="col-sm-8">
                                        <select class="form-control btn-square js-example-basic-single" id="tm_absen" name="tm_absen">
                                            <?php for ($i = 1; $i <= 16; $i++): ?>
                                                <option value=<?= $i ?> > TM Ke-<?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <div class="invalid-feedback error_tm_absen"></div>
                                    </div>
                                </div>

                                <div id="expired_absen" class="form-group row">
                                    <label for="bk_absen_koor" class="col-sm-10 col-form-label">Batas Pengisian Absen Mandiri (dalam WITA) <code>*</code></label>
                                    <div class="row ml-1 mr-1">
                                        <div class="col-sm-6 mb-2">
                                            <div class="input-group" id="datepicker2">
                                                <input type="text" id="expired_absen_tgl" name="expired_absen_tgl" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                                    data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                                    data-provide="datepicker" data-date-autoclose="true" value="<?= date("Y-m-d") ?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <div class="input-group">
                                                <input id="expired_absen_waktu" name="expired_absen_waktu" type="text" class="form-control time ui-timepicker-input">
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                                </div>
                                                <div class="invalid-feedback error_expired_absen_waktu"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btnsimpan align-items-end mb-3"><i class="fa fa-share-square"></i> Simpan</button>
                        <?= form_close() ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>

<script>
    $('#expired_absen_waktu').timepicker({ 'timeFormat': 'H:i:s' });
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
            dropdownParent: $('#modalatur'),
            minimumResultsForSearch: Infinity,
        });
        $('.formatur').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    kelas_id: $('input#kelas_id').val(),
                    metode_absen: $('select#metode_absen').val(),
                    tm_absen: $('select#tm_absen').val(),
                    expired_absen_waktu: $('input#expired_absen_waktu').val(),
                    expired_absen: $('input#expired_absen_tgl').val()+' '+$('input#expired_absen_waktu').val(),
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

                        if (response.error.expired_absen_waktu) {
                            $('#expired_absen_waktu').addClass('is-invalid');
                            $('.error_expired_absen_waktu').html(response.error.expired_absen_waktu);
                        } else {
                            $('#expired_absen_waktu').removeClass('is-invalid');
                            $('.error_expired_absen_waktu').html('');
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
        $('.formaturconf').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    kelas_id: $('input#kelas_id').val(),
                    config_absen: $('select#config_absen').val(),
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btnubah').attr('disable', 'disable');
                    $('.btnubah').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnubah').removeAttr('disable', 'disable');
                    $('.btnubah').html('<i class="fa fa-share-square"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {


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