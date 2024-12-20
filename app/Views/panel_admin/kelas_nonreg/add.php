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
            <?= form_open('kelas-nonreg/create', ['class' => 'formtambah']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
            <!-- <p class="mt-1">Catatan :<br> 
                    <i class="mdi mdi-information"></i> Nama Kelas Harus Unik, Format Penamaan Angkatan-Level-Jenkel-Waktu. Contoh A01-TAJWIDI-1-AKHWAT-SENIN18 <br> -->
                </p>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Program <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="program_id" id="program_id" class="select2Search" required>
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($program as $key => $data) { ?>
                                <option value="<?= $data['program_id'] ?>"><?= $data['nama_program'] ?> - <?= $data['jenis_program'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_nama" name="nk_nama" required>
                        <div class="invalid-feedback errorNamakelas"></div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Angkatan Perkuliahan <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_angkatan" name="nk_angkatan" value="<?= $angkatan ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Bidang Usaha/Kegiatan <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="nk_usaha" id="nk_usaha" class="select2Search" required>
                                <option Disabled=true Selected=true> </option>
                            <?php foreach ($usaha as $key => $data) { ?>
                                <option value="<?= $data['nu_usaha'] ?>"><?= $data['nu_usaha'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Pengajar <code>*</code></label>
                    <div class="col-sm-8">
                    <select name="nk_pengajar[]" multiple="multiple" id="nk_pengajar" class="select2Search">
                            <?php foreach ($pengajar as $key => $data) { ?>
                                <option value="<?= $data['pengajar_id'] ?>"><?= $data['nama_pengajar'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Hari <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_hari" name="nk_hari" required>
                            <option value="" disabled selected>--PILIH--</option>
                            <option value="SENIN">SENIN</option>
                            <option value="SELASA">SELASA</option>
                            <option value="RABU">RABU</option>
                            <option value="KAMIS">KAMIS</option>
                            <option value="JUMAT">JUMAT</option>
                            <option value="SABTU">SABTU</option>
                            <option value="MINGGU">MINGGU</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Waktu <code>*</code></label>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_waktu" name="nk_waktu" required>
                            <option value="" disabled selected>--WAKTU--</option>
                            <option value="05:00">05:00</option>
                            <option value="06:00">06:00</option>
                            <option value="07:00">07:00</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control btn-square" id="nk_timezone" name="nk_timezone" required>
                            <option value="" disabled selected>--ZONA--</option>
                            <option value="WITA">WITA</option>
                            <option value="WIB">WIB</option>
                            <option value="WIT">WIT</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Maksimal Pertemuan <code>*(maksimal 50)</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_tm_total" name="nk_tm_total" placeholder="" min="1" max="50" value="20" required>
                    </div>
                </div>
                <div class="form-group row" style="display:none">
                    <label for="" class="col-sm-4 col-form-label">Pertemuan Diambil </label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_tm_ambil" name="nk_tm_ambil" placeholder="" min="1" value="0" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Level Peserta <code>*</code></label>
                    <div class="col-sm-8">
                        <select name="nk_level[]" id="nk_level"  multiple="multiple" class="select2Search" required>
                            <?php foreach ($level as $key => $data) { ?>
                                <option value="<?= $data['peserta_level_id'] ?>"><?= $data['nama_level'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Jumlah Peserta <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="nk_kuota" name="nk_kuota" placeholder="" min="1" max="100" required>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Metode Absen<code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_absen_metode" name="nk_absen_metode" required>
                            <option value="PIC" selected>PIC</option>
                            <option value="Pengajar">Pengajar</option>
                        </select>
                    </div>
                </div> -->
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Status Kelas <code>*</code></label>
                    <div class="col-sm-8">
                        <select class="form-control btn-square" id="nk_status" name="nk_status" required>
                            <option value=1 selected>AKTIF</option>
                            <option value=0>NONAKTIF</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Alamat Lokasi Kelas<code>*</code></label>
                    <div class="col-sm-8">
                        <textarea class="form-control text-uppercase" name="nk_lokasi" id="nk_lokasi" cols="10" rows="2" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Keterangan Kelas</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="nk_keterangan" id="nk_keterangan" cols="10" rows="2"></textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">Nama PIC <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_pic_name" name="nk_pic_name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label">No. HP PIC <code>*</code></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control text-uppercase" id="nk_pic_hp" name="nk_pic_hp" required>
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
    // Maksimal value tm_ambil adalah dari value tm_total
    var nk_tm_total = document.getElementById("nk_tm_total");
    var nk_tm_ambil = document.getElementById("nk_tm_ambil");
    function updateMax() {
        var total = Number(nk_tm_total.value);
        nk_tm_ambil.setAttribute("max", total);
    }
    updateMax();
    nk_tm_total.addEventListener("input", updateMax);

    $(document).ready(function() {
        $('.select2Search').select2({
            dropdownParent: $('#modaltambah')
        });
        $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    program_id: $('select#program_id').val(),
                    nk_nama: $('input#nk_nama').val(),
                    nk_angkatan: $('input#nk_angkatan').val(),
                    nk_usaha: $('select#nk_usaha').val(),
                    nk_pengajar: $('select#nk_pengajar').val(),
                    nk_hari: $('select#nk_hari').val(),
                    nk_waktu: $('select#nk_waktu').val(),
                    nk_timezone: $('select#nk_timezone').val(),
                    nk_tm_total: $('input#nk_tm_total').val(),
                    nk_tm_ambil: $('input#nk_tm_ambil').val(),
                    nk_level: $('select#nk_level').val(),
                    nk_kuota: $('input#nk_kuota').val(),
                    // nk_absen_metode: $('select#nk_absen_metode').val(),
                    nk_keterangan: $('textarea#nk_keterangan').val(),
                    nk_pic_name: $('input#nk_pic_name').val(),
                    nk_pic_hp: $('input#nk_pic_hp').val(),
                    nk_lokasi: $('textarea#nk_lokasi').val(),
                    nk_status: $('select#nk_status').val(),
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
                            text: "Berhasil Tambah Data Kelas Non-Reguler Baru",
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