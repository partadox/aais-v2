<?= $this->extend('layout/main') ?>
<?= $this->section('nav') ?>
<nav class="navbar-custom">
    <ul class="navbar-right list-inline float-right mb-0">

        <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
            <div id="clock"></div>
        </li>
        
        <li class="dropdown notification-list list-inline-item d-none d-md-inline-block">
            <a href="javascript:void(0);"> <?= $user['nama'] ?> </a>
        </li>

        <?php if ($user['level'] == 1 || $user['level'] == 2 || $user['level'] == 3) { ?>
            <!-- Pusat -->
            <li class="dropdown notification-list list-inline-item">
                <div class="dropdown notification-list">
                    <a class="dropdown-toggle nav-link arrow-none noti-icon" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="color: green;">
                        <i class="mdi mdi-whatsapp mdi-24px noti-icon"></i> <span class="noti-icon-badge wag-icon text-secondary"><i class="mdi mdi-dots-horizontal mdi-18px"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <a class="dropdown-item">WA Pusat</a>
                        <a class="dropdown-item">Status <br> <p id="statusWa"></p></a>
                        <a class="dropdown-item">Cek Terakhir <br> <p id="datetimeWa"></p></a>
                        
                            <hr>
                            <div class="d-flex justify-content-around">
                                <!-- <?php if ($user['level'] == 1) { ?>
                                    <div id="divCreateWa" style="display: none;">
                                        <a href="https://wa-gateway.alhaqq.or.id/start-session?session=aaispusat&scan=true" target="_blank"><i class="mdi mdi-qrcode"></i>New</a>
                                    </div>
                                <?php } ?> -->
                                <div id="divCheckWa" style="display: block;">
                                    <a id="waCek" href="#" onclick="waCek(1);"><i class="mdi mdi-refresh"></i>Cek</a>
                                </div>
                                <!-- <?php if ($user['level'] == 1) { ?>
                                    <div id="divDelWa" style="display: block;">
                                        <a id="waDel" href="#" onclick="waDel(event);"><i class="mdi mdi-delete"></i>Del</a>
                                    </div>
                                <?php } ?> -->
                                <div id="divTesWa" style="display: block;">
                                    <a id="waTes" href="#" onclick="waTes(1);"><i class="mdi mdi-email"></i>Tes</a>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </li>
            <!-- Cabang -->
            <li class="dropdown notification-list list-inline-item">
                <div class="dropdown notification-list">
                    <a class="dropdown-toggle nav-link arrow-none noti-icon" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" style="color: orange;">
                        <i class="mdi mdi-whatsapp mdi-24px noti-icon"></i> <span class="noti-icon-badge wag-icon2 text-secondary"><i class="mdi mdi-dots-horizontal mdi-18px"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <a class="dropdown-item">WA Cabang</a>
                        <a class="dropdown-item">Status <br> <p id="statusWa2"></p></a>
                        <a class="dropdown-item">Cek Terakhir<br> <p id="datetimeWa2"></p></a>
                        
                            <hr>
                            <div class="d-flex justify-content-around">
                                <!-- <?php if ($user['level'] == 1) { ?>
                                    <div id="divCreateWa2" style="display: none;">
                                        <a href="https://wa-gateway.alhaqq.or.id/start-session?session=aaispusat&scan=true" target="_blank"><i class="mdi mdi-qrcode"></i>New</a>
                                    </div>
                                <?php } ?> -->
                                <div id="divCheckWa2" style="display: block;">
                                    <a id="waCek2" href="#" onclick="waCek(2);"><i class="mdi mdi-refresh"></i>Cek</a>
                                </div>
                                <!-- <?php if ($user['level'] == 1) { ?>
                                    <div id="divDelWa2" style="display: block;">
                                        <a id="waDel2" href="#" onclick="waDel2(event);"><i class="mdi mdi-delete"></i>Del</a>
                                    </div>
                                <?php } ?> -->
                                <div id="divTesWa2" style="display: block;">
                                    <a id="waTes2" href="#" onclick="waTes(2);"><i class="mdi mdi-email"></i>Tes</a>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </li>
        <?php } ?>

        <li class="dropdown notification-list list-inline-item">
            <div class="dropdown notification-list nav-pro-img">
                <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <!-- <img src="<?= base_url('public/img/user/' . $user['foto']) ?>" alt="user" class="rounded-circle"> -->
                    <i class="mdi mdi-account-circle mdi-36px" style="color: orange;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <a class="dropdown-item text-danger" href="#" id="logout"><i class="mdi mdi-power text-danger"></i> Keluar</a>
                </div>
            </div>
        </li>

    </ul>

    <ul class="list-inline menu-left mb-0">
        <li class="float-left">
            <button class="button-menu-mobile open-left waves-effect">
                <i class="mdi mdi-menu"></i>
            </button>
        </li>

    </ul>

