<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>

<?php if ($cek != 0) { ?>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <p class="mt-1">Catatan :<br>
            <i class="mdi mdi-information"></i> Anda akan terdaftar di kelas yang anda pilih setelah mengisi form pembayaran, melakukan pembayaran, dan pembayaran akan dikonfirmasi oleh sistem/admin.<br>
            <i class="mdi mdi-information"></i> Harap lakukan pembayaran sebelum batas waktu pembayaran.<br>
            <i class="mdi mdi-information"></i> Jika anda ingin memilih kelas lain harap tekan tombol batal.<br>
        </p>
        <hr>
        <h5 style="text-align:center"> Status Konfirmasi :
            <button class="btn btn-warning" disabled> Belum Bayar</button>
        </h5> <br>
        <h5 style="text-align:center; color:red">Batas Waktu Bayar: <br> Tgl: <?= shortdate_indo(substr($expired_waktu, 0, 10)) ?> <br> Jam: <?= substr($expired_waktu, 11, 5) ?> WITA</h5>

        <h5 style="text-align:center; color:red" id="demo"></h5> <br>

        <div class="card shadow-lg bg-white rounded">
            <div class="card-body">
                <button type="button" class="btn btn-danger" onclick="hapus(<?= $cart_id ?>, <?= $peserta_kelas_id ?>)">Batal</button>
                <h6><?= $kelas['nama_program'] ?></h6>
                <h5 class="card-title"><?= $kelas['nama_kelas'] ?></h5>
                <hr>
                <p> <i class="mdi mdi-calendar"></i> Hari = <?= $kelas['hari_kelas'] ?> </p>
                <p> <i class="mdi mdi-clock"></i> Waktu = <?= $kelas['waktu_kelas'] ?></p>
                <a> <i class="mdi mdi-teach"></i>
                    <?php if ($kelas['metode_kelas'] == 'OFFLINE') { ?>
                        Metode Perkuliahan = <span class="badge badge-secondary">TATAP MUKA / OFFLINE</span>
                    <?php } ?>
                    <?php if ($kelas['metode_kelas'] == 'ONLINE') { ?>
                        Metode Perkuliahan = <span class="badge badge-success">DARING / ONLINE</span>
                    <?php } ?>
                    <?php if ($kelas['metode_kelas'] == 'HYBRID') { ?>
                        Metode Perkuliahan = <span class="badge badge-info">HYBRID</span>
                    <?php } ?>
                </a>
                <hr>
                <p> <i class="mdi mdi-cash-marker"></i> Biaya Pendaftaran = Rp <?= rupiah($kelas['biaya_daftar']) ?></p>
                <p> <i class="mdi mdi-cash-marker"></i> Biaya Modul = Rp <?= rupiah($kelas['biaya_modul']) ?></p>
                <p> <i class="mdi mdi-cash-register"></i> SPP per Bulan = Rp <?= rupiah($kelas['biaya_bulanan']) ?> (x 4 Bulan)</p>
                <hr>
                <p> <i class="mdi mdi-bookmark-check"></i> Total Kuota = <?= $kelas['kouta'] ?></p>
                <h6> <i class="mdi mdi-bookmark-minus"> </i> Kuota Tersedia = <?= $kelas['kouta'] - $kelas['peserta_kelas_count'] ?> </h6>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-5 col-md-5">
                <div class="card shadow-lg bg-white rounded">
                    <div class="card-body">
                        <h6>Pilih yg akan dibayar</h6>
                        <div id="services">
                            <!-- Services will be added here -->
                        </div>
                        <hr>
                        <label for="keterangan_bayar">Keterangan Pembayaran</label>
                        <textarea class="form-control" name="keterangan_bayar" id="keterangan_bayar" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-7 col-md-7">
                <div class="card shadow-lg bg-white rounded">
                    <div class="card-body">
                        <div id="cart">
                            <label for="va_list">Metode Pembayaran<code>*</code></label>

                            <select class="form-control btn-square select2 mb-3" id="va_list">
                                <option value="" disabled selected>--Pilih--</option>
                                <?php foreach ($payment as $pay): ?>
                                    <option value="<?= $pay['payment_code'] ?>"><?= $pay['payment_name'] ?> (+ Rp <?= rupiah($pay['payment_price'] + (($pay['payment_tax'] / 100) * $pay['payment_price'])) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mb-3" id="detail_bank" style="display: none;">
                                <?php foreach ($payment_manual as $manual): ?>
                                    <h6 class="text-center"><?= $manual['payment_bank'] ?> - <?= $manual['payment_rekening'] ?> a.n <?= $manual['payment_atasnama'] ?></h6>
                                <?php endforeach; ?>
                            </div>
                            <h6>Daftar Pembayaran</h6>
                            <div id="cart-items" class="list-group">
                                <!-- Cart items will be added here -->
                            </div>
                            <h5 class="text-left">Total: Rp <span id="total-price">0</span></h5>
                            <button id="pay-btn" class="btn btn-primary" style="display: none;">Bayar via TF Manual</button>
                            <button id="pay-va-btn" class="btn btn-warning" style="display: none;">Bayar via Payment Gateway</button>
                            <button id="pay-beasiswa-btn" class="btn btn-success" style="display: none;">Beasiwa</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="viewmodalmanual"></div>
    <!-- Container-fluid Ends-->
<?php } ?>

<?php if ($cek == 0) { ?>
    <div class="card col d-flex justify-content-center shadow">
        <div class="card-body">
            <h5 class="card-title">Anda Belum Memiliki Tagihan Pendaftaran Kelas Yang Akan Dibayar.</h5>
            <p class="card-text">
                Silihkan Pilih Program Dan Kelas Dahulu di Menu Pilih Program.
            </p>
        </div>
    </div>
<?php } ?>

<script>
    /*--- Front-end Function---*/
    $(document).ready(function() {
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });

        var services = [{
                id: 5,
                name: "Pendaftaran",
                price: <?= $biaya_daftar ?>,
                fixed: true
            },
            {
                id: 1,
                name: "SPP-1",
                price: <?= $biaya_bulanan ?>,
                fixed: true
            },
            {
                id: 2,
                name: "SPP-2",
                price: <?= $biaya_bulanan ?>,
                fixed: true
            },
            {
                id: 3,
                name: "SPP-3",
                price: <?= $biaya_bulanan ?>,
                fixed: true
            },
            {
                id: 4,
                name: "SPP-4",
                price: <?= $biaya_bulanan ?>,
                fixed: true
            },
            {
                id: 6,
                name: "Modul",
                price: <?= $biaya_modul ?>,
                fixed: true
            },
            {
                id: 7,
                name: "INFAQ OPERASIONAL LTTQ AL HAQQ",
                price: 0,
                fixed: false
            },
            {
                id: 8,
                name: "Pemby. Lain",
                price: 0,
                fixed: false
            },
        ];
        var cart = [{
                id: 5,
                name: "Pendaftaran",
                price: <?= $biaya_daftar ?>
            },
            {
                id: 1,
                name: "SPP-1",
                price: <?= $biaya_bulanan ?>
            },
        ];
        var total = cart.reduce((sum, service) => sum + service.price, 0);

        var bankServices = [
            <?php foreach ($payment as $pay): ?> {
                    bank: '<?= $pay['payment_code'] ?>',
                    id: <?= $pay['payment_id'] ?>,
                    price: <?= $pay['payment_price'] + (($pay['payment_tax'] / 100) * $pay['payment_price']) ?>
                },
            <?php endforeach; ?>
        ];

        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function renderServices() {
            $('#services').empty();
            for (var i = 0; i < services.length; i++) {
                var isInCart = cart.find(item => item.id === services[i].id);
                var buttonClass = isInCart ? 'btn-secondary' : 'btn-success';
                if (services[i].fixed) {
                    $('#services').append(`
                        <hr>
                        <div class="card-service card mb-3 p-2">
                            <h6>${services[i].name}</h6>
                            <div>Biaya: Rp ${formatPrice(services[i].price)}</div>
                            <button class="add-to-cart btn ${buttonClass}" style="width: 150px;" data-id="${services[i].id}" data-price="${services[i].price}">${isInCart ? 'Sudah Dicek' : '<i class="fa fa-check"></i> Cek Bayar'}</button>
                        </div>
                    `);
                } else {
                    $('#services').append(`
                        <hr>
                        <div class="card-service card mb-3 p-2">
                            <h6>${services[i].name}</h6>
                            <input type="number" id="price-${services[i].id}" value="${formatPrice(services[i].price)}" min="0" step="5000" class="form-control mb-2" style="width: 150px;" placeholder="Masukan jumlah">
                            <button class="add-to-cart btn ${buttonClass}" data-id="${services[i].id}" style="width: 150px;">${isInCart ? 'Update jumlah' : '<i class="fa fa-check"></i> Cek Bayar'}</button>
                        </div>
                    `);
                }
            }
        }

        function renderCart() {
            $('#cart-items').empty();
            for (var i = 0; i < cart.length; i++) {
                var isBankService = cart[i].id >= 20 && cart[i].id <= 35;
                var isDaftar = cart[i].id == 5;
                var isSpp1 = cart[i].id == 1;
                $('#cart-items').append(`
                    <div class="list-group-item">
                        <span>${isBankService ? `Biaya Transaksi` : ''} ${!isBankService ? cart[i].name : ''} </span>  <br> 
                        <span>Rp ${formatPrice(cart[i].price)}</span>
                        ${!isBankService  &&!isDaftar ? `<button class="remove-from-cart btn btn-sm btn-danger float-right" data-id="${cart[i].id}"><i class="fa fa-trash mr-1"></i> Hapus</button>` : ''}
                    </div>
                `);
            }
            $('#total-price').text(formatPrice(total));
        }

        renderCart();

        $('#services').on('click', '.add-to-cart', function() {
            var serviceId = $(this).data('id');
            var service = services.find(item => item.id === serviceId);
            var servicePrice = service.fixed ? $(this).data('price') : Number($('#price-' + serviceId).val());
            var serviceInCart = cart.find(item => item.id === serviceId);

            if (serviceInCart) {
                total -= serviceInCart.price; // Subtract the old price from the total
                serviceInCart.price = servicePrice; // Update the price in the cart
            } else {
                cart.push({
                    id: serviceId,
                    name: service.name,
                    price: servicePrice
                });
            }

            total += servicePrice; // Add the new price to the total

            renderServices();
            renderCart();
        });

        $('#cart').on('click', '.remove-from-cart', function() {
            var serviceId = $(this).data('id');
            var index = cart.findIndex(item => item.id === serviceId);
            if (index !== -1) {
                total -= cart[index].price;
                cart.splice(index, 1);
            }
            renderServices();
            renderCart();
        });

        renderServices();

        function addToCartByBankName(bankName) {
            var bankService = bankServices.find(item => item.bank === bankName);
            var serviceInCart = cart.find(item => item.id >= 20 && item.id <= 35);

            if (serviceInCart) {
                total -= serviceInCart.price; // Subtract the old price from the total
                var index = cart.indexOf(serviceInCart);
                cart.splice(index, 1); // Remove the bank service from the cart
            }

            if (!bankService) return;

            cart.push({
                id: bankService.id,
                name: bankName.toUpperCase(),
                price: bankService.price
            });
            total += bankService.price; // Add the new price to the total

            renderServices();
            renderCart();
        }

        $('#va_list').change(function() {
            if ($(this).val() == 'manual_1' || $(this).val() == 'manual_2') {
                document.getElementById('detail_bank').style.display = "block";
                document.getElementById('pay-btn').style.display = "block";
                document.getElementById('pay-va-btn').style.display = "none";
                document.getElementById('pay-beasiswa-btn').style.display = "none";
            } else if ($(this).val() == 'beasiswa') {
                document.getElementById('detail_bank').style.display = "none";
                document.getElementById('pay-btn').style.display = "none";
                document.getElementById('pay-va-btn').style.display = "none";
                document.getElementById('pay-beasiswa-btn').style.display = "block";
            } else {
                document.getElementById('detail_bank').style.display = "none";
                document.getElementById('pay-btn').style.display = "none";
                document.getElementById('pay-va-btn').style.display = "block";
                document.getElementById('pay-beasiswa-btn').style.display = "none";
            }
            var selectedValue = $(this).val();
            addToCartByBankName(selectedValue);

        });

        $('#pay-btn').click(function() {
            Swal.fire({
                title: 'Form Upload Bukti Bayar',
                html: ` <p>Total TF = Rp ${formatPrice(total)}</p>
                        <label>Bukti Transfer<code>*</code></label>
                        <input type="file" id="pay_image" accept="image/png, image/jpeg" class="form-control mb-3">
                        <div id="image_preview_div"></div>`,
                showCancelButton: true,
                confirmButtonText: 'Upload',
                cancelButtonText: 'Batal',
                focusConfirm: false,
                allowOutsideClick: false,
                preConfirm: () => {
                    let keterangan_bayar = document.getElementById('keterangan_bayar').value;
                    let image = document.getElementById('pay_image').files[0];
                    let formData = new FormData();
                    formData.append('keterangan_bayar', keterangan_bayar);
                    formData.append('image', image);
                    formData.append('cart', JSON.stringify(cart));
                    formData.append('total', total);
                    formData.append('peserta_kelas_id', <?= $peserta_kelas_id ?>);
                    formData.append('peserta_id', <?= $peserta_id ?>);
                    formData.append('kelas_id', <?= $kelas_id ?>);
                    formData.append('cart_id', <?= $cart_id ?>);
                    formData.append('expired_waktu', '<?= $expired_waktu ?>');
                    return $.ajax({
                        url: "<?= site_url('/bayar/save-manual') ?>",
                        type: "post",
                        dataType: "json",
                        processData: false, // This is important
                        contentType: false, // This is important
                        data: formData
                    });
                }
            }).then((result) => {
                if (result.value.error) {
                    Swal.fire({
                        title: "Error!",
                        text: result.value.error,
                        icon: "error",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    });
                } else {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Form Pembayaran Anda Disimpan, Tunggu Konfirmasi dari Admin.",
                        icon: "success",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 1500
                    }).then(function() {
                        window.location = '/bayar/riwayat';
                    });
                }
            });
        });

        $(document).on('change', '#pay_image', function(event) {
            let reader = new FileReader();
            reader.onload = function() {
                let preview = document.createElement('img');
                preview.id = 'image_preview';
                preview.src = reader.result;
                preview.style.height = '200px';
                preview.style.width = '150px';
                document.getElementById('image_preview_div').appendChild(preview);
            }
            reader.readAsDataURL(event.target.files[0]);
        });

        $('#pay-va-btn').click(function() {
            event.preventDefault();
            let keterangan_bayar = document.getElementById('keterangan_bayar').value;
            let formData = new FormData();
            formData.append('cart', JSON.stringify(cart));
            formData.append('total', total);
            formData.append('peserta_kelas_id', <?= $peserta_kelas_id ?>);
            formData.append('peserta_id', <?= $peserta_id ?>);
            formData.append('kelas_id', <?= $kelas_id ?>);
            formData.append('cart_id', <?= $cart_id ?>);
            formData.append('expired_waktu', '<?= $expired_waktu ?>');
            formData.append('keterangan_bayar', keterangan_bayar);

            // Display a loading alert with no buttons
            Swal.fire({
                title: 'Loading...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: '/bayar/generate-flip',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Close the loading alert
                    Swal.close();

                    if (response.error) {
                        // Handle the error: display an alert with the error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                        });
                    } else {

                        // assuming response is a JSON object and contains account_number and bank_code
                        let bank = response.bank_code;
                        let va = response.account_number;

                        Swal.fire({
                            title: 'Payment details',
                            html: `
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                        <th>Total</th>
                                        <th>Rp ${formatPrice(total)}</th>
                                        </tr>
                                        <tr>
                                        <th>Batas Waktu</th>
                                        <th><?= $expired_waktu ?></th>
                                        </tr>
                                        <tr>
                                        <th>Bank</th>
                                        <th>${bank}</th>
                                        </tr>
                                        <tr>
                                        <th>VA</th>
                                        <th>${va} <br>
                                            <button id="copy" class="btn btn-success"><i class="fas fa-copy mr-1"></i> Klik utk Copy VA</button></th>
                                        </tr>
                                    </tbody>
                                </table>
                            `,
                            confirmButtonText: 'Tutup',
                            allowOutsideClick: false,
                            didOpen: () => {
                                const vaValue = va;

                                $('#copy').click(function() {
                                    const tempInput = document.createElement('input');
                                    tempInput.value = vaValue;
                                    document.body.appendChild(tempInput);
                                    tempInput.select();
                                    tempInput.setSelectionRange(0, 99999); // For mobile devices
                                    document.execCommand('copy');
                                    document.body.removeChild(tempInput);

                                    // Update the text of the button
                                    $(this).html('<i class="fas fa-check"></i> VA dicopy');
                                })
                            },
                            didClose: () => {
                                window.location.href = "/bayar/riwayat";
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Close the loading alert
                    Swal.close();
                    console.log(textStatus, errorThrown);
                }
            });
        });

        $('#pay-beasiswa-btn').click(function() {
            Swal.fire({
                title: 'Form Daftar dengan Beasiswa',
                html: ` <label>Masukan Kode Beasiswa</label>
                        <input type="text" id="beasiswa_code" class="form-control mb-3"></input>`,
                showCancelButton: true,
                confirmButtonText: 'Cek',
                cancelButtonText: 'Batal',
                focusConfirm: false,
                allowOutsideClick: false,
                preConfirm: () => {
                    let beasiswa_code = document.getElementById('beasiswa_code').value;
                    let formData = new FormData();
                    formData.append('beasiswa_code', beasiswa_code);
                    formData.append('cart', JSON.stringify(cart));
                    formData.append('total', total);
                    formData.append('peserta_kelas_id', <?= $peserta_kelas_id ?>);
                    formData.append('peserta_id', <?= $peserta_id ?>);
                    formData.append('kelas_id', <?= $kelas_id ?>);
                    formData.append('cart_id', <?= $cart_id ?>);
                    formData.append('expired_waktu', '<?= $expired_waktu ?>');
                    return $.ajax({
                        url: "<?= site_url('/bayar/save-beasiswa') ?>",
                        type: "post",
                        dataType: "json",
                        processData: false, // This is important
                        contentType: false, // This is important
                        data: formData
                    });
                }
            }).then((result) => {
                if (result.value.error) {
                    Swal.fire({
                        title: "Error!",
                        text: result.value.error,
                        icon: "error",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    });
                } else {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Form Pembayaran dengan Beasiswa Disimpan, Tunggu Konfirmasi dari Admin.",
                        icon: "success",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 1500
                    }).then(function() {
                        window.location = '/bayar/riwayat';
                    });
                }
            });
        });

    });



    /*--- Cancel Cart ---*/
    function hapus(cart_id, peserta_kelas_id) {
        Swal.fire({
            title: 'Batal Daftar?',
            text: `Apakah anda yakin membatalkan pendaftaran program/kelas ini?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('/bayar/cancel') ?>",
                    type: "post",
                    dataType: "json",
                    data: {
                        cart_id: cart_id,
                        peserta_kelas_id: peserta_kelas_id,
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Anda berhasil membatalkan ambil program/kelas",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location = response.sukses.link;
                            });
                        }
                    }
                });
            }
        })
    }

    /*--- Countdown Function---*/
    // Receive the server time from PHP
    let serverTime = new Date('<?= $jsFriendlyTime ?>');
    let timeOffset = serverTime.getTime() - new Date().getTime();

    // Your countdown function
    let endTime = new Date('<?= $expired_waktu ?>').getTime();

    function updateTime() {
        let now = new Date().getTime() + timeOffset;
        let distance = endTime - now;

        if (distance < 0) {
            document.getElementById("demo").innerHTML = "";
            clearInterval(intervalId);
            return;
        }

        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("demo").innerHTML = `${hours} jam-${minutes} mnt-${seconds} dtk`;
    }

    // Update the timer every second
    let intervalId = setInterval(updateTime, 1000);
</script>

<?= $this->endSection('isi') ?>