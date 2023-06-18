<?= $this->extend('layout/script') ?>

<?= $this->section('judul') ?>
<div class="col-sm-6">
    <h4 class="page-title"><?= $title ?> </h4>
</div>
<?= $this->endSection('judul') ?>

<?= $this->section('isi') ?>
</p>

<?php if ($cek == 0) { ?>
<!-- Container-fluid starts-->
<div class="container-fluid">
    <a href="<?= base_url('/peserta-kelas') ?>"> 
        <button type="button" class="btn btn-secondary mb-3"><i class=" fa fa-arrow-circle-left"></i> Kembali</button>
    </a>
    <div class="card shadow-lg bg-white rounded">
        <div class="card-body">
            <h6><?= $kelas['nama_program'] ?></h6>
            <h5 class="card-title"><?= $kelas['nama_kelas'] ?></h5>
            <hr>
            <p> <i class="mdi mdi-calendar"></i> Hari = <?= $kelas['hari_kelas'] ?> </p>
            <p> <i class="mdi mdi-clock"></i> Waktu = <?= $kelas['waktu_kelas'] ?></p>
            <p> <i class="mdi mdi-account-supervisor"></i> Pengajar = <?= $kelas['nama_pengajar'] ?></p>
            <a> <i class="mdi mdi-teach"></i>
                <?php if($kelas['metode_kelas'] == 'OFFLINE') { ?>
                    Metode Perkuliahan = <span class="badge badge-secondary">TATAP MUKA / OFFLINE</span>
                <?php } ?>
                <?php if($kelas['metode_kelas'] == 'ONLINE') { ?>
                    Metode Perkuliahan = <span class="badge badge-success">DARING / ONLINE</span>
                <?php } ?>
            </a>
            <hr>
                <?php 
                    $totalBiaya = $kelas['biaya_daftar'] + $kelas['biaya_program'];
                    $totalBayar = $peserta_kelas['byr_daftar'] + $peserta_kelas['byr_spp1'] + $peserta_kelas['byr_spp2'] + $peserta_kelas['byr_spp3'] + $peserta_kelas['byr_spp4'];
                    $totalBeasiswa = 0;

                    // Jika beasiswa diterima, anggap sebagai pembayaran
                    if($peserta_kelas['beasiswa_daftar'] == 1) {
                        $totalBeasiswa += $kelas['biaya_daftar'];
                    }
                    if($peserta_kelas['beasiswa_spp1'] == 1) {
                        $totalBeasiswa += $kelas['biaya_bulanan'];
                    }
                    if($peserta_kelas['beasiswa_spp2'] == 1) {
                        $totalBeasiswa += $kelas['biaya_bulanan'];
                    }
                    if($peserta_kelas['beasiswa_spp3'] == 1) {
                        $totalBeasiswa += $kelas['biaya_bulanan'];
                    }
                    if($peserta_kelas['beasiswa_spp4'] == 1) {
                        $totalBeasiswa += $kelas['biaya_bulanan'];
                    }
                    // total pembayaran ditambah dengan total beasiswa
                    $totalBayar += $totalBeasiswa;

                    if($totalBiaya - $totalBayar != 0) { ?>
                        <strong>Status SPP: </strong>  <button class="btn btn-warning btn-sm mb-2" disabled>BELUM LUNAS</button> <br>
                <?php } ?>
                <?php if($totalBiaya - $totalBayar == 0) { ?>
                    <strong>Status SPP: </strong> <button class="btn btn-success btn-sm mb-2" disabled>LUNAS</button> <br>
                <?php } ?>
                <strong>Pendaftaran: </strong> 
                    <?php if($peserta_kelas['byr_daftar'] == $kelas['biaya_daftar']) { ?>
                        <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($peserta_kelas['byr_daftar']) ?>
                    <?php } ?>
                    <?php if($peserta_kelas['beasiswa_daftar'] == 1) { ?>
                        <span class="badge badge-success">Beasiswa</span>
                    <?php } ?>
                <br>
                <strong>SPP-1: </strong> 
                    <?php if($peserta_kelas['byr_spp1'] == $kelas['biaya_bulanan']) { ?>
                        <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($peserta_kelas['byr_spp1']) ?>
                    <?php } ?>
                    <?php if($peserta_kelas['beasiswa_spp1'] == 1) { ?>
                        <span class="badge badge-success">Beasiswa</span>
                    <?php } ?>
                <br>
                <strong>SPP-2: </strong> 
                    <?php if($peserta_kelas['byr_spp2'] == $kelas['biaya_bulanan']) { ?>
                        <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($peserta_kelas['byr_spp2']) ?>
                    <?php } ?>
                    <?php if($peserta_kelas['beasiswa_spp2'] == 1) { ?>
                        <span class="badge badge-success">Beasiswa</span>
                    <?php } ?>
                <br>
                <strong>SPP-3: </strong> 
                    <?php if($peserta_kelas['byr_spp3'] == $kelas['biaya_bulanan']) { ?>
                        <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($peserta_kelas['byr_spp3']) ?>
                    <?php } ?>
                    <?php if($peserta_kelas['beasiswa_spp3'] == 1) { ?>
                        <span class="badge badge-success">Beasiswa</span>
                    <?php } ?>
                <br>
                <strong>SPP-4: </strong> 
                    <?php if($peserta_kelas['byr_spp4'] == $kelas['biaya_bulanan']) { ?>
                        <i class=" fa fa-check" style="color:green"></i> Rp <?= rupiah($peserta_kelas['byr_spp4']) ?>
                    <?php } ?>
                    <?php if($peserta_kelas['beasiswa_spp4'] == 1) { ?>
                        <span class="badge badge-success">Beasiswa</span>
                    <?php } ?>
                <br>
                <strong>Modul: </strong> 
                    <?php if($peserta_kelas['byr_modul'] == $kelas['biaya_modul']) { ?>
                        Rp <?= rupiah($peserta_kelas['byr_modul']) ?>
                    <?php } ?>
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
                </div>
            </div>
        </div>
        <div class="col-sm-7 col-md-7">
            <div class="card shadow-lg bg-white rounded">
                <div class="card-body">
                    <div id="cart">
                        <label for="va_list">Metode Pembayaran<code>*</code></label>
                        
                        <select class="form-control btn-square mb-3" id="va_list">
                            <option value="" disabled selected>--Pilih--</option>
                            <?php foreach ($payment as $pay): ?>
                                <option value="<?= $pay['payment_code'] ?>"><?= $pay['payment_name'] ?> (+ Rp <?= rupiah($pay['payment_price']+(( $pay['payment_tax']/100)* $pay['payment_price'])) ?>)</option>
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

<?php if ($cek != 0) { ?>
    <div class="alert alert-secondary alert-dismissible fade show" role="alert"> <i class="mdi mdi-account-multiple-outline"></i>
        <strong>Bayar</strong> 
    </div>  
<?php } ?>

<script>
    /*--- Front-end Function---*/
    $(document).ready(function() {
        var services = [
            <?php if (!($peserta_kelas['byr_daftar'] == $kelas['biaya_daftar'] || $peserta_kelas['beasiswa_daftar'] == 1)): ?>
                { id: 5, name: "Pendaftaran", price: <?= $kelas['biaya_daftar']?>, fixed: true },
            <?php endif; ?>
            <?php if (!($peserta_kelas['byr_spp1'] == $kelas['biaya_bulanan'] || $peserta_kelas['beasiswa_spp1'] == 1)): ?>
                { id: 1, name: "SPP-1", price: <?= $kelas['biaya_bulanan']?>, fixed: true },
            <?php endif; ?>
            <?php if (!($peserta_kelas['byr_spp2'] == $kelas['biaya_bulanan'] || $peserta_kelas['beasiswa_spp2'] == 1)): ?>
                { id: 2, name: "SPP-2", price: <?= $kelas['biaya_bulanan']?>, fixed: true },
            <?php endif; ?>
            <?php if (!($peserta_kelas['byr_spp3'] == $kelas['biaya_bulanan'] || $peserta_kelas['beasiswa_spp3'] == 1)): ?>
                { id: 3, name: "SPP-3", price: <?= $kelas['biaya_bulanan']?>, fixed: true },
            <?php endif; ?>
            <?php if (!($peserta_kelas['byr_spp4'] == $kelas['biaya_bulanan'] || $peserta_kelas['beasiswa_spp4'] == 1)): ?>
                { id: 4, name: "SPP-4", price: <?= $kelas['biaya_bulanan']?>, fixed: true },
            <?php endif; ?>
            <?php if (!($peserta_kelas['byr_modul'] == $kelas['biaya_modul'])): ?>
                { id: 6, name: "Modul", price: <?= $kelas['biaya_modul']?>, fixed: true },
            <?php endif; ?>
            { id: 7, name: "Infaq", price: 0, fixed: false },
            { id: 8, name: "Pemby. Lain", price: 0, fixed: false },
        ];
        
        var cart = [
        ];
        var total = cart.reduce((sum, service) => sum + service.price, 0);

        var bankServices = [
            <?php foreach ($payment as $pay): ?>
                { bank: '<?= $pay['payment_code'] ?>', id: <?= $pay['payment_id'] ?>, price: <?= $pay['payment_price']+(( $pay['payment_tax']/100)* $pay['payment_price']) ?> },
            <?php endforeach; ?>
        ];

        function formatPrice(price) {
                return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

        function renderServices() {
            $('#services').empty();
            for(var i=0; i<services.length; i++) {
                var isInCart = cart.find(item => item.id === services[i].id);
                var buttonClass = isInCart ? 'btn-secondary' : 'btn-success';
                if(services[i].fixed) {
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
            for(var i=0; i<cart.length; i++) {
                var isBankService = cart[i].id >= 20 && cart[i].id <= 35;
                var isDaftar = cart[i].id == 5;
                var isSpp1   = cart[i].id == 1;
                $('#cart-items').append(`
                    <div class="list-group-item">
                        <span>${isBankService ? `Biaya Transaksi` : ''} ${!isBankService ? cart[i].name : ''} </span>  <br> 
                        <span>Rp ${formatPrice(cart[i].price)}</span>
                        ${!isBankService && !isSpp1 &&!isDaftar ? `<button class="remove-from-cart btn btn-sm btn-danger float-right" data-id="${cart[i].id}"><i class="fa fa-trash"></i></button>` : ''}
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
            
            if(serviceInCart) {
                total -= serviceInCart.price;  // Subtract the old price from the total
                serviceInCart.price = servicePrice;  // Update the price in the cart
            } else {
                cart.push({ id: serviceId, name: service.name, price: servicePrice });
            }
            
            total += servicePrice;  // Add the new price to the total

            renderServices();
            renderCart();
        });

        $('#cart').on('click', '.remove-from-cart', function() {
            var serviceId = $(this).data('id');
            var index = cart.findIndex(item => item.id === serviceId);
            if(index !== -1) {
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
                total -= serviceInCart.price;  // Subtract the old price from the total
                var index = cart.indexOf(serviceInCart);
                cart.splice(index, 1);  // Remove the bank service from the cart
            }

            if (!bankService) return;

            cart.push({ id: bankService.id, name: bankName.toUpperCase(), price: bankService.price });
            total += bankService.price;  // Add the new price to the total

            renderServices();
            renderCart();
        }

        $('#va_list').change(function() {
            if($(this).val() == 'manual_1' || $(this).val() == 'manual_2'){
                document.getElementById('detail_bank').style.display = "block";
                document.getElementById('pay-btn').style.display = "block";
                document.getElementById('pay-va-btn').style.display = "none";
                document.getElementById('pay-beasiswa-btn').style.display = "none";
            }
            else if($(this).val() == 'beasiswa'){
                document.getElementById('detail_bank').style.display = "none";
                document.getElementById('pay-btn').style.display = "none";
                document.getElementById('pay-va-btn').style.display = "none";
                document.getElementById('pay-beasiswa-btn').style.display = "block";
            } 
            else{
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
                        <label>Catatan</label>
                        <textarea id="pay_note" class="form-control mb-3"></textarea>
                        <label>Bukti Transfer<code>*</code></label>
                        <input type="file" id="pay_image" accept="image/png, image/jpeg" class="form-control mb-3">
                        <div id="image_preview_div"></div>`,
                showCancelButton: true,
                confirmButtonText: 'Upload',
                cancelButtonText: 'Batal',
                focusConfirm: false,
                allowOutsideClick: false,
                preConfirm: () => {
                    let note = document.getElementById('pay_note').value;
                    let image = document.getElementById('pay_image').files[0];
                    let formData = new FormData();
                    formData.append('note', note);
                    formData.append('image', image);
                    formData.append('cart', JSON.stringify(cart));
                    formData.append('total', total);
                    formData.append('peserta_kelas_id', <?= $peserta_kelas_id ?>);
                    formData.append('peserta_id', <?= $peserta_id ?>);
                    formData.append('kelas_id', <?= $kelas_id ?>);
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
                        window.location = '/bayar/daftar';
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
            let formData = new FormData();
            formData.append('cart', JSON.stringify(cart));
            formData.append('total', total);
            formData.append('peserta_kelas_id', <?= $peserta_kelas_id ?>);
            formData.append('peserta_id', <?= $peserta_id ?>);
            formData.append('kelas_id', <?= $kelas_id ?>);

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
                success: function(response){
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
                                <p>Total TF = Rp ${formatPrice(total)}</p>
                                Bank = ${bank} <br>
                                VA = ${va} <br>
                                <button id="copy" class="btn btn-success btn-sm"><i class="fas fa-copy"></i> Copy VA</button>
                            `,
                            confirmButtonText: 'Tutup',
                            allowOutsideClick: false,
                            didOpen: () => {
                                $('#copy').click(function(){
                                    let $temp = $("<input>");
                                    $("body").append($temp);
                                    $temp.val($('#va').text()).select();
                                    document.execCommand("copy");
                                    $temp.remove();

                                    // Update the text of the button
                                    $(this).html('<i class="fas fa-check"></i> VA dicopy');
                                });
                            },
                                didClose: () => {
                                window.location.href = "/daftar";
                            }
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
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
                        window.location = '/bayar/daftar';
                    });
                }
            });
        });

    });
</script>

<?= $this->endSection('isi') ?>