</nav>
<?= $this->endSection('nav') ?>


<?= $this->section('menu') ?>
    <li class="menu-title">Dashboard</li>
    <li>
        <a href="<?= base_url('dashboard') ?>" class="waves-effect">
            <i class="icon-accelerator"></i> <span> Dashboard </span>
        </a>
    </li>

<!--  Peserta Menu Start -->
<?php if ($user['level'] == 4) { ?>
    <li class="menu-title">Pendaftaran Program Reguler</li>
    <li>
        <a href="<?= base_url('daftar') ?>" class="waves-effect">
            <i class="mdi mdi-application"></i> <span>Pilih Program</span>
        </a>
    </li>
    <!-- <li>
        <a href="<?= base_url('bayar/daftar') ?>" class="waves-effect">
            <i class="mdi mdi-cash-register"></i> <span> Pembayaran Daftar </span>
        </a>
    </li> -->

    <li class="menu-title">Akademik</li>
    <li>
        <a href="<?= base_url('peserta-kelas') ?>" class="waves-effect">
            <i class="mdi mdi-school"></i> <span> Kelas </span>
        </a>
    </li>
    <!-- <li>
        <a href="<?= base_url('peserta-sertifikat') ?>" class="waves-effect">
            <i class="mdi mdi-certificate"></i> <span> Sertifikat</span>
        </a>
    </li> -->
    <li>
        <a href="<?= base_url('bayar/riwayat') ?>" class="waves-effect">
            <i class="mdi mdi-history"></i> <span> Riwayat Pembayaran </span>
        </a>
    </li>

    <!-- <li class="menu-title">Pembayaran </li>
    <li>
        <a href="<?= base_url('bayar/spp') ?>" class="waves-effect">
            <i class="mdi mdi-cash"></i> <span> Bayar</span>
        </a>
    </li> -->
    

    <li class="menu-title">Akun</li>
    <li>
        <a href="<?= base_url('biodata-peserta') ?>" class="waves-effect">
            <i class="mdi mdi-account-badge"></i> <span> Biodata dan Akun </span>
        </a>
    </li>
<?php } ?>
<!--  Peserta Menu End -->

