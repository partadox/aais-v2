<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>


<a href="<?= base_url('/program-regular') ?>"> 
    <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
</a>

<?php echo form_open_multipart('/program-regular-ujian-setting/save'); ?>
<?= csrf_field(); ?>
<h5 style="text-align:center;">Program <?= $program['nama_program'] ?></h5>
<div class="row">
    <div class="col d-flex flex-column align-items-center justify-content-center">
        <label for="ujian_custom_status">Pilih Fitur Ujian <br> <code>(Standart/Custom)</code></label>
        <select class="form-control text-center col-2" name="ujian_custom_status" id="ujian_custom_status" onchange="showDiv(this)">
            <option value="0" <?php if ($program['ujian_custom_status'] == NULL) echo "selected"; ?> >Standart</option>
            <option value="1" <?php if ($program['ujian_custom_status'] != NULL) echo "selected"; ?> >Custom</option>  
        </select>
        <br>
        <b>Nilai Ujian Tampil: </b>
        <select class="form-control text-center col-2" name="ujian_show" id="ujian_show">
            <option value="0" <?php if ($program['ujian_show'] != 1) echo "selected"; ?> >TIDAK</option>
            <option value="1" <?php if ($program['ujian_show'] == 1) echo "selected"; ?> >TAMPIL</option>  
        </select>
        <input type="hidden" name="program_id" id="program_id" value="<?= $program['program_id'] ?>">
        <?php if($ujian_custom == NULL) { ?>
            <input type="hidden" name="ujian_custom_id" id="ujian_custom_id" value="">
        <?php } ?>
        <?php if($ujian_custom != NULL) { ?>
            <input type="hidden" name="ujian_custom_id" id="ujian_custom_id" value="<?= $ujian_custom['id'] ?>">
        <?php } ?>
    </div>
</div>
<div class="card shadow mt-4"id="variabel"  <?php if($program['ujian_custom_status'] == NULL) { ?> style="display: none;" <?php } ?> >
    <div class="card-body">
        <h5>Pengaturan Variable Pengujian (Kolom)</h5>
        <hr>
        <div class="row">
            <div class="col-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5>Variable Pengujian (Kolom) Tipe Teks</h5>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20%">Variabel</th>
                                    <th width="40%">Status</th>
                                    <th width="40%">Nama Variabel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=1; $i <= 10; $i++): ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <select class="form-control" name="text<?=$i?>_status" id="text<?=$i?>_status" onchange="updateInputRequiredStatus('text<?=$i?>_name', 'text<?=$i?>_status')">
                                                <option disabled  <?php if($ujian_custom == NULL) { ?> selected <?php } ?> > ---PILIH--- </option>
                                                <option value="1" <?php if($ujian_custom != NULL && $ujian_custom['text'.$i.'_status'] == "1") { ?> selected <?php } ?> > 
                                                Aktif</option>
                                                <option value="0"  <?php if($ujian_custom != NULL && ($ujian_custom['text'.$i.'_status'] == "0" || $ujian_custom['text'.$i.'_status'] == NULL) ) { ?> selected <?php } ?> >Nonaktif</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="text<?=$i?>_name" id="text<?=$i?>_name" <?php if($ujian_custom != NULL && isset($ujian_custom['text'.$i.'_name'])) { ?> value="<?= $ujian_custom['text'.$i.'_name'] ?>" <?php } ?> >
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h5>Variable Pengujian (Kolom) Tipe Numerik</h5>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20%">Variabel</th>
                                    <th width="40%">Status</th>
                                    <th width="40%">Nama Variabel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=1; $i <= 10; $i++): ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <select class="form-control" name="int<?=$i?>_status" id="int<?=$i?>_status" onchange="updateInputRequiredStatus('int<?=$i?>_name', 'int<?=$i?>_status')">
                                                <option disabled  <?php if($ujian_custom == NULL) { ?> selected <?php } ?> > ---PILIH--- </option>
                                                <option value="1" <?php if($ujian_custom != NULL && $ujian_custom['int'.$i.'_status'] == "1") { ?> selected <?php } ?> > 
                                                Aktif</option>
                                                <option value="0"  <?php if($ujian_custom != NULL && ($ujian_custom['int'.$i.'_status'] == "0" || $ujian_custom['int'.$i.'_status'] == NULL) ) { ?> selected <?php } ?> >Nonaktif</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="int<?=$i?>_name" id="int<?=$i?>_name" <?php if($ujian_custom != NULL && isset($ujian_custom['int'.$i.'_name'])) { ?> value="<?= $ujian_custom['int'.$i.'_name'] ?>" <?php } ?> >
                                        </td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-4 d-flex flex-column align-items-center justify-content-center">
    <button type="submit" class="btn btn-primary "><i class="fa fa-share-square"></i> Simpan</button>
</div>

<?php echo form_close() ?>

<script>
    function showDiv(select){
        if(select.value=="1"){
            document.getElementById('variabel').style.display = "block";
            } else{
            document.getElementById('variabel').style.display = "none";
        }
    } 

    function updateInputRequiredStatus(inputId, selectId) {
        const inputElement = document.getElementById(inputId);
        const selectElement = document.getElementById(selectId);

        if (selectElement.value === '1') {
            inputElement.setAttribute('required', 'required');
        } else {
            inputElement.removeAttribute('required');
        }
    }

    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault();

            // Show loading animation
            let loadingSwal = Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        loadingSwal.close(); // Close the loading animation
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to the specified URL
                                window.location.href = '/program-regular-ujian-setting?id=<?= $program['program_id'] ?>';
                            }
                        });
                    }
                },
                error: function() {
                    loadingSwal.close(); // Close the loading animation
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred.',
                        allowOutsideClick: false
                    });
                }
            });
        });
    });
</script>

<?= $this->endSection('isi') ?>