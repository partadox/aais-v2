<?= $this->extend('layout/main') ?>
<?= $this->extend('layout/menu') ?>
<?= $this->section('script') ?>

<!-- Sweet-Alert  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url() ?>public/assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url() ?>public/assets/js/metismenu.min.js"></script>
<script src="<?= base_url() ?>public/assets/js/jquery.slimscroll.js"></script>
<script src="<?= base_url() ?>public/assets/js/waves.min.js"></script>

<!-- App js -->
<script src="<?= base_url() ?>public/assets/js/app.js"></script>

<!-- Digital Clock JS-->
<script src="<?= base_url() ?>public/assets/js/clock.js"></script>

<!-- Image Preview Upload Image JS-->
<script src="<?= base_url() ?>public/assets/js/upload_image.js"></script>

<!-- Mask Money JS - Format Input Rupiah JS-->
<script src="<?= base_url() ?>public/assets/js/jquery.maskMoney.min.js"></script>

<!-- Custom Default Show DataTable-->
<script src="<?= base_url() ?>public/assets/js/default_show_dtb.js"></script>

<!-- Required datatable js -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Buttons examples -->
<script src="<?= base_url() ?>public/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/jszip.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url() ?>public/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>public/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<!--Summernote js-->
<script src="<?= base_url() ?>public/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Datatable init js -->
<script src="<?= base_url() ?>public/assets/pages/datatables.init.js"></script>
<!-- Date and Time Picker Booststrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.14.0/jquery.timepicker.min.js" integrity="sha512-s0SB4i9ezk9SRyV1Glrj/w5xS5ExSxXiN44fQeV9GYOtExbVWnC+mUsUyZdIYv6qXL0xe1qvpe0h1kk56gsgaA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>
    $('.datepicker2').datepicker({
        format: 'yyyy-mm-dd',
    });
    
</script>

<script>
    const user_id = '<?= session()->get('user_id') ?>'
    const base_url = '<?= base_url('/') ?>'
    const date = '<?= date('Y-m-d') ?>'
</script>
<script>
    $('a#logout').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin ingin logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('auth/logout') ?>",
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: "Anda Berhasil Logout!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1250
                        }).then(function() {
                            window.location = response.data.link;
                        });
                    }
                });
            }
        })
    })
</script>
<?= $this->endSection('script') ?>