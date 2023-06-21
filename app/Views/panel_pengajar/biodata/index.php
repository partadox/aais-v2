<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Akun Pengajar</h6>
    <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
  </div>
  <div class="card-body">
    <p class="mt-1">Catatan :<br>
        <i class="mdi mdi-information"></i> Setelah anda merubah password anda, silahkan keluar (logout) dan login kembali menggunakan password baru anda. <br>
    </p>

    <div class="form-group row">
        <label for="" class="col-sm-2 col-form-label">Username<code>*</code></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" value="<?= $user['username'] ?>" readonly>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="" class="col-sm-2 col-form-label">Password<code>*</code></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" placeholder="************" readonly>
        </div>
        <div class="col-sm-4">
          <button type="button" class="btn btn-info" onclick="edit_password('<?= session()->get('user_id') ?>')" ><i class=" fa fa-edit mr-1"></i>Ganti Password</button>
        </div>
    </div>
  </div>
</div>

<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Data Diri Pengajar</h6>
    <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
  </div>
  <div class="card-body">
    <div class="container-fluid">
          <div class="row">
            <div class="col">
                
                <div class="card-body">
                <?= form_open('biodata-pengajar/update', ['class' => 'formtambah']) ?>
                <?= csrf_field() ?>
                    <div class="form-group">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" id="pengajar_id" name="pengajar_id" value="<?= $pengajar_id ?>">
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Nama Lengkap (Sesuai KTP) <code>*</code> </label>
                        <input class="form-control text-uppercase" type="text" id="nama_pengajar" name="nama_pengajar"  value="<?= $nama_pengajar ?>">
                        <div class="invalid-feedback error_nama_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">NIK KTP (16 Digit)<code>*</code></label>
                        <input class="form-control" type="text" id="nik_pengajar" name="nik_pengajar"  value="<?= $nik_pengajar ?>">
                        <div class="invalid-feedback error_nik_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Jenis Kelamin<code>*</code></label>
                        <input class="form-control" type="text" id="jenkel_pengajar" name="jenkel_pengajar" value="<?= $jenkel_pengajar ?>" readonly>
                        <div class="invalid-feedback error_jenkel_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Tempat Lahir<code>*</code></label>
                        <input class="form-control text-uppercase" type="text" id="tmp_lahir_pengajar" name="tmp_lahir_pengajar"  value="<?= $tmp_lahir_pengajar ?>">
                        <div class="invalid-feedback error_tmp_lahir_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Tanggal Lahir<code>*</code></label>
                        <input type="date" class="form-control" id="tgl_lahir_pengajar" name="tgl_lahir_pengajar"  value="<?= $tgl_lahir_pengajar ?>">
                        <div class="invalid-feedback error_tgl_lahir_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Suku Bangsa<code>*</code></label>
                        <input class="form-control text-uppercase" type="text" id="suku_bangsa" name="suku_bangsa" value="<?= $suku_bangsa ?>">
                        <div class="invalid-feedback error_suku_bangsa">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Status Nikah<code>*</code></label>
                        <select class="form-control btn-square" id="status_nikah" name="status_nikah">
                          <option value="MENIKAH"  <?php if ($status_nikah == 'MENIKAH') echo "selected"; ?>>MENIKAH</option>
                          <option value="LAJANG" <?php if ($status_nikah == 'LAJANG') echo "selected"; ?>>LAJANG</option>
                          <option value="SINGLE PARENT" <?php if ($status_nikah == 'SINGLE PARENT') echo "selected"; ?>>SINGLE PARENT</option>
                        </select>
                        <div class="invalid-feedback error_status_nikah">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Jumlah Anak<code>*</code></label>
                        <input class="form-control" type="number" id="jumlah_anak" name="jumlah_anak" value="<?= $jumlah_anak ?>">
                        <div class="invalid-feedback error_jumlah_anak">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Pendidikan Terakhir<code>*</code></label>
                        <select class="form-control btn-square" id="pendidikan_pengajar" name="pendidikan_pengajar">
                            <option value="SD" <?php if ($pendidikan_pengajar == 'SD') echo "selected"; ?>>SD</option>
                            <option value="SLTP" <?php if ($pendidikan_pengajar == 'SLPT') echo "selected"; ?>>SLTP</option>
                            <option value="SLTA" <?php if ($pendidikan_pengajar == 'SLTA') echo "selected"; ?>>SLTA</option>
                            <option value="DIPLOMA" <?php if ($pendidikan_pengajar == 'DIPLOMA') echo "selected"; ?>>DIPLOMA</option>
                            <option value="SARJANA (S1)" <?php if ($pendidikan_pengajar == 'SARJANA (S1)') echo "selected"; ?>>SARJANA (S1)</option>
                            <option value="MAGISTER (S2)" <?php if ($pendidikan_pengajar == 'MAGISTER (S2)') echo "selected"; ?>>MAGISTER (S2)</option>
                            <option value="DOKTOR (S3)" <?php if ($pendidikan_pengajar == 'DOKTOR (S3)') echo "selected"; ?>>DOKTOR (S3)</option>
                            <option value="TIDAK DIKETAHUI"  <?php if ($pendidikan_pengajar == 'TIDAK DIKETAHUI') echo "selected"; ?>>TIDAK DIKETAHUI</option>
                        </select>
                        <div class="invalid-feedback error_pendidikan_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Jurusan Pendidikan Terakhir<code>*</code></label>
                        <input class="form-control text-uppercase" type="text" id="jurusan_pengajar" name="jurusan_pengajar" value="<?= $jurusan_pengajar ?>">
                        <div class="invalid-feedback error_jurusan_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label"> No. HP (WhatsApp)<code>*</code></label>
                        <input class="form-control" type="text" id="hp_pengajar" name="hp_pengajar" value="<?= $hp_pengajar ?>">
                        <div class="invalid-feedback error_hp_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">E-Mail<code>*</code></label>
                        <input class="form-control text-lowercase" type="text" id="email_pengajar" name="email_pengajar" value="<?= $email_pengajar ?>">
                        <div class="invalid-feedback error_email_pengajar">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Alamat<code>*</code></label>
                        <input class="form-control text-uppercase" type="text-area" id="alamat_pengajar" name="alamat_pengajar" value="<?= $alamat_pengajar ?>">
                        <div class="invalid-feedback error_alamat_pengajar">
                      </div>
                    </div>

                </div>
                <div style="position: absolute; right: 0;" class="row">
                  <input  class="btn btn-warning mb-6 mr-4" type="submit" value="Update" ></input>
                </div>
                <?= form_close() ?>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>



