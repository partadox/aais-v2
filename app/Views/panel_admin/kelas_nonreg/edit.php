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
            <?= form_open('kelas-nonreg/update', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
            <!-- <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Nama Kelas Harus Unik, Format Penamaan Angkatan-Level-Jenkel-Waktu. Contoh A01-TAJWIDI-1-AKHWAT-SENIN18 <br> -->
                </p>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">NIK <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_id" name="nk_id" value="<?= $nonreg['nk_id'] ?>" readonly>
                        <div class="invalid-feedback errorNamakelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="program_id" id="program_id" class="select2SearchEdit" required>
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($program as $key => $data) { ?>
                                <option value="<?= $data['program_id'] ?>" <?php if ($data['nama_program'] == $nonreg['nk_program']) echo "selected"; ?> > <?= $data['nama_program'] ?> - <?= $data['jenis_program'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_nama" name="nk_nama" value="<?= $nonreg['nk_nama'] ?>" required>
                        <div class="invalid-feedback errorNamakelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_angkatan" name="nk_angkatan" value="<?= $nonreg['nk_angkatan'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Bidang Usaha/Kegiatan <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="nk_usaha" id="nk_usaha" class="select2SearchEdit" required>
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($usaha as $key => $data) { ?>
                                <option value="<?= $data['nu_usaha'] ?>" <?php if ($data['nu_usaha'] == $nonreg['nk_usaha']) echo "selected"; ?> ><?= $data['nu_usaha'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="nk_pengajar" id="nk_pengajar" class="select2SearchEdit" required>
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($pengajar as $key => $data) { ?>
                                <option value="<?= $data['pengajar_id'] ?>" <?php if ($data['pengajar_id'] == $nonreg['nk_pengajar']) echo "selected"; ?> ><?= $data['nama_pengajar'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_hari" name="nk_hari" required>
                            <option value="SENIN" <?php if ($nonreg['nk_hari'] == 'SENIN') echo "selected"; ?> >SENIN</option>
                            <option value="SELASA" <?php if ($nonreg['nk_hari'] == 'SELASA') echo "selected"; ?> >SELASA</option>
                            <option value="RABU" <?php if ($nonreg['nk_hari'] == 'RABU') echo "selected"; ?> >RABU</option>
                            <option value="KAMIS" <?php if ($nonreg['nk_hari'] == 'KAMIS') echo "selected"; ?> >KAMIS</option>
                            <option value="JUMAT" <?php if ($nonreg['nk_hari'] == 'JUMAT') echo "selected"; ?> >JUMAT</option>
                            <option value="SABTU" <?php if ($nonreg['nk_hari'] == 'SABTU') echo "selected"; ?> >SABTU</option>
                            <option value="MINGGU" <?php if ($nonreg['nk_hari'] == 'MINGGU') echo "selected"; ?> >MINGGU</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_waktu" name="nk_waktu" required>
                            <option value="05:00" <?php if ($nonreg['nk_waktu'] == '05:00') echo "selected"; ?> >05:00</option>
                            <option value="06:00" <?php if ($nonreg['nk_waktu'] == '06:00') echo "selected"; ?> >06:00</option>
                            <option value="07:00" <?php if ($nonreg['nk_waktu'] == '07:00') echo "selected"; ?> >07:00</option>
                            <option value="08:00" <?php if ($nonreg['nk_waktu'] == '08:00') echo "selected"; ?> >08:00</option>
                            <option value="09:00" <?php if ($nonreg['nk_waktu'] == '09:00') echo "selected"; ?> >09:00</option>
                            <option value="10:00" <?php if ($nonreg['nk_waktu'] == '10:00') echo "selected"; ?> >10:00</option>
                            <option value="11:00" <?php if ($nonreg['nk_waktu'] == '11:00') echo "selected"; ?> >11:00</option>
                            <option value="12:00" <?php if ($nonreg['nk_waktu'] == '12:00') echo "selected"; ?> >12:00</option>
                            <option value="13:00" <?php if ($nonreg['nk_waktu'] == '13:00') echo "selected"; ?> >13:00</option>
                            <option value="14:00" <?php if ($nonreg['nk_waktu'] == '14:00') echo "selected"; ?> >14:00</option>
                            <option value="15:00" <?php if ($nonreg['nk_waktu'] == '15:00') echo "selected"; ?> >15:00</option>
                            <option value="16:00" <?php if ($nonreg['nk_waktu'] == '16:00') echo "selected"; ?> >16:00</option>
                            <option value="17:00" <?php if ($nonreg['nk_waktu'] == '17:00') echo "selected"; ?> >17:00</option>
                            <option value="18:00" <?php if ($nonreg['nk_waktu'] == '18:00') echo "selected"; ?> >18:00</option>
                            <option value="19:00" <?php if ($nonreg['nk_waktu'] == '19:00') echo "selected"; ?> >19:00</option>
                            <option value="20:00" <?php if ($nonreg['nk_waktu'] == '20:00') echo "selected"; ?> >20:00</option>
                            <option value="21:00" <?php if ($nonreg['nk_waktu'] == '21:00') echo "selected"; ?> >21:00</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_timezone" name="nk_timezone" required>
                            <option value="WITA" <?php if ($nonreg['nk_timezone'] == 'WITA') echo "selected"; ?> >WITA</option>
                            <option value="WIB" <?php if ($nonreg['nk_timezone'] == 'WIB') echo "selected"; ?> >WIB</option>
                            <option value="WIT" <?php if ($nonreg['nk_timezone'] == 'WIT') echo "selected"; ?> >WIT</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Maksimal Pertemuan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_tm_total" name="nk_tm_total" placeholder="" min="1" max="50" value="<?= $nonreg['nk_tm_total'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Pertemuan Diambil<code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_tm_ambil" name="nk_tm_ambil" placeholder="" min="1" max="50" value="<?= $nonreg['nk_tm_ambil'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Level Peserta <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="nk_level" id="nk_level" class="select2SearchEdit" required>
                            <?php foreach ($level as $key => $data) { ?>
                                <option value="<?= $data['nama_level'] ?>" <?php if ($data['nama_level'] == $nonreg['nk_level']) echo "selected"; ?> ><?= $data['nama_level'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Jumlah Peserta <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_kuota" name="nk_kuota" value="<?= $nonreg['nk_kuota'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Metode Absen<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_absen_metode" name="nk_absen_metode" required>
                            <option value="Pengajar" <?php if ($nonreg['nk_absen_metode'] == 'Pengajar') echo "selected"; ?> >Pengajar</option>
                            <option value="PIC" <?php if ($nonreg['nk_absen_metode'] == 'PIC') echo "selected"; ?> >PIC</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_status" name="nk_status" required>
                            <option value=1 <?php if ($nonreg['nk_status'] == 1) echo "selected"; ?> >AKTIF</option>
                            <option value=0 <?php if ($nonreg['nk_status'] == 0) echo "selected"; ?> >NONAKTIF</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama PIC <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_pic_name" name="nk_pic_name" value="<?= $nonreg['nk_pic_name'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">No. HP PIC <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_pic_hp" name="nk_pic_hp" value="<?= $nonreg['nk_pic_hp'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Edit Peserta<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_pic_otoritas" name="nk_pic_otoritas" required>
                            <option value=1 <?php if ($nonreg['nk_pic_otoritas'] == 1) echo "selected"; ?> >BISA</option>
                            <option value=0 <?php if ($nonreg['nk_pic_otoritas'] == 0) echo "selected"; ?> >TIDAK</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Alamat Lokasi Kelas<code>*</code></label>
                    <div class="col-sm-8">
                        <textarea class="form-control text-uppercase" name="nk_lokasi" id="nk_lokasi" cols="30" rows="10" required><?= $nonreg['nk_lokasi'] ?></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning btnsimpan"><i class="fa fa-share-square"></i> Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2SearchEdit').select2({
            dropdownParent: $('#modaledit')
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

                        if (response.error.nk_nama) {
                            $('#nk_nama').addClass('is-invalid');
                            $('.errorNamakelas').html(response.error.nk_nama);
                        } else {
                            $('#nk_nama').removeClass('is-invalid');
                            $('.errorNamakelas').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Edit Data Kelas Non-Reguler",
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