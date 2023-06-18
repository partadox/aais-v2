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

        <li class="dropdown notification-list list-inline-item">
            <div class="dropdown notification-list nav-pro-img">
                <a class="dropdown-toggle nav-link arrow-none nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="<?= base_url('public/img/user/' . $user['foto']) ?>" alt="user" class="rounded-circle">
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
    <li class="menu-title">Pendaftaran Program Regular</li>
    <li>
        <a href="<?= base_url('daftar') ?>" class="waves-effect">
            <i class="mdi mdi-application"></i> <span>Pilih Program</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url('bayar/daftar') ?>" class="waves-effect">
            <i class="mdi mdi-cash-register"></i> <span> Pembayaran Daftar </span>
        </a>
    </li>

    <li class="menu-title">Akademik</li>
    <li>
        <a href="<?= base_url('peserta-kelas') ?>" class="waves-effect">
            <i class="mdi mdi-application"></i> <span> Kelas </span>
        </a>
    </li>
    <!-- <li>
        <a href="<?= base_url('peserta-sertifikat') ?>" class="waves-effect">
            <i class="mdi mdi-certificate"></i> <span> Sertifikat</span>
        </a>
    </li> -->
    <li>
        <a href="<?= base_url('bayar/riwayat') ?>" class="waves-effect">
            <i class="mdi mdi-cash-multiple"></i> <span> Riwayat Pembayaran </span>
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
        <a href="<?= base_url('akun/biodata_peserta') ?>" class="waves-effect">
            <i class="mdi mdi-account-badge"></i> <span> Biodata dan Akun </span>
        </a>
    </li>
<?php } ?>
<!--  Peserta Menu End -->