<div class="viewmodaleditpassword">
</div>

<script>

    function edit_password() {
      let user_id = <?= $user_id ?>;
        $.ajax({
            type: "post",
            url: "<?= site_url('biodata-pengajar/edit-password') ?>",
            data: {
                user_id : user_id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodaleditpassword').html(response.sukses).show();
                    $('#modaleditpassword').modal('show');
                }
            }
        });
    }

    $('.formtambah').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: {
                    user_id: $('input#user_id').val(),
                    pengajar_id: $('input#pengajar_id').val(),
                    nama_pengajar: $('input#nama_pengajar').val(),
                    nik_pengajar: $('input#nik_pengajar').val(),
                    tmp_lahir_pengajar: $('input#tmp_lahir_pengajar').val(),
                    tgl_lahir_pengajar: $('input#tgl_lahir_pengajar').val(),
                    jenkel_pengajar: $('input#jenkel_pengajar').val(),
                    suku_bangsa: $('input#suku_bangsa').val(),
                    status_nikah: $('select#status_nikah').val(),
                    jumlah_anak: $('input#jumlah_anak').val(),
                    pendidikan_pengajar: $('select#pendidikan_pengajar').val(),
                    jurusan_pengajar: $('input#jurusan_pengajar').val(),
                    hp_pengajar: $('input#hp_pengajar').val(),
                    email_pengajar: $('input#email_pengajar').val(),
                    alamat_pengajar: $('input#alamat_pengajar').val(),
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
                      if (response.error.nik_pengajar) {
                            $('#nik_pengajar').addClass('is-invalid');
                            $('.error_nik_pengajar').html(response.error.nik_pengajar);
                        } else {
                            $('#nik_pengajar').removeClass('is-invalid');
                            $('.error_nik_pengajar').html('');
                        }

                        if (response.error.nama_pengajar) {
                            $('#nama_pengajar').addClass('is-invalid');
                            $('.error_nama_pengajar').html(response.error.nama_pengajar);
                        } else {
                            $('#nama_pengajar').removeClass('is-invalid');
                            $('.error_nama_pengajar').html('');
                        }

                        if (response.error.jenkel_pengajar) {
                            $('#jenkel_pengajar').addClass('is-invalid');
                            $('.error_jenkel_pengajar').html(response.error.jenkel_pengajar);
                        } else {
                            $('#jenkel_pengajar').removeClass('is-invalid');
                            $('.error_jenkel_pengajar').html('');
                        }

                        if (response.error.tmp_lahir_pengajar) {
                            $('#tmp_lahir_pengajar').addClass('is-invalid');
                            $('.error_tmp_lahir_pengajar').html(response.error.tmp_lahir_pengajar);
                        } else {
                            $('#tmp_lahir_pengajar').removeClass('is-invalid');
                            $('.error_tmp_lahir_pengajar').html('');
                        }

                        if (response.error.tgl_lahir_pengajar) {
                            $('#tgl_lahir_pengajar').addClass('is-invalid');
                            $('.error_tgl_lahir_pengajar').html(response.error.tgl_lahir_pengajar);
                        } else {
                            $('#tgl_lahir_pengajar').removeClass('is-invalid');
                            $('.error_tgl_lahir_pengajar').html('');
                        }

                        if (response.error.suku_bangsa) {
                            $('#suku_bangsa').addClass('is-invalid');
                            $('.error_suku_bangsa').html(response.error.suku_bangsa);
                        } else {
                            $('#suku_bangsa').removeClass('is-invalid');
                            $('.error_suku_bangsa').html('');
                        }

                        if (response.error.status_nikah) {
                            $('#status_nikah').addClass('is-invalid');
                            $('.error_status_nikah').html(response.error.status_nikah);
                        } else {
                            $('#status_nikah').removeClass('is-invalid');
                            $('.error_status_nikah').html('');
                        }

                        if (response.error.jumlah_anak) {
                            $('#jumlah_anak').addClass('is-invalid');
                            $('.error_jumlah_anak').html(response.error.jumlah_anak);
                        } else {
                            $('#jumlah_anak').removeClass('is-invalid');
                            $('.error_jumlah_anak').html('');
                        }

                        if (response.error.pendidikan_pengajar) {
                            $('#pendidikan_pengajar').addClass('is-invalid');
                            $('.error_pendidikan_pengajar').html(response.error.pendidikan_pengajar);
                        } else {
                            $('#pendidikan_pengajar').removeClass('is-invalid');
                            $('.error_pendidikan_pengajar').html('');
                        }

                        if (response.error.jurusan_pengajar) {
                            $('#jurusan_pengajar').addClass('is-invalid');
                            $('.error_jurusan_pengajar').html(response.error.jurusan_pengajar);
                        } else {
                            $('#jurusan_pengajar').removeClass('is-invalid');
                            $('.error_jurusan_pengajar').html('');
                        }

                        if (response.error.hp_pengajar) {
                            $('#hp_pengajar').addClass('is-invalid');
                            $('.error_hp_pengajar').html(response.error.hp_pengajar);
                        } else {
                            $('#hp_pengajar').removeClass('is-invalid');
                            $('.error_hp_pengajar').html('');
                        }

                        if (response.error.email_pengajar) {
                            $('#email_pengajar').addClass('is-invalid');
                            $('.error_email_pengajar').html(response.error.email_pengajar);
                        } else {
                            $('#email_pengajar').removeClass('is-invalid');
                            $('.error_email_pengajar').html('');
                        }

                        if (response.error.alamat_pengajar) {
                            $('#alamat_pengajar').addClass('is-invalid');
                            $('.error_alamat_pengajar').html(response.error.alamat_pengajar);
                        } else {
                            $('#alamat_pengajar').removeClass('is-invalid');
                            $('.error_alamat_pengajar').html('');
                        }

                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Data Lengkap Diri Anda Berhasil Diubah",
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
</script>
<?= $this->endSection('isi') ?>