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
    <?php if ($user['level'] == 1 || $user['level'] == 2 || $user['level'] == 3) { ?>
        $(document).ready(function() {
            function updateWhatsAppStatus() {
                $.ajax({
                    url: "<?= site_url('/wa-status?id=1') ?>", 
                    type: "GET",
                    dataType: "json", 
                    success: function(response) {
                        $('#statusWa').text(response.statusShow);
                        $('#datetimeWa').text(response.datetimeShow); 

                        // $('#divCreateWa').hide(); 
                        // $('#divTesWa').show(); 
                        // $('#divDelWa').hide(); 

                        $('#waCek').attr('onclick', 'waCek(event, "' + response.id + '", "' + response.key + '");');
                        $('#waDel').attr('onclick', 'waDel(event, "' + response.id + '");');

                        if(response.status == "0") {
                            // For status "0"
                            $('.wag-icon').removeClass('text-secondary').addClass('text-danger');
                            $('.wag-icon').html('<i class="mdi mdi-close-circle mdi-18px"></i>');
                            $('#divCreateWa').show(); 
                            $('#divTesWa').hide(); 
                            $('#divDelWa').hide(); 
                        } else if(response.status == "1") {
                            $('.wag-icon').removeClass('text-secondary').addClass('text-success');
                            $('.wag-icon').html('<i class="mdi mdi-check-circle mdi-18px"></i>');
                            $('#divCreateWa').hide(); 
                            $('#divTesWa').show(); 
                            $('#divDelWa').show(); 
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + status + ", " + error);
                    }
                });
            }
            function updateWhatsAppStatusCb() {
                $.ajax({
                    url: "<?= site_url('/wa-status?id=2') ?>", 
                    type: "GET",
                    dataType: "json", 
                    success: function(response) {
                        $('#statusWa2').text(response.statusShow);
                        $('#datetimeWa2').text(response.datetimeShow); 

                        // $('#divCreateWa').hide(); 
                        // $('#divTesWa').show(); 
                        // $('#divDelWa').hide(); 

                        $('#waCek2').attr('onclick', 'waCek2(event, "' + response.id + '", "' + response.key + '");');
                        $('#waDel2').attr('onclick', 'waDel2(event, "' + response.id + '");');

                        if(response.status == "0") {
                            // For status "0"
                            $('.wag-icon2').removeClass('text-secondary').addClass('text-danger');
                            $('.wag-icon2').html('<i class="mdi mdi-close-circle mdi-18px"></i>');
                            $('#divCreateWa2').show(); 
                            $('#divTesWa2').hide(); 
                            $('#divDelWa2').hide(); 
                        } else if(response.status == "1") {
                            $('.wag-icon2').removeClass('text-secondary').addClass('text-success');
                            $('.wag-icon2').html('<i class="mdi mdi-check-circle mdi-18px"></i>');
                            $('#divCreateWa2').hide(); 
                            $('#divTesWa2').show(); 
                            $('#divDelWa2').show(); 
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + status + ", " + error);
                    }
                });
            }
            updateWhatsAppStatus();
            updateWhatsAppStatusCb();
        });

        function waCek(event,id,key) {
            event.preventDefault();
            var loadingSpinner = Swal.fire({
                title: 'Loading...',
                text: 'Harap tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: "GET",
                url: "https://wa-gateway.alhaqq.or.id/sessions?key="+key,
                dataType: "json",
                success: function(response) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('/wa-update') ?>",
                        data: {
                            id: id,
                            response: response.data.length,
                            modul: "cek"
                        },
                    });
                    loadingSpinner.close();
                    if (response.data.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Session Expired',
                            allowOutsideClick: false,
                            showConfirmButton: true,
                            confirmButtonColor: '#e1be0d',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Anda memiliki session WA',
                            allowOutsideClick: false,
                            showConfirmButton: true,
                            confirmButtonColor: '#e1be0d',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                }
            });
        }

        function waDel(event,id) {
            event.preventDefault();
            Swal.fire({
                title: "Hapus Session WA?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Hapus",
                confirmButtonColor: '#fc0341',
                allowOutsideClick: false,
                }).then((result) => {
                if (result.isConfirmed) {
                    var loadingSpinner = Swal.fire({
                        title: 'Loading...',
                        text: 'Harap tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: "https://wa-gateway.alhaqq.or.id/delete-session?session=aaispusat",
                        dataType: "json",
                        success: function(response) {
                            $.ajax({
                                type: "POST",
                                url: "<?= site_url('/wa-update') ?>",
                                data: {
                                    id: id,
                                    modul: "hapus"
                                },
                                success: function (response) {
                                    // Close loading spinner
                                    loadingSpinner.close();

                                    if (response.success == false) {
                                        Swal.fire({
                                            title: "Error!",
                                            text: "Terjadi kesalahan",
                                            icon: "error",
                                            allowOutsideClick: false,
                                            showConfirmButton: true,
                                            confirmButtonColor: '#e1be0d',
                                            timer: 9000,
                                        });
                                    } 
                                    
                                    if (response.success == true) {
                                        Swal.fire({
                                            title: "Session Terhapus",
                                            text: "Berhasil hapus session",
                                            icon: "success",
                                            allowOutsideClick: false,
                                            showConfirmButton: true,
                                            confirmButtonColor: '#e1be0d',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    // Close loading spinner
                                    loadingSpinner.close();
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi kesalahan dalam request.",
                                        icon: "error",
                                        allowOutsideClick: false,
                                        showConfirmButton: true,
                                        confirmButtonColor: '#e1be0d',
                                        timer: 9000,
                                    });
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                        }
                    });
                }
            });
        }

        function waTes(event) {
            event.preventDefault();
            Swal.fire({
                title: "Masukan Nomor HP Anda, Format (628xxxxxx)",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Kirim WA Tes",
                confirmButtonColor: '#e1be0d',
                showLoaderOnConfirm: true,
                preConfirm: async (phoneNumber) => {
                    try {
                        const url = `https://wa-gateway.alhaqq.or.id/send-message?session=aaispusat&to=${phoneNumber}&text=WA-Gateway%0ATes%0AKirim%20Pesan`;
                        const response = await fetch(url);
                        if (!response.ok) {
                            return Swal.showValidationMessage(`
                            ${JSON.stringify(await response.json())}
                            `);
                    }

                    return response.json();
                    } catch (error) {
                        Swal.showValidationMessage(`
                            Request failed: ${error}
                        `);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Pesan Terkirim",
                        icon: 'success',
                        text: "Harap Cek WA Anda",
                        showCancelButton: false,
                        showConfirmButton: true,
                        confirmButtonText: "Tutup",
                        confirmButtonColor: '#e1be0d',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            });
        }

        function waCek2(event,id,key) {
            event.preventDefault();
            var loadingSpinner = Swal.fire({
                title: 'Loading...',
                text: 'Harap tunggu',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                type: "GET",
                url: "https://91102.aais-alhaqq.or.id/sessions?key="+key,
                dataType: "json",
                success: function(response) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('/wa-update') ?>",
                        data: {
                            id: id,
                            response: response.data.length,
                            modul: "cek"
                        },
                    });
                    loadingSpinner.close();
                    if (response.data.length === 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Session Expired',
                            allowOutsideClick: false,
                            showConfirmButton: true,
                            confirmButtonColor: '#e1be0d',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Anda memiliki session WA',
                            allowOutsideClick: false,
                            showConfirmButton: true,
                            confirmButtonColor: '#e1be0d',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                }
            });
        }

        function waDel2(event,id) {
            event.preventDefault();
            Swal.fire({
                title: "Hapus Session WA?",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Hapus",
                confirmButtonColor: '#fc0341',
                allowOutsideClick: false,
                }).then((result) => {
                if (result.isConfirmed) {
                    var loadingSpinner = Swal.fire({
                        title: 'Loading...',
                        text: 'Harap tunggu',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        type: "GET",
                        url: "https://91102.aais-alhaqq.or.id/delete-session?session=aaisjan",
                        dataType: "json",
                        success: function(response) {
                            $.ajax({
                                type: "POST",
                                url: "<?= site_url('/wa-update') ?>",
                                data: {
                                    id: id,
                                    modul: "hapus"
                                },
                                success: function (response) {
                                    // Close loading spinner
                                    loadingSpinner.close();

                                    if (response.success == false) {
                                        Swal.fire({
                                            title: "Error!",
                                            text: "Terjadi kesalahan",
                                            icon: "error",
                                            allowOutsideClick: false,
                                            showConfirmButton: true,
                                            confirmButtonColor: '#e1be0d',
                                            timer: 9000,
                                        });
                                    } 
                                    
                                    if (response.success == true) {
                                        Swal.fire({
                                            title: "Session Terhapus",
                                            text: "Berhasil hapus session",
                                            icon: "success",
                                            allowOutsideClick: false,
                                            showConfirmButton: true,
                                            confirmButtonColor: '#e1be0d',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    // Close loading spinner
                                    loadingSpinner.close();
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi kesalahan dalam request.",
                                        icon: "error",
                                        allowOutsideClick: false,
                                        showConfirmButton: true,
                                        confirmButtonColor: '#e1be0d',
                                        timer: 9000,
                                    });
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                        }
                    });
                }
            });
        }

        function waTes2(event) {
            event.preventDefault();
            Swal.fire({
                title: "Masukan Nomor HP Anda, Format (628xxxxxx)",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                cancelButtonText: "Batal",
                confirmButtonText: "Kirim WA Tes",
                confirmButtonColor: '#e1be0d',
                showLoaderOnConfirm: true,
                preConfirm: async (phoneNumber) => {
                    try {
                        const url = `https://91102.aais-alhaqq.or.id/send-message?session=aaisjan&to=${phoneNumber}&text=WA-Gateway%0ATes%0AKirim%20Pesan`;
                        const response = await fetch(url);
                        if (!response.ok) {
                            return Swal.showValidationMessage(`
                            ${JSON.stringify(await response.json())}
                            `);
                    }

                    return response.json();
                    } catch (error) {
                        Swal.showValidationMessage(`
                            Request failed: ${error}
                        `);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Pesan Terkirim",
                        icon: 'success',
                        text: "Harap Cek WA Anda",
                        showCancelButton: false,
                        showConfirmButton: true,
                        confirmButtonText: "Tutup",
                        confirmButtonColor: '#e1be0d',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    <?php } ?>
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