<!-- Admin Menu Start-->
<?php if ($user['level'] == 1 || $user['level'] == 2 || $user['level'] == 3) { ?>
    <li class="menu-title"> Pembayaran</li>
    
    <li>
        <a href="javascript:void(0);" class="waves-effect">
            <i class="mdi mdi-plus-circle-outline"></i>
            <span> Tambah Bayar <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
        </a>
        <ul class="submenu">
            <li><a href="<?= base_url('pembayaran/add-daftar') ?>">Pendaftaran</a></li>
            <li><a href="<?= base_url('pembayaran/add-spp') ?>">SPP</a></li>
            <li><a href="<?= base_url('pembayaran/add-lain') ?>">Infaq & Lain</a></li>
            <li><a href="<?= base_url('pembayaran/add-nonreg') ?>">Non-Reguler</a></li>
            <li><a href="<?= base_url('pembayaran/add-sertifikat') ?>">Sertifikat</a></li>
        </ul>
    </li>

    <li>
        <a href="<?= base_url('pembayaran/konfirmasi') ?>" class="waves-effect">
            <i class="mdi mdi-cash-usd"></i>
            <span> Konfirmasi Bayar</span>
        </a>
    </li>

    <!-- <li>
        <a href="<?= base_url('sertifikat/konfirmasi') ?>" class="waves-effect">
            <i class="mdi mdi-cash-usd"></i>
            <span> Konfirmasi Byr Sertifikat</span>
        </a>
    </li> -->

    <li>
        <a href="<?= base_url('pembayaran') ?>" class="waves-effect">
            <i class="mdi mdi-cash-register"></i>
            <span> Transaksi Bayar</span>
        </a>
    </li>

    <li>
        <a href="javascript:void(0);" class="waves-effect">
            <i class="mdi mdi-file-chart"></i>
            <span> Rekap Bayar<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
        </a>
        <ul class="submenu">
            <li><a href="<?= base_url('pembayaran/rekap-spp') ?>">SPP</a></li>
            <li><a href="<?= base_url('pembayaran/rekap-infaq') ?>">Infaq</a></li>
            <li><a href="<?= base_url('pembayaran/rekap-lain') ?>">Lain</a></li>
            <!-- <li><a href="<?= base_url('pembayaran/rekap-beasiswa') ?>">Beasiswa</a></li> -->
        </ul>
    </li>
    
    <li class="menu-title">Akademik</li>
        <?php if ($user['level'] == 1) { ?>
            <!-- <li class="menu-title">Program & Kelas</li>
            <li>
                <a href="<?= base_url('program-regular') ?>" class="waves-effect">
                    <i class="mdi mdi-application"></i>
                    <span> Program</span>
                </a>
            </li> -->
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="mdi mdi-application"></i>
                    <span> Program<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
                </a>
                <ul class="submenu">
                    <li><a href="<?= base_url('program-regular') ?>">Reguler</a></li>
                    <li><a href="<?= base_url('program-nonreg') ?>">Non-Reguler</a></li>
                </ul>
            </li>
        <?php } ?>
        <li>
            <a href="javascript:void(0);" class="waves-effect">
                <i class="mdi mdi-school"></i>
                <span> Kelas<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
            </a>
            <ul class="submenu">
                <li><a href="<?= base_url('kelas-regular') ?>">Reguler</a></li>
                <li><a href="<?= base_url('kelas-bina') ?>">Pembinaan</a></li>
                <li><a href="<?= base_url('kelas-nonreg') ?>">Non-Reguler</a></li>
            </ul>
        </li>
        <?php if ($user['level'] == 1) { ?>
            <li>
                <a href="<?= base_url('level') ?>" class="waves-effect">
                    <i class="mdi mdi-account-badge-horizontal-outline"></i><span> Level</span>
                </a>
            </li>
        <?php } ?>
        <li>
            <a href="<?= base_url('beasiswa') ?>" class="waves-effect">
                <i class="mdi mdi-sale"></i><span> Beasiswa</span>
            </a>
        </li>
        <?php if ($user['level'] == 1 || $user['level'] == 2) { ?>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="mdi mdi-file-check"></i>
                    <span> Absensi Reguler<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
                </a>
                <ul class="submenu">
                    <li><a href="<?= base_url('absensi-regular/peserta') ?>">Peserta</a></li>
                    <li><a href="<?= base_url('absensi-regular/pengajar') ?>">Pengajar</a></li>
                    <li><a href="<?= base_url('absensi-regular/penguji') ?>">Penguji</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="mdi mdi-file-check"></i>
                    <span> Absensi Pembinaan<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
                </a>
                <ul class="submenu">
                    <li><a href="<?= base_url('absensi-bina/peserta') ?>">Peserta</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="waves-effect">
                    <i class="mdi mdi-book"></i>
                    <span> Ujian<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
                </a>
                <ul class="submenu">
                    <li><a href="<?= base_url('ujian') ?>"> Standart</a></li>
                    <li><a href="<?= base_url('ujian-custom') ?>">Custom</a></li>
                </ul>
            </li>
            <!-- <li>
                <a href="base_url('ujian')" class="waves-effect">
                    <i class="mdi mdi-book"></i><span> Hasil Ujian Reg.</span>
                </a>
            </li> -->
        <?php } ?>
    <li>
        <a href="<?= base_url('sertifikat') ?>" class="waves-effect">
            <i class="mdi mdi-certificate"></i><span> Sertifikat</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url('pengumuman') ?>" class="waves-effect">
            <i class="mdi mdi-bullhorn"></i><span> Pengumuman</span>
        </a>
    </li>
    
    <li class="menu-title">User</li>
    <li>
        <a href="<?= base_url('peserta') ?>" class="waves-effect">
            <i class="mdi mdi-account"></i><span> Data Peserta </span>
        </a>
    </li>
    <li>
        <a href="<?= base_url('pengajar') ?>" class="waves-effect">
            <i class="mdi mdi-account-tie"></i><span> Data Pengajar </span>
        </a>
    </li>
    <!-- <li>
        <a href="<?= base_url('pic') ?>" class="waves-effect">
            <i class="mdi mdi-account-tie"></i><span> PIC Non-Reg</span>
        </a>
    </li> -->

    <li class="menu-title"> Pengaturan</li>
    <?php if ($user['level'] == 1) { ?>
        <li>
            <a href="<?= base_url('akun') ?>" class="waves-effect">
                <i class="mdi mdi-account-badge-alert-outline"></i><span> Akun Admin</span>
            </a>
        </li>
        <li>
            <a href="<?= base_url('kantor') ?>" class="waves-effect">
                <i class="mdi mdi-office-building"></i><span> Kantor & Cabang</span>
            </a>
        </li>
        <!-- <li>
            <a href="<?= base_url('wa-cabang') ?>" class="waves-effect">
                <i class="mdi mdi-whatsapp"></i><span> WA Gateway Cabang</span>
            </a>
        </li> -->
        <li>
            <a href="<?= base_url('payment-methode') ?>" class="waves-effect">
                <i class="mdi mdi-bank-transfer"></i><span> Metode Pembayaran</span>
            </a>
        </li>
    <?php } ?>
    <li>
        <a href="<?= base_url('log-admin') ?>" class="waves-effect">
            <i class="mdi mdi-history"></i><span> Log Admin </span>
        </a>
    </li>
    <li>
        <a href="<?= base_url('log-user') ?>" class="waves-effect">
            <i class="mdi mdi-history"></i><span> Log User </span>
        </a>
    </li>
<?php } ?>
<!-- Admin Menu End-->


