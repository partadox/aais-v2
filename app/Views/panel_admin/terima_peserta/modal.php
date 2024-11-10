<!-- Modal -->
<div class="modal fade" id="modalTerima" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('terima-peserta/create', ['class' => 'formedit']) ?>
            <?= csrf_field(); ?>
            <div class="modal-body">
                <?php if($modal == 'terima') {?>
                    <input type="hidden" id="peserta_transfer_id" name="peserta_transfer_id" value="<?= $peserta['peserta_tranfer_id'] ?>">
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Nama Peserta <code>*</code></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" id="nama" name="nama" value="<?= $peserta['name'] ?>" required>
                            <div class="invalid-feedback errorNama"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Asal Cb. Peserta = (<?= $peserta['cabang'] ?>)<code>*</code></label>
                        <div class="col-sm-8">
                            <select name="asal_cabang_peserta" id="asal_cabang_peserta" class="js-example-basic-single-edit" required>
                                <?php foreach ($kantor as $key => $data) { ?>
                                    <option value="<?= $data['kantor_id'] ?>"> <?= $data['nama_kantor'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorAsal_cabang_peserta"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">NIS<code>*</code></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nis" name="nis" value="" required>
                            <div class="invalid-feedback errorNis"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Angkatan <br> Bergabung <code>*</code></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="angkatan" name="angkatan" value="" required>
                            <div class="invalid-feedback errorAngkatan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Level Peserta Terakhir = (<?= $peserta['level'] ?>) <code>*</code></label>
                        <div class="col-sm-8">
                            <select name="level_peserta" id="level_peserta" class="js-example-basic-single-edit" required>
                                <?php foreach ($level as $key => $data) { ?>
                                    <option value="<?= $data['peserta_level_id'] ?>" > <?= $data['nama_level'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorLevelpeserta"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Jenis Kelamin <code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="jenkel" name="jenkel" required>
                                <option value="IKHWAN"  <?php if ($peserta['gender'] == 'IKHWAN') echo "selected"; ?> >IKHWAN</option>
                                <option value="AKHWAT"  <?php if ($peserta['gender'] == 'AKHWAT') echo "selected"; ?> >AKHWAT</option>
                            </select>
                            <div class="invalid-feedback errorJenkel"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">NIK<code>*</code></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= $peserta['nik'] ?>" required>
                            <div class="invalid-feedback errorNik"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Tempat Lahir<code>*</code></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control text-uppercase" id="tmp_lahir" name="tmp_lahir" value="<?= $peserta['born'] ?>" required>
                            <div class="invalid-feedback errorTmp_lahir"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal Lahir<code>*</code></label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"  value="<?= $peserta['birthday'] ?>" required>
                            <div class="invalid-feedback errorTgl_Lahir"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Pendidikan<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="pendidikan" name="pendidikan" required>
                                <option value="SD" <?php if ($peserta['education'] == 'SD') echo "selected"; ?>>SD</option>
                                <option value="SLTP" <?php if ($peserta['education'] == 'SLPT') echo "selected"; ?>>SLTP</option>
                                <option value="SLTA" <?php if ($peserta['education'] == 'SLTA') echo "selected"; ?>>SLTA</option>
                                <option value="DIPLOMA" <?php if ($peserta['education'] == 'DIPLOMA') echo "selected"; ?>>DIPLOMA</option>
                                <option value="SARJANA (S1)" <?php if ($peserta['education'] == 'SARJANA (S1)') echo "selected"; ?>>SARJANA (S1)</option>
                                <option value="MAGISTER (S2)" <?php if ($peserta['education'] == 'MAGISTER (S2)') echo "selected"; ?>>MAGISTER (S2)</option>
                                <option value="DOKTOR (S3)" <?php if ($peserta['education'] == 'DOKTOR (S3)') echo "selected"; ?>>DOKTOR (S3)</option>
                                <option value="TIDAK DIKETAHUI"  <?php if ($peserta['education'] == 'TIDAK DIKETAHUI') echo "selected"; ?>>TIDAK DIKETAHUI</option>
                            </select>
                            <div class="invalid-feedback errorPendidikan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jurusan Pendidikan Terakhir<code>*</code></label>
                        <div class="col-sm-8">
                            <input class="form-control text-uppercase" type="text" id="jurusan" name="jurusan" value="<?= $peserta['major'] ?>" required>
                            <div class="invalid-feedback errorJurusan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Status Bekerja<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="status_kerja" name="status_kerja" required>
                                <option value="0" <?php if ($peserta['employed'] == '0') echo "selected"; ?>>TIDAK DALAM IKATAN KERJA</option>
                                <option value="1" <?php if ($peserta['employed'] == '1') echo "selected"; ?>>BEKERJA</option>
                            </select>
                            <div class="invalid-feedback errorStatus_kerja"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Pekerjaan = <?= $peserta['job'] ?><code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="pekerjaan" name="pekerjaan" required>
                                <?php foreach ($pekerjaan as $key => $data) { ?>
                                    <option value="<?= $data['nama'] ?>" <?php if ($data['nama'] == $peserta['job']) echo "selected"; ?> ><?= $data['nama'] ?></option>
                                <?php } ?>
                            </select>
                            <div class="invalid-feedback errorPekerjaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">No. HP<code>*</code></label>
                        <div class="col-sm-8">
                            <input class="form-control" type="number" id="hp" name="hp" value="<?= $peserta['phone'] ?>" required>
                            <div class="invalid-feedback errorHp"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Email<code>*</code></label>
                        <div class="col-sm-8">
                            <input class="form-control text-lowercase" type="text" id="email" name="email" value="<?= $peserta['email'] ?>" required>
                            <div class="invalid-feedback errorEmail"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Alamat<code>*</code></label>
                        <div class="col-sm-8">
                            <input class="form-control text-uppercase" type="text" id="alamat" name="alamat" value="<?= $peserta['address'] ?>" required>
                            <div class="invalid-feedback errorAlamat"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Domisili<code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="domisili_peserta" name="domisili_peserta" required>
                                <option value="BALIKPAPAN">BALIKPAPAN</option>
                                <option value="LUAR BALIKPAPAN">LUAR BALIKPAPAN</option>
                            </select>
                            <div class="invalid-feedback errorDomisili_peserta"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Status Peserta <code>*</code></label>
                        <div class="col-sm-8">
                            <select class="form-control btn-square" id="status_peserta" name="status_peserta" required>
                                <option value="AKTIF">AKTIF</option>
                                <option value="OFF">OFF</option>
                                <option value="CUTI">CUTI</option>
                            </select>
                            <div class="invalid-feedback errorStatus_peserta"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-4 col-form-label">Catatan Peserta</label>
                        <div class="col-sm-8"> 
                            <textarea class="form-control" name="peserta_note" id="peserta_note" style="height: 100px;"><?php echo esc($peserta['desc']); ?>
                            </textarea>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($modal == 'history') {?>
                    <table id="datatable" class="table table-striped table-bordered nowrap mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>NO.</th>
                                <th>NIS</th>
                                <th>NAMA</th>
                                <th>KELAS</th>
                                <th>PROGRAM</th>
                                <th>LULUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($history != null) {?>
                                <?php
                                $no = 0;
                                foreach ($history as $key => $data) { $no++; ?>
                                    <tr>
                                        <td><?= $no?></td>
                                        <td><?= $data['nis'] ?></td>    
                                        <td><?= $data['pesertaName'] ?></td>
                                        <td><?= $data['kelasName'] ?></td>    
                                        <td><?= $data['programName'] ?></td>            
                                        <td>
                                            <?php if($data['graduate'] == 1){ ?>
                                                <span class="badge badge-success">LULUS</span>
                                            <?php }?>
                                            <?php if($data['graduate'] == 0){ ?>
                                                <span class="badge badge-secondary">BELUM LULUS</span>
                                            <?php }?>
                                        </td>
                                    </tr>
                                <?php }?>
                            <?php }?>
                            
                        </tbody>
                    </table>

                <?php }?>
            </div>
            <div class="modal-footer">
                <?php if ($modal == 'terima') {?>
                    <button type="submit" class="btn btn-primary btnsimpan"><i class="fa fa-share-square"></i> Simpan</button>
                <?php }?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
        $('.js-example-basic-single-edit').select2({
            
        });
        // Add this event handler for modal cleanup
        $('#modalTerima').on('hidden.bs.modal', function (e) {
            // Remove modal-backdrop explicitly
            $('.modal-backdrop').remove();
            // Reset body classes
            $('body').removeClass('modal-open');
            // Reset modal state
            $(this).removeData('bs.modal');
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
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errorNama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errorNama').html('');
                        }

                        if (response.error.asal_cabang_peserta) {
                            $('#asal_cabang_peserta').addClass('is-invalid');
                            $('.errorAsal_cabang_peserta').html(response.error.asal_cabang_peserta);
                        } else {
                            $('#asal_cabang_peserta').removeClass('is-invalid');
                            $('.errorAsal_cabang_peserta').html('');
                        }

                        if (response.error.nis) {
                            $('#nis').addClass('is-invalid');
                            $('.errorNis').html(response.error.nis);
                        } else {
                            $('#nis').removeClass('is-invalid');
                            $('.errorNis').html('');
                        }

                        if (response.error.level_peserta) {
                            $('#level_peserta').addClass('is-invalid');
                            $('.errorLevel_peserta').html(response.error.level_peserta);
                        } else {
                            $('#level_peserta').removeClass('is-invalid');
                            $('.errorLevel_peserta').html('');
                        }

                        if (response.error.jenkel) {
                            $('#jenkel').addClass('is-invalid');
                            $('.errorJenkel').html(response.error.jenkel);
                        } else {
                            $('#jenkel').removeClass('is-invalid');
                            $('.errorJenkel').html('');
                        }

                        if (response.error.nis) {
                            $('#nis').addClass('is-invalid');
                            $('.errorNis').html(response.error.nis);
                        } else {
                            $('#nis').removeClass('is-invalid');
                            $('.errorNis').html('');
                        }

                        if (response.error.nik) {
                            $('#nik').addClass('is-invalid');
                            $('.errorNik').html(response.error.nik);
                        } else {
                            $('#nik').removeClass('is-invalid');
                            $('.errorNik').html('');
                        }

                        if (response.error.tmp_lahir) {
                            $('#tmp_lahir').addClass('is-invalid');
                            $('.errorTmp_lahir').html(response.error.tmp_lahir);
                        } else {
                            $('#tmp_lahir').removeClass('is-invalid');
                            $('.errorTmp_lahir').html('');
                        }

                        if (response.error.tgl_lahir) {
                            $('#tgl_lahir').addClass('is-invalid');
                            $('.errorTgl_lahir').html(response.error.tgl_lahir);
                        } else {
                            $('#tgl_lahir').removeClass('is-invalid');
                            $('.errorTgl_lahir').html('');
                        }

                        if (response.error.pendidikan) {
                            $('#pendidikan').addClass('is-invalid');
                            $('.errorPendidikan').html(response.error.pendidikan);
                        } else {
                            $('#pendidikan').removeClass('is-invalid');
                            $('.errorPendidikan').html('');
                        }

                        if (response.error.jurusan) {
                            $('#jurusan').addClass('is-invalid');
                            $('.errorJurusan').html(response.error.jurusan);
                        } else {
                            $('#jurusan').removeClass('is-invalid');
                            $('.errorJurusan').html('');
                        }

                        if (response.error.status_kerja) {
                            $('#status_kerja').addClass('is-invalid');
                            $('.errorStatus_kerja').html(response.error.status_kerja);
                        } else {
                            $('#status_kerja').removeClass('is-invalid');
                            $('.errorStatus_kerja').html('');
                        }

                        if (response.error.pekerjaan) {
                            $('#pekerjaan').addClass('is-invalid');
                            $('.errorPekerjaan').html(response.error.pekerjaan);
                        } else {
                            $('#pekerjaan').removeClass('is-invalid');
                            $('.errorPekerjaan').html('');
                        }

                        if (response.error.hp) {
                            $('#hp').addClass('is-invalid');
                            $('.errorHp').html(response.error.hp);
                        } else {
                            $('#hp').removeClass('is-invalid');
                            $('.errorHp').html('');
                        }

                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.errorEmail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.errorEmail').html('');
                        }

                        if (response.error.domisili_peserta) {
                            $('#domisili_peserta').addClass('is-invalid');
                            $('.errorDomisili_peserta').html(response.error.domisili_peserta);
                        } else {
                            $('#domisili_peserta').removeClass('is-invalid');
                            $('.errorDomisili_peserta').html('');
                        }

                        if (response.error.alamat) {
                            $('#alamat').addClass('is-invalid');
                            $('.errorAlamat').html(response.error.alamat);
                        } else {
                            $('#alamat').removeClass('is-invalid');
                            $('.errorAlamat').html('');
                        }

                        if (response.error.status_peserta) {
                            $('#status_peserta').addClass('is-invalid');
                            $('.errorStatus_peserta').html(response.error.status_peserta);
                        } else {
                            $('#status_peserta').removeClass('is-invalid');
                            $('.errorStatus_peserta').html('');
                        }

                        if (response.error.user_id) {
                            $('#user_id').addClass('is-invalid');
                            $('.errorUser_id').html(response.error.user_id);
                        } else {
                            $('#user_id').removeClass('is-invalid');
                            $('.errorUser_id').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Berhasil Terima Peserta dari Cabang",
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