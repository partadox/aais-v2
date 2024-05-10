<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <?php if ($jenis == "kelas") {?>
                <div class="modal-body">
                    <h5 style="text-align:center;"><?= $kelas['nama_kelas'] ?></h5>
                    <h6 style="text-align:center;">PESERTA <?= $peserta['nis'] ?> - <?= $peserta['nama_peserta'] ?></h6>
                    <h6 style="text-align:center;">PENGAJAR = <?= $nama_pengajar ?></h6>
                    <h6 style="text-align:center;"><?= $kelas['hari_kelas'] ?>, <?= $kelas['waktu_kelas'] ?> <?= $kelas['zona_waktu_kelas'] ?> - <?= $kelas['metode_kelas'] ?></h6>
                    <hr>
                    <?php if($program['ujian_show'] == NULL || $program['ujian_show'] =='0' ) { ?>
                        <h6 style="text-align:center;">BELUM ADA DATA</h6>
                    <?php } ?>
                    <?php if($ujian_status != '1' && $program['ujian_show'] == '1') { ?>
                    <strong>Status Kelulusan: </strong>
                        <?php if($kelulusan == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'MENGULANG') { ?>
                            <button class="btn btn-warning btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    <table class="table table-bordered mt-4">
                        <tbody>
                            <tr>
                                <th width="5%">Pelaksanaan Ujian: </th>
                                <th width="95%"><?= $ujian['tgl_ujian'] ?> <?= $ujian['waktu_ujian'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Nilai Ujian: </th>
                                <th width="95%"><?= $ujian['nilai_ujian'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Nilai Akhir: </th>
                                <th width="95%"><?= $ujian['nilai_akhir'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Rekomendasi level</th>
                                <th width="95%"><?= $ujian['next_level'] ?></th>
                            </tr>
                            <tr>
                                <th width="5%">Note dari Pengajar</th>
                                <th width="95%"><?= $ujian['ujian_note'] ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <?php if($ujian_status == '1' && $program['ujian_show'] == '1') { ?>
                    <strong>Status Kelulusan: </strong>
                        <?php if($kelulusan == 'BELUM LULUS') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>BELUM LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'LULUS') { ?>
                            <button class="btn btn-success btn-sm" disabled>LULUS</button> 
                        <?php } ?>
                        <?php if($kelulusan == 'MENGULANG') { ?>
                            <button class="btn btn-warning btn-sm" disabled>MENGULANG</button> 
                        <?php } ?>
                    <table class="table table-bordered mt-4">
                        <tbody>
                            <?php for ($i=1; $i <= 10; $i++): ?>
                                <?php
                                    $col_status = 'text'.$i.'_status';
                                    $col_name   = 'text'.$i.'_name'  ;

                                    $val        = 'ucv_text'.$i;
                                    if($ucc[$col_status] == '1') { ?>
                                        <tr>
                                            <th width="5%"><?= $ucc[$col_name] ?>: </th>
                                            <th width="95%"><?= $ujian[$val] ?></th>
                                        </tr>
                                    <?php } ?>
                            <?php endfor; ?>

                            <?php for ($i=1; $i <= 10; $i++): ?>
                                <?php
                                    $col_status = 'int'.$i.'_status';
                                    $col_name   = 'int'.$i.'_name'  ;

                                    $val        = 'ucv_int'.$i;
                                    if($ucc[$col_status] == '1') { ?>
                                        <tr>
                                            <th width="5%"><?= $ucc[$col_name] ?>: </th>
                                            <th width="95%"><?= $ujian[$val] ?></th>
                                        </tr>
                                    <?php } ?>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                <?php } ?>
            <?php }?>
            <?php if ($jenis == "konfirmasi") {?>
                <?= form_open('pembayaran/save-konfirmasi-sertifikat', ['class' => 'formkonfirmasi']) ?>
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <p class="mt-3">Catatan :<br> 
                        <i class="mdi mdi-information"></i> Lihat Bukti Bayar Dengan Teliti. <br>
                        <i class="mdi mdi-information"></i> Semua form input wajib diisi, jika nominal 0 input kembali dengan nominal 0. <br>
                    </p>
                    <input type="hidden" class="form-control" id="bayar_id" name="bayar_id" value="<?= $bayar_id ?>" disabled>
                    <input type="hidden" class="form-control" id="sertifikat_id" name="sertifikat_id" value="<?= $sertifikat['sertifikat_id'] ?>" disabled>
                    <input type="hidden" class="form-control" id="kelas_id" name="kelas_id" value="<?= $kelas_id ?>" disabled>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Total Nominal Transfer<code>*</code></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nominal_bayar" name="nominal_bayar" value="Rp <?= rupiah($pembayaran['nominal_bayar']) ?>">
                            <div class="invalid-feedback errorNominal_bayar"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Biaya Sertifikat<code>*</code></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="bayar_spp1" name="bayar_spp1" value="Rp <?= rupiah($pembayaran['awal_bayar_spp1']) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Infaq<code>*</code></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="bayar_infaq" name="bayar_infaq" value="Rp <?= rupiah($pembayaran['awal_bayar_infaq']) ?>">
                            <div class="invalid-feedback errorBayar_infaq"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Status Pembayaran<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="status_bayar_admin" name="status_bayar_admin" required>
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
                            <input type="text" class="form-control" value="<?= $pembayaran['keterangan_bayar'] ?>" readonly>
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
            <?php }?>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        $('#nominal_bayar').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
        $('#bayar_spp1').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
        $('#bayar_infaq').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0, allowZero:true});
    });


    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#modalkonfirmasi')
        });
        $('.formkonfirmasi').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    bayar_id: $('input#bayar_id').val(),
                    sertifikat_id: $('input#sertifikat_id').val(),
                    kelas_id: $('input#kelas_id').val(),
                    nominal_bayar: $('input#nominal_bayar').val(),
                    bayar_spp1: $('input#bayar_spp1').val(),
                    bayar_infaq: $('input#bayar_infaq').val(),
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