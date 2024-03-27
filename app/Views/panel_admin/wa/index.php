<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?></h4>
</div>

<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>

<div class="table-responsive">
    <table id="datatable" class="table table-bordered mt-5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead>
            <tr>
                <th>NAMA FITUR</th>
                <th>SESSION STATUS</th>
                <th>CEK TERAKHIR</th>
                <th>TINDAKAN</th> 
            </tr>
        </thead>

        <tbody>
            <?php 
            foreach ($list as $data) :
                ?>
                <tr>
                    <td width="20%">WA Session AAIS Cabang</td>
                    <td width="15%">
                        <?php if($data['status'] == '0') { ?>
                            <button class="btn btn-secondary btn-sm" disabled>NONAKTIF</button>  
                        <?php } ?>
                        <?php if($data['status'] == '1') { ?>
                            <button class="btn btn-success btn-sm" disabled>AKTIF</button> 
                        <?php } ?>
                    </td>
                    <td width="20%"><?= shortdate_indo(substr($data['datetime'],0,10)) ?> <?= substr($data['datetime'],11,5) ?> WITA</td>
                    <td width="10%">
                        <button type="button" class="btn btn-warning mb-2" onclick="cek('<?= $data['id'] ?>','<?= $data['wa_key'] ?>')" >
                        <i class=" fa fa-sync mr-1"></i>Cek Session</button>
                        <?php if($data['status'] == '0') { ?>
                            <a href="https://wa-gateway.alhaqq.or.id/start-session?session=aaispusat&scan=true" type="button" class="btn btn-success mb-2" target="_blank"><i class="fa fa-plus-square mr-1"></i>New Session</a>
                        <?php } ?>
                        <?php if($data['status'] == '1') { ?>
                            <button type="button" class="btn btn-danger mb-2"  onclick="hapus('<?= $data['id'] ?>')"><i class="fa fa-trash mr-1"></i>Hapus Sesion</button>
                            <button type="button" class="btn btn-secondary mb-2" onclick="send()" >
                            <i class="mdi mdi-whatsapp mr-1"></i>Kirim WA</button>
                        <?php } ?>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function cek(id,key) {
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

    function hapus(id) {
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

    function send() {
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
</script>
<?= $this->endSection('isi') ?>