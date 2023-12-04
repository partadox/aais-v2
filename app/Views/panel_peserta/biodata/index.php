<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Akun Peserta</h6>
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
        <div class="col-sm-4 mb-2">
            <input type="text" class="form-control" placeholder="************" readonly>
        </div>
        <div class="col-sm-4">
          <button type="button" class="btn btn-info" onclick="edit_password('<?= $user['user_id'] ?>')" ><i class=" fa fa-edit mr-1"></i>Ganti Password</button>
        </div>
    </div>
  </div>
</div>

<div class="card shadow-lg">
  <div class="card-header pb-0">
    <h6 class="card-title mb-2">Data Diri Peserta</h6>
    <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
  </div>
  <div class="card-body">
    <div class="container-fluid">
          <div class="row">
            <div class="col">
                <div class="card-body">
                <?= form_open('biodata-peserta/update', ['class' => 'formtambah']) ?>
                <?= csrf_field() ?>
                    <div class="form-group">
                      <input type="hidden" id="user_id" name="user_id" value="<?= $user['user_id'] ?>">
                      <input type="hidden" id="peserta_id" name="peserta_id" value="<?= $peserta_id ?>">
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input class="form-control" type="text" id="nis" name="nis"  value="<?= $nis ?>"  readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">NIK KTP (16 Digit)</label>
                        <input class="form-control" type="text" id="nik" name="nik"  value="<?= $nik ?>" required>
                        <div class="invalid-feedback errorNik">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Nama Lengkap (Sesuai KTP) <code>*</code> </label>
                        <input class="form-control text-uppercase" type="text" id="nama" name="nama"  value="<?= $nama ?>" required>
                        <div class="invalid-feedback errorNama">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                          <div class="form-group">
                            <label class="form-label">Tempat Lahir<code>*</code></label>
                            <input class="form-control text-uppercase" type="text" id="tmp_lahir" name="tmp_lahir"  value="<?= $tmp_lahir ?>" required>
                            <div class="invalid-feedback errorTmp_lahir">
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                          <div class="form-group">
                            <label class="form-label">Tanggal Lahir<code>*</code></label>
                            
                            <div class="input-group" id="datepicker2">
                                <input type="text" id="tgl_lahir" name="tgl_lahir" class="form-control" placeholder="Tahun-Bulan-Tanggal"
                                    data-date-format="yyyy-mm-dd" data-date-container='#datepicker2'
                                    data-provide="datepicker" data-date-autoclose="true" value="<?= $tgl_lahir ?>" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                    <div class="invalid-feedback errorTgl_lahir">
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Jenis Kelamin<code>*</code></label>
                        <input type="text" class="form-control" id="jenkel" name="jenkel" value="<?= $jenkel ?>" readonly>
                        <div class="invalid-feedback errorJenkel">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Pendidikan Terakhir<code>*</code></label>
                        <select class="form-control btn-square select2" id="pendidikan" name="pendidikan" required>
                            <option value="SD" <?php if ($pendidikan == 'SD') echo "selected"; ?>>SD</option>
                            <option value="SLTP" <?php if ($pendidikan == 'SLPT') echo "selected"; ?>>SLTP</option>
                            <option value="SLTA" <?php if ($pendidikan == 'SLTA') echo "selected"; ?>>SLTA</option>
                            <option value="DIPLOMA" <?php if ($pendidikan == 'DIPLOMA') echo "selected"; ?>>DIPLOMA</option>
                            <option value="SARJANA (S1)" <?php if ($pendidikan == 'SARJANA (S1)') echo "selected"; ?>>SARJANA (S1)</option>
                            <option value="MAGISTER (S2)" <?php if ($pendidikan == 'MAGISTER (S2)') echo "selected"; ?>>MAGISTER (S2)</option>
                            <option value="DOKTOR (S3)" <?php if ($pendidikan == 'DOKTOR (S3)') echo "selected"; ?>>DOKTOR (S3)</option>
                            <option value="TIDAK DIKETAHUI"  <?php if ($pendidikan == 'TIDAK DIKETAHUI') echo "selected"; ?>>TIDAK DIKETAHUI</option>
                        </select>
                        <div class="invalid-feedback errorPendidikan">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Jurusan Pendidikan Terakhir<code>*</code></label>
                        <input class="form-control text-uppercase" type="text" id="jurusan" name="jurusan" value="<?= $jurusan ?>" required>
                        <div class="invalid-feedback errorJurusan">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Status Bekerja<code>*</code></label>
                        <select class="form-control btn-square select2" id="status_kerja" name="status_kerja" required>
                            <option value="0" <?php if ($status_kerja == '0') echo "selected"; ?>>TIDAK DALAM IKATAN KERJA</option>
                            <option value="1" <?php if ($status_kerja == '1') echo "selected"; ?>>BEKERJA</option>
                        </select>
                        <div class="invalid-feedback errorStatuskerja">
                      </div>
                    </div>
                    <div class="form-group">
                    <div class="mb-3">
                      <label class="form-label">Pekerjaan<code>*</code></label>
                      <select class="form-control btn-square select2" id="pekerjaan" name="pekerjaan" required>
                            <option value="WIRASWASTA" <?php if ($pekerjaan == 'WIRASWASTA') echo "selected"; ?>>WIRASWASTA</option>
                            <option value="PEGAWAI SWASTA" <?php if ($pekerjaan == 'PEGAWAI SWASTA') echo "selected"; ?>>PEGAWAI SWASTA</option>
                            <option value="PEMERINTAH/PNS" <?php if ($pekerjaan == 'PEMERINTAH/PNS') echo "selected"; ?>>PEMERINTAH/PNS</option>
                            <option value="BUMN" <?php if ($pekerjaan == 'BUMN') echo "selected"; ?>>BUMN</option>
                            <option value="USAHA/DAGANG" <?php if ($pekerjaan == 'USAHA/DAGANG') echo "selected"; ?>>USAHA/DAGANG</option>
                            <option value="KEAMANAN/MILITER/POLISI" <?php if ($pekerjaan == 'KEAMANAN/MILITER/POLISI') echo "selected"; ?>>KEAMANAN/MILITER/POLISI</option>
                            <option value="PERBANKAN/KEUANGAN" <?php if ($pekerjaan == 'PERBANKAN/KEUANGAN') echo "selected"; ?>>PERBANKAN/KEUANGAN</option>
                            <option value="KESEHATAN" <?php if ($pekerjaan == 'KESEHATAN') echo "selected"; ?>>KESEHATAN</option>
                            <option value="PENDIDIKAN" <?php if ($pekerjaan == 'PENDIDIKAN') echo "selected"; ?>>PENDIDIKAN</option>
                            <option value="OLAHRAGA/ATLET" <?php if ($pekerjaan == 'OLAHRAGA/ATLET') echo "selected"; ?>>OLAHRAGA/ATLET</option>
                            <option value="KESENIAN/ARTIS" <?php if ($pekerjaan == 'KESENIAN/ARTIS') echo "selected"; ?>>KESENIAN/ARTIS</option>
                            <option value="KEAGAMAAN/MAJELIS" <?php if ($pekerjaan == 'KEAGAMAAN/MAJELIS') echo "selected"; ?>>KEAGAMAAN/MAJELIS</option>
                            <option value="PELAJAR/MAHASISWA" <?php if ($pekerjaan == 'PELAJAR/MAHASISWA') echo "selected"; ?>>PELAJAR/MAHASISWA</option>
                            <option value="KELUARGA/RUMAH TANGGA" <?php if ($pekerjaan == 'KELUARGA/RUMAH TANGGA') echo "selected"; ?>>KELUARGA/RUMAH TANGGA</option>
                            <option value="FREELANCE" <?php if ($pekerjaan == 'FREELANCE') echo "selected"; ?>>FREELANCE</option>
                            <option value="PENSIUNAN"  <?php if ($pekerjaan == 'PENSIUNAN') echo "selected"; ?>>PENSIUNAN</option>
                            <option value="LAINNYA" <?php if ($pekerjaan == 'LAINNYA') echo "selected"; ?>>LAINNYA</option>
                            <option value="TIDAK DIKETAHUI" <?php if ($pekerjaan == 'TIDAK DIKETAHUI') echo "selected"; ?>>TIDAK DIKETAHUI</option>
                        </select>
                      <div class="invalid-feedback errorPekerjaan">
                    </div>
                  </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label"> No. HP (WhatsApp)<code>*</code></label>
                        <input class="form-control" type="text" id="hp" name="hp" value="<?= $hp ?>" required>
                        <div class="invalid-feedback errorHp">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">E-Mail<code>*</code></label>
                        <input class="form-control text-lowercase" type="text" id="email" name="email" value="<?= $email ?>" required>
                        <div class="invalid-feedback errorEmail">
                      </div>
                    </div>
                    <div class="form-group">
                    <div class="mb-3">
                      <label class="form-label">Domisili<code>*</code></label>
                      <select class="form-control btn-square select2" id="domisili_peserta" name="domisili_peserta" required>
                        <option value="BALIKPAPAN"  <?php if ($domisili_peserta == 'BALIKPAPAN') echo "selected"; ?>>BALIKPAPAN</option>
                        <option value="LUAR BALIKPAPAN" <?php if ($domisili_peserta == 'LUAR BALIKPAPAN') echo "selected"; ?>>LUAR BALIKPAPAN</option>
                      </select>
                      <div class="invalid-feedback errorDomisili_peserta">
                    </div>
                  </div>
                    <div class="form-group">
                      <div class="mb-3">
                        <label class="form-label">Alamat<code>*</code></label>
                        <input class="form-control text-uppercase" type="text-area" id="alamat" name="alamat" value="<?= $alamat ?>" required>
                        <div class="invalid-feedback errorAlamat">
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

<div class="viewmodaleditusername">
</div>

<div class="viewmodaleditpassword">
</div>

<script>

    function edit_password(user_id) {
        $.ajax({
            type: "post",
            url: "<?= site_url('biodata-peserta/edit-password') ?>",
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

        $(document).ready(function(){
            $('.select2').select2({
                minimumResultsForSearch: Infinity
            });
        });
</script>
<?= $this->endSection('isi') ?>