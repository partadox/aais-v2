<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<form method="POST">
    <div class="row">
        <div class="col-auto mb-2">
            <label for="angkatan">Pilih Angkatan Perkuliahan</label>
            <select class="form-control js-example-basic-single" name="angkatan" id="angkatan" class="js-example-basic-single mb-2" required>
                <option value="" disabled <?php if ($angkatan == NULL ) echo "selected"; ?> >--PILIH--</option>
                <?php foreach ($list_angkatan as $key => $data) { ?>
                    <option value="<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan == $data['angkatan_kelas']) echo "selected"; ?>> <?= $data['angkatan_kelas'] ?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-auto mb-2">
            <label for="program">Pilih Program</label>
            <select class="form-control js-example-basic-single" name="program" id="program" class="js-example-basic-single mb-2" required>
                <option value="" disabled <?php if ($program_id == NULL ) echo "selected"; ?> >--PILIH--</option>
                <?php foreach ($list_program_uc as $key => $data) { ?>
                    <option value="<?= $data['program_id'] ?>" <?php if ($program_id == $data['program_id']) echo "selected"; ?>> <?= $data['nama_program'] ?> </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-auto mb-2">
            <button type="submit" id="filter" class="btn btn-primary mt-4"><i class="fa fa-search"></i> Filter</button>
        </div>
        <div class="col-auto mb-2">
            <button type="submit" id="export" class="btn btn-secondary mt-4"><i class="fa fa-download"></i> Export Excel</button>
        </div>
        <div class="col-auto mb-2">
            <button type="button" class="btn btn-success mt-4" onclick="modalimport()"  ><i class=" fa fa-file-excel"></i> Import File Excel</button>
        </div>
    </div>
</form>

<div class="viewdata"></div>
<div class="viewmodal"></div>
<div class="viewmodalimport"></div>

<script>
    $(document).ready(function() {

        $('#filter').click(function (e) {
            e.preventDefault();
            $('form').attr('action', '<?= base_url("/ujian-custom/filter") ?>');
            $('form').submit();
        });

        $('#export').click(function (e) {
            e.preventDefault();
            $('form').attr('action', '<?= base_url("/ujian-custom/export") ?>');
            $('form').submit();
        });
    });

    function modalimport() {
        $.ajax({
            type: "post",
            url: "<?= site_url('ujian-custom/modal-import') ?>",
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodalimport').html(response.sukses).show();
                    $('#modalimport').modal('show');
                }
            }
        });
    }
</script>

<?php if($modul == 'Filter') { ?>
    <script>
        function list(angkatan, program) {
            $.ajax({
                url: "<?= base_url('/ujian-custom/list') ?>",
                type: "POST", // or GET, depending on what your server expects
                data: {
                    angkatan: angkatan,
                    program: program,
                },
                dataType: "json",
                success: function(response) {
                    $('.viewdata').html(response.data);
                }
            });
        }

        $(document).ready(function() {
            list('<?= $angkatan ?>', '<?= $program_id ?>');
        });
    </script>
<?php } ?>

<?= $this->endSection('isi') ?>