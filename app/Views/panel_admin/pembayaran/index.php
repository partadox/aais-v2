<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<?php
if (session()->getFlashdata('pesan_error')) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <i class="mdi mdi-alert-circle"></i> <strong>';
    echo session()->getFlashdata('pesan_error');
    echo ' </strong> </div>';
}
if (session()->getFlashdata('pesan_sukses')) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button> <i class="mdi mdi-check-circle"></i> <strong>';
    echo session()->getFlashdata('pesan_sukses');
    echo ' </strong> </div>';
}
?>

<div class="row">
    <div class="col-md-6 mb-2">
        <form method="POST" action="<?= base_url('pembayaran/filter') ?>">
            <div class="row mb-3">
                <div class="col">
                    <label for="angkatan_filter">Angkatan</label>
                    <select class="form-control select2" name="angkatan_filter" id="angkatan_filter" >
                        <?php foreach ($list_angkatan as $key => $data) { ?>
                        <option value="<?= $data['angkatan_kelas'] ?>" <?php if ($angkatan == $data['angkatan_kelas']) echo "selected"; ?> > <?= $data['angkatan_kelas'] ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col">
                    <label for="payment_filter">Metode Bayar</label>
                    <select class="form-control select2" name="payment_filter" id="payment_filter" >
                        <option value="all" <?php if ($payment_filter == "all") echo "selected"; ?> > Semua </option>
                        <option value="tf" <?php if ($payment_filter == "tf") echo "selected"; ?> > TF Manual </option>
                        <option value="flip" <?php if ($payment_filter == "flip") echo "selected"; ?> > Flip </option>
                        <option value="beasiswa" <?php if ($payment_filter == "beasiswa") echo "selected"; ?> > Beasiswa </option>
                    </select>
                </div>
                <div class="col">
                    <button type="submit" id=filter class="btn btn-primary mt-4">Filter</button>
                    <button type="submit" id=export class="btn btn-secondary mt-4">Export Excel</button>
                </div>
            </div>
        </form>
    </div>
    <!-- <div class="col-md-2">
        <div class="row mt-3">
            <div class="col">
                <a class="btn btn-secondary" href="<?= base_url('pembayaran/export_transaksi') ?>"> 
                    <i class=" fa fa-file-download"></i> Export Excel (Download)
                </a>
            </div>
        </div>
        
    </div> -->
</div>

<div class="viewdata">
</div>


<div class="viewmodaldataedit">
</div>

<div class="viewmodalgambar">
</div>

<script>

    function list(angkatan, payment_filter) {
        $.ajax({
            url: "<?= site_url('pembayaran/list') ?>",
            type: "POST", // or GET, depending on what your server expects
            data: {
                angkatan: angkatan,
                payment_filter: payment_filter
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            }
        });
    }

    $(document).ready(function() {
        list('<?= $angkatan ?>', '<?= $payment_filter ?>');
        $('.js-example-basic-single').select2({
            minimumResultsForSearch: Infinity
        });

        $('#filter').click(function (e) {
            e.preventDefault();
            $('form').attr('action', '<?= base_url("pembayaran/filter") ?>');
            $('form').submit();
        });
        
        $('#export').click(function (e) {
            e.preventDefault();
            $('form').attr('action', '<?= base_url("pembayaran/export") ?>');
            $('form').submit();
        });
    });

</script>


<?= $this->endSection('isi') ?>