<!-- 1 Super Admin Menu Start-->
<?php if ($user['level'] == 1) { ?>
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
        </ul>
    </li>

    <li>
        <a href="<?= base_url('pembayaran/konfirmasi') ?>" class="waves-effect">
            <i class="mdi mdi-cash-usd"></i>
            <span> Konfirmasi Bayar</span>
        </a>
    </li>

    <li>
        <a href="<?= base_url('sertifikat/konfirmasi') ?>" class="waves-effect">
            <i class="mdi mdi-cash-usd"></i>
            <span> Konfirmasi Byr Sertifikat</span>
        </a>
    </li>

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

    <li class="menu-title">Program & Kelas</li>
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
    <li>
        <a href="<?= base_url('level') ?>" class="waves-effect">
            <i class="mdi mdi-account-badge-horizontal-outline"></i><span> Level</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url('beasiswa') ?>" class="waves-effect">
            <i class="mdi mdi-sale"></i><span> Beasiswa</span>
        </a>
    </li>

    <li class="menu-title">Akademik</li>
    <li>
        <a href="javascript:void(0);" class="waves-effect">
            <i class="mdi mdi-file-check"></i>
            <span> Absensi Reguler<span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span></span>
        </a>
        <ul class="submenu">
            <li><a href="<?= base_url('absensi-regular/peserta') ?>">Peserta</a></li>
            <li><a href="<?= base_url('absensi-regular/pengajar') ?>">Pengajar</a></li>
        </ul>
    </li>
    <li>
        <a href="<?= base_url('absensi-bina') ?>" class="waves-effect">
            <i class="mdi mdi-file-check"></i><span> Absensi Pembinaan</span>
        </a>
    </li>
    <li>
        <a href="<?= base_url('ujian') ?>" class="waves-effect">
            <i class="mdi mdi-book"></i><span> Hasil Ujian Reg.</span>
        </a>
    </li>
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

    <li class="menu-title">Peserta & Pengajar</li>
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

    <li class="menu-title"> Al-Haqq</li>
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
    <li>
        <a href="<?= base_url('payment-methode') ?>" class="waves-effect">
            <i class="mdi mdi-bank-transfer"></i><span> Metode Pembayaran</span>
        </a>
    </li>
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
<!-- 1 Super Admin Menu End-->

<!-- 2 Admin Pusat Menu Start-->
<?php if ($user['level'] == 2) { ?>
    <li class="menu-title"> Pembayaran</li>
    <li>
        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-plus-circle-outline"></i> <span> Tambah Bayar <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
        <ul class="submenu">
            <li><a href="<?= base_url('pembayaran/tambah_bayar_daftar') ?>">Pendaftaran</a></li>
            <li><a href="<?= base_url('pembayaran/tambah_bayar_spp') ?>">SPP</a></li>
            <li><a href="<?= base_url('pembayaran/tambah_bayar_lain') ?>">Infaq & Lain</a></li>
        </ul>
        <a href="<?= base_url('pembayaran/konfirmasi') ?>" class="waves-effect">
            <i class="mdi mdi-cash-usd"></i> <span> Konfirmasi Pembayaran</span>
        </a>
        <a href="<?= base_url('pembayaran/') ?>" class="waves-effect">
            <i class="mdi mdi-cash-register"></i> <span> Semua Pembayaran</span>
        </a>
        <a href="<?= base_url('pembayaran/admin_rekap_bayar') ?>" class="waves-effect">
            <i class="mdi mdi-cash-multiple"></i> <span> Rekap Pembayaran SPP</span>
        </a>
        <a href="<?= base_url('pembayaran/index_bayar_infaq') ?>" class="waves-effect">
            <i class="mdi mdi-cash-multiple"></i> <span>Rekap Infaq</span>
        </a>
        <a href="<?= base_url('pembayaran/index_bayar_lain') ?>" class="waves-effect">
            <i class="mdi mdi-cash-multiple"></i> <span>Rekap Pemby. Lain</span>
        </a>
    </li>
    <li class="menu-title">Program & Kelas</li>
    <li>
        <a href="<?= base_url('program/kelas') ?>" class="waves-effect">
            <i class="mdi mdi-school"></i> <span> Kelas </span>
        </a>
    </li>
    <li class="menu-title">Akademik</li>
    <li>
        <a href="<?= base_url('akademik/admin_rekap_absen_peserta') ?>" class="waves-effect">
            <i class="mdi mdi-check-bold"></i> <span> Absensi Peserta</span>
        </a>
        <a href="<?= base_url('akademik/admin_rekap_absen_pengajar') ?>" class="waves-effect">
            <i class="mdi mdi-check-box-outline"></i> <span> Absensi Pengajar</span>
        </a>
        <a href="<?= base_url('akademik/admin_rekap_ujian') ?>" class="waves-effect">
            <i class="mdi mdi-book"></i> <span> Hasil Ujian </span>
        </a>
        <a href="<?= base_url('akademik/admin_sertifikat') ?>" class="waves-effect">
            <i class="mdi mdi-certificate"></i> <span> Sertifikat </span>
        </a>
    </li>
    <li class="menu-title">Peserta & Pengajar</li>
    <li>
        <a href="<?= base_url('peserta') ?>" class="waves-effect">
            <i class="mdi mdi-account"></i> <span> Data Peserta </span>
        </a>
        <!-- <a href="<?= base_url('akun/user_peserta') ?>" class="waves-effect">
            <i class="mdi mdi-account-badge"></i> <span> Akun Peserta</span>
        </a> -->
        <a href="<?= base_url('pengajar') ?>" class="waves-effect">
            <i class="mdi mdi-account-tie"></i> <span> Data Pengajar </span>
        </a>
        <!-- <a href="<?= base_url('akun/user_pengajar') ?>" class="waves-effect">
            <i class="mdi mdi-account-tie"></i> <span> Akun Pengajar</span>
        </a> -->
    </li>
    <li class="menu-title"> Al-Haqq</li>
    <li>
        <a href="<?= base_url('log-admin') ?>" class="waves-effect">
            <i class="mdi mdi-history"></i> <span> Log Admin </span>
        </a>
        <a href="<?= base_url('log-user') ?>" class="waves-effect">
            <i class="mdi mdi-history"></i> <span> Log User </span>
        </a>
    </li>
<?php } ?>
<!-- 2 Admin Pusat Menu End-->

<!-- 3 Admin Pusat TU Menu Start-->
<?php if ($user['level'] == 3) { ?>
    <li class="menu-title"> Pembayaran</li>
    <li>
        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-plus-circle-outline"></i> <span> Tambah Bayar <span class="float-right menu-arrow"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
        <ul class="submenu">
            <li><a href="<?= base_url('pembayaran/tambah_bayar_daftar') ?>">Pendaftaran</a></li>
            <li><a href="<?= base_url('pembayaran/tambah_bayar_spp') ?>">SPP</a></li>
            <li><a href="<?= base_url('pembayaran/tambah_bayar_lain') ?>">Infaq & Lain</a></li>
        </ul>
        <a href="<?= base_url('pembayaran/konfirmasi') ?>" class="waves-effect">
            <i class="mdi mdi-cash-usd"></i> <span> Konfirmasi Pembayaran</span>
        </a>
        <a href="<?= base_url('pembayaran/') ?>" class="waves-effect">
            <i class="mdi mdi-cash-register"></i> <span> Semua Pembayaran</span>
        </a>
        <a href="<?= base_url('pembayaran/admin_rekap_bayar') ?>" class="waves-effect">
            <i class="mdi mdi-cash-multiple"></i> <span> Rekap Pembayaran SPP</span>
        </a>
        <a href="<?= base_url('pembayaran/index_bayar_infaq') ?>" class="waves-effect">
            <i class="mdi mdi-cash-multiple"></i> <span>Rekap Infaq</span>
        </a>
        <a href="<?= base_url('pembayaran/index_bayar_lain') ?>" class="waves-effect">
            <i class="mdi mdi-cash-multiple"></i> <span>Rekap Pemby. Lain</span>
        </a>
    </li>
    <li class="menu-title">Program & Kelas</li>
    <li>
        <a href="<?= base_url('program/kelas') ?>" class="waves-effect">
            <i class="mdi mdi-school"></i> <span> Kelas </span>
        </a>
    </li>
    <li class="menu-title">Akademik</li>
    <li>
        <a href="<?= base_url('akademik/admin_sertifikat') ?>" class="waves-effect">
            <i class="mdi mdi-certificate"></i> <span> Sertifikat </span>
        </a>
    </li>
    <li class="menu-title">Peserta & Pengajar</li>
    <li>
        <a href="<?= base_url('peserta') ?>" class="waves-effect">
            <i class="mdi mdi-account"></i> <span> Data Peserta </span>
        </a>
        <!-- <a href="<?= base_url('akun/user_peserta') ?>" class="waves-effect">
            <i class="mdi mdi-account-badge"></i> <span> Akun Peserta</span>
        </a> -->
        <a href="<?= base_url('pengajar') ?>" class="waves-effect">
            <i class="mdi mdi-account-tie"></i> <span> Data Pengajar </span>
        </a>
        <!-- <a href="<?= base_url('akun/user_pengajar') ?>" class="waves-effect">
            <i class="mdi mdi-account-tie"></i> <span> Akun Pengajar</span>
        </a> -->
    </li>
    <li class="menu-title"> Al-Haqq</li>
    <li>
        <a href="<?= base_url('log-admin') ?>" class="waves-effect">
            <i class="mdi mdi-history"></i> <span> Log Admin </span>
        </a>
        <a href="<?= base_url('log-user') ?>" class="waves-effect">
            <i class="mdi mdi-history"></i> <span> Log User </span>
        </a>
    </li>
<?php } ?>
<!-- 3 Admin Pusat TU Menu End-->

<!--  Pengajar Menu Start -->
<?php if ($user['level'] == 5 || $user['level'] == 6) { ?>
    <li class="menu-title">Akademik</li>
    <li>
        <a href="<?= base_url('pengajar/kelas') ?>" class="waves-effect">
            <i class="mdi mdi-school"></i> <span> Kelas </span>
        </a>
    </li>
    <li class="menu-title">Akun</li>
    <li>
        <a href="<?= base_url('pengajar/biodata') ?>" class="waves-effect">
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