<!--  Pengajar Menu Start -->
<?php if ($user['level'] == 5 || $user['level'] == 6) { ?>
    <li class="menu-title">Akademik</li>
    <!-- <li>
        <a href="<?= base_url('pengajar/kelas') ?>" class="waves-effect">
            <i class="mdi mdi-school"></i> <span> Kelas </span>
        </a>
    </li> -->
    <li>
        <a href="javascript:void(0);" class="waves-effect">
            <i class="mdi mdi-school"></i>
            <span> Kelas<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
        </a>
        <ul class="submenu">
            <li><a href="<?= base_url('pengajar/kelas') ?>"> Pengajar</a></li>
            <li><a href="<?= base_url('penguji/kelas') ?>"> Penguji</a></li>
        </ul>
    </li>
    <li class="menu-title">Akun</li>
    <li>
        <a href="<?= base_url('biodata-pengajar') ?>" class="waves-effect">
            <i class="mdi mdi-account-badge"></i> <span> Biodata dan Akun </span>
        </a>
    </li>
<?php } ?>
<!--  Pengajar Menu End -->



<li class="menu-title">Logout Akun</li>
    <li>
        <a class="waves-effect" href="#" id="logout"><i class="mdi mdi-power text-danger"></i> Keluar</a>
    </li>
<?= $this->endSection('menu') ?>