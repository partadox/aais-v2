<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function ($message = null) {

    $data = [
        'title' => '404 Page not found',
        'message' => $message,
        'code'  => '404',
    ];
    echo view('errors/error404', $data);
});
$routes->setAutoRoute(false);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/*--- Auth ---*/
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('auth/dologin', 'Auth::dologin');
$routes->post('auth/logout', 'Auth::logout');

/*--- Dashboard ---*/
$routes->get('dashboard', 'Dashboard::index', ["filter" => "authweb:1-2-3-4-5-6"]);

/*--- Dashboard ---*/
$routes->get('terms-of-service', 'Tos::tos');
$routes->get('privacy-policy', 'Tos::privacy');

/*
 * --------------------------------------------------------------------
 * ADMIN
 * --------------------------------------------------------------------
 */

/*--- Peserta ---*/
$routes->get('peserta', 'Admin\Peserta::index', ["filter" => "authweb:1-2-3-7"]);
$routes->get('peserta/list', 'Admin\Peserta::list', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/input', 'Admin\Peserta::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/detail', 'Admin\Peserta::detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/edit', 'Admin\Peserta::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/edit_akun', 'Admin\Peserta::edit_akun', ["filter" => "authweb:1-2"]);

$routes->post('peserta/getdata', 'Admin\Peserta::getdata', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/create', 'Admin\Peserta::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/update', 'Admin\Peserta::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/update_akun', 'Admin\Peserta::update_akun', ["filter" => "authweb:1-2"]);
$routes->post('peserta/delete', 'Admin\Peserta::delete', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/deleteselect', 'Admin\Peserta::deleteselect', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/import', 'Admin\Peserta::import', ["filter" => "authweb:1-2-3-7"]);
$routes->get('peserta/export', 'Admin\Peserta::export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/edit-multiple', 'Admin\Peserta::edit_multiple', ["filter" => "authweb:1-2-3-7"]);

/*--- Pengajar ---*/
$routes->get('pengajar', 'Admin\Pengajar::index', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pengajar/list', 'Admin\Pengajar::list', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/input', 'Admin\Pengajar::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/detail', 'Admin\Pengajar::detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/edit', 'Admin\Pengajar::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/edit_akun', 'Admin\Pengajar::edit_akun', ["filter" => "authweb:1-2-3-7"]);

$routes->post('pengajar/getdata', 'Admin\Pengajar::getdata', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/create', 'Admin\Pengajar::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/update', 'Admin\Pengajar::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/update_akun', 'Admin\Pengajar::update_akun', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/delete', 'Admin\Pengajar::delete', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/deleteselect', 'Admin\Pengajar::deleteselect', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/import', 'Admin\Pengajar::import', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pengajar/export', 'Admin\Pengajar::export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/edit-multiple', 'Admin\Pengajar::edit_multiple', ["filter" => "authweb:1-2-3-7"]);

/*--- Peserta Transfer ---*/
$routes->get('terima-peserta', 'Admin\TerimaPeserta::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('terima-peserta/getdataAll', 'Admin\TerimaPeserta::getdataAll', ["filter" => "authweb:1-2-3-7"]);
$routes->post('terima-peserta/modal', 'Admin\TerimaPeserta::modal', ["filter" => "authweb:1-2-3-7"]);
$routes->post('terima-peserta/create', 'Admin\TerimaPeserta::create', ["filter" => "authweb:1-2-3-7"]);

/*--- Akun ---*/
$routes->get('akun', 'Admin\Akun::index', ["filter" => "authweb:1"]);
$routes->post('akun/input', 'Admin\Akun::input', ["filter" => "authweb:1"]);
$routes->post('akun/edit', 'Admin\Akun::edit', ["filter" => "authweb:1"]);

$routes->post('akun/create', 'Admin\Akun::create', ["filter" => "authweb:1"]);
$routes->post('akun/update', 'Admin\Akun::update', ["filter" => "authweb:1"]);
$routes->post('akun/delete', 'Admin\Akun::delete', ["filter" => "authweb:1"]);

/*--- Kantor ---*/
$routes->get('kantor', 'Admin\Kantor::index', ["filter" => "authweb:1"]);
$routes->post('kantor/input', 'Admin\Kantor::input', ["filter" => "authweb:1"]);
$routes->post('kantor/edit', 'Admin\Kantor::edit', ["filter" => "authweb:1"]);

$routes->post('kantor/create', 'Admin\Kantor::create', ["filter" => "authweb:1"]);
$routes->post('kantor/update', 'Admin\Kantor::update', ["filter" => "authweb:1"]);

/*--- WA Gateway ---*/
$routes->get('wa-gateway', 'Admin\WA::index', ["filter" => "authweb:1-2-3"]);
$routes->get('wa-status', 'Admin\WA::wa_status', ["filter" => "authweb:1-2-3"]);
$routes->post('wa-check', 'Admin\WA::wa_check', ["filter" => "authweb:1-2-3"]);
$routes->post('wa-test', 'Admin\WA::wa_test', ["filter" => "authweb:1-2-3"]);

$routes->post('wa-input-footer', 'Admin\WA::wa_input_footer', ["filter" => "authweb:1-2-3"]);
$routes->post('wa-update-footer', 'Admin\WA::wa_update_footer', ["filter" => "authweb:1-2-3"]);

$routes->post('wa-input-action', 'Admin\WA::wa_input_action', ["filter" => "authweb:1-2-3"]);
$routes->post('wa-update-action', 'Admin\WA::wa_update_action', ["filter" => "authweb:1-2-3"]);

/*--- Payment ---*/
$routes->get('payment-methode', 'Admin\Payment::index', ["filter" => "authweb:1"]);
$routes->post('payment-methode/edit', 'Admin\Payment::edit', ["filter" => "authweb:1"]);

$routes->post('payment-methode/update', 'Admin\Payment::update', ["filter" => "authweb:1"]);

/*--- Beasiswa ---*/
$routes->get('beasiswa', 'Admin\Beasiswa::index', ["filter" => "authweb:1-2-3-7"]);
$routes->get('beasiswa/list', 'Admin\Beasiswa::list', ["filter" => "authweb:1-2-3-7"]);
$routes->post('beasiswa/input', 'Admin\Beasiswa::input', ["filter" => "authweb:1-2-3-7"]);

$routes->post('beasiswa/getdata', 'Admin\Beasiswa::getdata', ["filter" => "authweb:1-2-3-7"]);
$routes->post('beasiswa/create', 'Admin\Beasiswa::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('beasiswa/delete', 'Admin\Beasiswa::delete', ["filter" => "authweb:1-2-3-7"]);
$routes->post('beasiswa/deleteselect', 'Admin\Beasiswa::deleteselect', ["filter" => "authweb:1-2-3-7"]);
$routes->post('beasiswa/import', 'Admin\Beasiswa::import', ["filter" => "authweb:1-2-3-7"]);
$routes->get('beasiswa/export', 'Admin\Beasiswa::export', ["filter" => "authweb:1-2-3-7"]);

/*--- Program Regular---*/
$routes->get('program-regular', 'Admin\ProgramReg::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-regular/input', 'Admin\ProgramReg::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-regular/edit', 'Admin\ProgramReg::edit', ["filter" => "authweb:1-2-3-7"]);

$routes->post('program-regular/create', 'Admin\ProgramReg::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-regular/update', 'Admin\ProgramReg::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-regular/update-sertifikat', 'Admin\ProgramReg::update_sertifikat', ["filter" => "authweb:1-2-3-7"]);

/*--- Program Regular Atur Fitur Ujian---*/
$routes->get('program-regular-ujian-setting', 'Admin\ProgramReg::ujian_setting', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-regular-ujian-setting/save', 'Admin\ProgramReg::save_ujian_setting', ["filter" => "authweb:1-2-3-7"]);

/*--- Program Non-Regular---*/
$routes->get('program-nonreg', 'Admin\ProgramNonReg::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-nonreg/input', 'Admin\ProgramNonReg::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-nonreg/edit', 'Admin\ProgramNonReg::edit', ["filter" => "authweb:1-2-3-7"]);

$routes->post('program-nonreg/create', 'Admin\ProgramNonReg::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('program-nonreg/update', 'Admin\ProgramNonReg::update', ["filter" => "authweb:1-2-3-7"]);

/*--- Kelas Regular---*/
$routes->get('kelas-regular', 'Admin\KelasReg::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/input', 'Admin\KelasReg::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/edit', 'Admin\KelasReg::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->get('kelas-regular/detail', 'Admin\KelasReg::detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/input-setting', 'Admin\KelasReg::input_setting', ["filter" => "authweb:1-2"]);
$routes->post('kelas-regular/input-move', 'Admin\KelasReg::input_move', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/atur_absensi', 'Admin\KelasReg::atur_absensi', ["filter" => "authweb:1-2-3-7"]);

$routes->post('kelas-regular/create', 'Admin\KelasReg::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/update', 'Admin\KelasReg::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/save-setting', 'Admin\KelasReg::save_setting', ["filter" => "authweb:1-2"]);
$routes->get('kelas-regular/export', 'Admin\KelasReg::export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/move', 'Admin\KelasReg::move', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/delete-peserta', 'Admin\KelasReg::delete_peserta', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/update-atur-absensi', 'Admin\KelasReg::update_atur_absensi', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/update-atur-absensi-config', 'Admin\KelasReg::update_atur_absensi_config', ["filter" => "authweb:1-2-3-7"]);

/*--- Kelas Non-Regular---*/
$routes->get('kelas-nonreg', 'Admin\KelasNonReg::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/input', 'Admin\KelasNonReg::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/edit', 'Admin\KelasNonReg::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/edit-level', 'Admin\KelasNonReg::edit_level', ["filter" => "authweb:1-2-3-7"]);
$routes->get('kelas-nonreg/detail', 'Admin\KelasNonReg::detail', ["filter" => "authweb:1-2-3-7"]);

$routes->post('kelas-nonreg/create', 'Admin\KelasNonReg::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/update', 'Admin\KelasNonReg::update', ["filter" => "authweb:1-2-3-7"]);
$routes->get('kelas-nonreg/export', 'Admin\KelasNonReg::export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/save-peserta', 'Admin\KelasNonReg::save_peserta', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/add-kuota', 'Admin\KelasNonReg::add_kuota', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/delete-peserta', 'Admin\KelasNonReg::delete_peserta', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/update-level', 'Admin\KelasNonReg::update_level', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/delete-level', 'Admin\KelasNonReg::delete_level', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/delete-pengajar', 'Admin\KelasNonReg::delete_pengajar', ["filter" => "authweb:1-2-3-7"]);

/*--- Kelas Pembinaan---*/
$routes->get('kelas-bina', 'Admin\KelasBina::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-bina/input', 'Admin\KelasBina::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-bina/edit', 'Admin\KelasBina::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->get('kelas-bina/detail', 'Admin\KelasBina::detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-bina/detail/modal', 'Admin\KelasBina::detail_modal', ["filter" => "authweb:1-2-3-7"]);

$routes->post('kelas-bina/create', 'Admin\KelasBina::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-bina/update', 'Admin\KelasBina::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-bina/detail/update', 'Admin\KelasBina::update_detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-bina/delete', 'Admin\KelasBina::delete', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-bina/duplicate', 'Admin\KelasBina::duplicate', ["filter" => "authweb:1-2-3-7"]);

/*--- Level---*/
$routes->get('level', 'Admin\Level::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('level/input', 'Admin\Level::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('level/edit', 'Admin\Level::edit', ["filter" => "authweb:1-2-3-7"]);

$routes->post('level/create', 'Admin\Level::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('level/update', 'Admin\Level::update', ["filter" => "authweb:1-2-3-7"]);

/*--- Pembayaran ---*/
//Transaksi Bayar
$routes->get('pembayaran', 'Admin\Pembayaran::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/list', 'Admin\Pembayaran::list', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/edit', 'Admin\Pembayaran::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/edit-bukti', 'Admin\Pembayaran::edit_bukti', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/flip-bill', 'Admin\Pembayaran::flip_bill', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/filter', 'Admin\Pembayaran::pembayaran_filter', ["filter" => "authweb:1-2-3-7"]);

$routes->post('pembayaran/getdata', 'Admin\Pembayaran::getdata', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/update', 'Admin\Pembayaran::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/update-bukti', 'Admin\Pembayaran::update_bukti', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/delete', 'Admin\Pembayaran::delete', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/export', 'Admin\Pembayaran::export', ["filter" => "authweb:1-2-3-7"]);

$routes->get('pembayaran-sertifikat', 'Admin\Pembayaran::index_pembayaran_sertifikat', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran-nonreg', 'Admin\Pembayaran::index_pembayaran_nonreg', ["filter" => "authweb:1-2-3-7"]);

//Konfirmasi Bayar
$routes->get('pembayaran/konfirmasi', 'Admin\Pembayaran::index_konfirmasi', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/input-konfirmasi', 'Admin\Pembayaran::input_konfirmasi', ["filter" => "authweb:1-2-3-7"]);

$routes->post('pembayaran/save-konfirmasi', 'Admin\Pembayaran::save_konfirmasi', ["filter" => "authweb:1-2-3-7"]);

$routes->get('pembayaran/konfirmasi-sertifikat', 'Admin\Pembayaran::index_konfirmasi_sertifikat', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/input-konfirmasi-sertifikat', 'Admin\Pembayaran::input_konfirmasi_sertifikat', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/save-konfirmasi-sertifikat', 'Admin\Pembayaran::save_konfirmasi_sertifikat', ["filter" => "authweb:1-2-3-7"]);

//Tambah Bayar
$routes->get('pembayaran/add-daftar', 'Admin\Pembayaran::add_daftar', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/add-spp', 'Admin\Pembayaran::add_spp', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/add-lain', 'Admin\Pembayaran::add_lain', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/add-nonreg', 'Admin\Pembayaran::add_nonreg', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/add-sertifikat', 'Admin\Pembayaran::add_sertifikat', ["filter" => "authweb:1-2-3-7"]);

$routes->post('pembayaran/save-daftar', 'Admin\Pembayaran::save_daftar', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/save-spp', 'Admin\Pembayaran::save_spp', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/save-lain', 'Admin\Pembayaran::save_lain', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/save-nonreg', 'Admin\Pembayaran::save_nonreg', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/save-sertifikat', 'Admin\Pembayaran::save_sertifikat', ["filter" => "authweb:1-2-3-7"]);

//Rekap
$routes->get('pembayaran/rekap-spp', 'Admin\Pembayaran::rekap_spp', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/rekap-spp-detail', 'Admin\Pembayaran::rekap_spp_detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/rekap-spp-edit', 'Admin\Pembayaran::rekap_spp_edit', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/rekap-infaq', 'Admin\Pembayaran::rekap_infaq', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/rekap-lain', 'Admin\Pembayaran::rekap_lain', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/rekap-lain-edit', 'Admin\Pembayaran::rekap_lain_edit', ["filter" => "authweb:1-2-3-7"]);
// $routes->get('pembayaran/rekap-beasiswa', 'Admin\Pembayaran::rekap_beasiswa', ["filter" => "authweb:1-2-3-7"]);

$routes->post('pembayaran/rekap-spp-update', 'Admin\Pembayaran::rekap_spp_update', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/rekap-spp-export', 'Admin\Pembayaran::rekap_spp_export', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/rekap-infaq-export', 'Admin\Pembayaran::rekap_infaq_export', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/rekap-lain-export', 'Admin\Pembayaran::rekap_lain_export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/rekap-lain-update', 'Admin\Pembayaran::rekap_lain_update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pembayaran/rekap-lain-delete', 'Admin\Pembayaran::rekap_lain_delete', ["filter" => "authweb:1-2-3-7"]);

$routes->post('pembayaran/rekap-spp-cek', 'Admin\Pembayaran::rekap_spp_cek', ["filter" => "authweb:1"]);

$routes->get('pembayaran/rekap-nonreg', 'Admin\Pembayaran::rekap_nonreg', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pembayaran/rekap-nonreg-export', 'Admin\Pembayaran::rekap_nonreg_export', ["filter" => "authweb:1-2-3-7"]);

//Absensi
$routes->get('absensi-regular/peserta', 'Admin\Absensi::regular_peserta', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-regular/pengajar', 'Admin\Absensi::regular_pengajar', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-regular/penguji', 'Admin\Absensi::regular_penguji', ["filter" => "authweb:1-2-3-7"]);
$routes->post('absensi-regular/pengajar-note', 'Admin\Absensi::regular_pengajar_note', ["filter" => "authweb:1-2-3-7"]);

$routes->get('absensi-regular/peserta-export', 'Admin\Absensi::regular_peserta_export', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-regular/pengajar-export', 'Admin\Absensi::regular_pengajar_export', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-regular/penguji-export', 'Admin\Absensi::regular_penguji_export', ["filter" => "authweb:1-2-3-7"]);

$routes->get('absensi-bina/peserta', 'Admin\Absensi::bina_peserta', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-bina/peserta-export', 'Admin\Absensi::bina_peserta_export', ["filter" => "authweb:1-2-3-7"]);

//Absensi Non Regular
$routes->get('absensi-nonreg/peserta', 'Admin\Absensi::nonreg_peserta', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-nonreg/peserta-export', 'Admin\Absensi::nonreg_peserta_export', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-nonreg/pengajar', 'Admin\Absensi::nonreg_pengajar', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-nonreg/pengajar-export', 'Admin\Absensi::nonreg_pengajar_export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('absensi-nonreg/pengajar-note', 'Admin\Absensi::nonreg_pengajar_note', ["filter" => "authweb:1-2-3-7"]);
$routes->get('absensi-nonreg/absen', 'Admin\Absensi::nonreg_absensi', ["filter" => "authweb:1-2-3-7"]);
$routes->post('absensi-nonreg/input', 'Admin\Absensi::nonreg_input_absensi', ["filter" => "authweb:1-2-3-7"]);
$routes->post('absensi-nonreg/save', 'Admin\Absensi::nonreg_save_absensi', ["filter" => "authweb:1-2-3-7"]);

//Ujian
$routes->get('ujian', 'Admin\Ujian::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('ujian/edit', 'Admin\Ujian::edit', ["filter" => "authweb:1-2-3-7-5-6"]);

$routes->post('ujian/update', 'Admin\Ujian::update', ["filter" => "authweb:1-2-3-7-5-6"]);
$routes->post('ujian/import', 'Admin\Ujian::import', ["filter" => "authweb:1-2-3-7"]);
$routes->get('ujian/export', 'Admin\Ujian::export', ["filter" => "authweb:1-2-3-7"]);

//Ujian Custom
$routes->get('ujian-custom', 'Admin\UjianCustom::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('ujian-custom/filter', 'Admin\UjianCustom::filter', ["filter" => "authweb:1-2-3-7"]);
$routes->post('ujian-custom/list', 'Admin\UjianCustom::list', ["filter" => "authweb:1-2-3-7"]);
$routes->post('ujian-custom/fetch', 'Admin\UjianCustom::fetch', ["filter" => "authweb:1-2-3-7"]);

$routes->post('ujian-custom/modal', 'Admin\UjianCustom::modal', ["filter" => "authweb:1-2-3-7-5-6"]);
$routes->post('ujian-custom/modal-import', 'Admin\UjianCustom::modal_import', ["filter" => "authweb:1-2-3-7"]);
$routes->post('ujian-custom/update', 'Admin\UjianCustom::update', ["filter" => "authweb:1-2-3-7-5-6"]);
$routes->post('ujian-custom/import', 'Admin\UjianCustom::import', ["filter" => "authweb:1-2-3-7"]);
$routes->post('ujian-custom/export', 'Admin\UjianCustom::export', ["filter" => "authweb:1-2-3-7"]);

//Sertifikat
$routes->get('sertifikat', 'Admin\Sertifikat::index', ["filter" => "authweb:1-2-3-7"]);
$routes->get('sertifikat/konfirmasi', 'Admin\Sertifikat::konfirmasi', ["filter" => "authweb:1-2-3-7"]);
$routes->post('sertifikat/edit', 'Admin\Sertifikat::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->post('sertifikat/input-atur', 'Admin\Sertifikat::input_atur', ["filter" => "authweb:1-2-3-7"]);
$routes->post('sertifikat/input-konfirmasi', 'Admin\Sertifikat::input_konfirmasi', ["filter" => "authweb:1-2-3-7"]);
$routes->get('sertifikat/detail', 'Admin\Sertifikat::detail', ["filter" => "authweb:1-2-3-7"]);

$routes->post('sertifikat/save-atur', 'Admin\Sertifikat::save_atur', ["filter" => "authweb:1-2-3-7"]);
$routes->post('sertifikat/save-konfirmasi', 'Admin\Sertifikat::save_konfirmasi', ["filter" => "authweb:1-2-3-7"]);
$routes->post('sertifikat/update', 'Admin\Sertifikat::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('sertifikat/import', 'Admin\Sertifikat::import', ["filter" => "authweb:1-2-3-7"]);
$routes->get('sertifikat/export', 'Admin\Sertifikat::export', ["filter" => "authweb:1-2-3-7"]);

/*--- Pengumuman ---*/
$routes->get('pengumuman', 'Admin\Pengumuman::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengumuman/input', 'Admin\Pengumuman::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengumuman/edit', 'Admin\Pengumuman::edit', ["filter" => "authweb:1-2-3-7"]);

$routes->post('pengumuman/create', 'Admin\Pengumuman::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengumuman/update', 'Admin\Pengumuman::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengumuman/delete', 'Admin\Pengumuman::delete', ["filter" => "authweb:1-2-3-7"]);

/*--- Log ---*/
$routes->get('log-admin', 'Admin\Log::admin', ["filter" => "authweb:1-2-3-7"]);
$routes->get('log-user', 'Admin\Log::user', ["filter" => "authweb:1-2-3-7"]);

/*
 * --------------------------------------------------------------------
 * PESERTA
 * --------------------------------------------------------------------
 */
/*--- Pendaftaran Program---*/
$routes->get('daftar', 'Peserta\Daftar::index', ["filter" => "authweb:4"]);
$routes->get('daftar/tes', 'Peserta\Daftar::tes', ["filter" => "authweb:4"]);

$routes->post('daftar/level-update', 'Peserta\Daftar::level_update', ["filter" => "authweb:4"]);
$routes->post('daftar/save', 'Peserta\Daftar::save', ["filter" => "authweb:4"]);

/*--- Bayar Daftar---*/
$routes->get('bayar/daftar', 'Peserta\Bayar::index', ["filter" => "authweb:4"]);
$routes->get('bayar/riwayat', 'Peserta\Bayar::riwayat', ["filter" => "authweb:4"]);

$routes->post('bayar/save-manual', 'Peserta\Bayar::save_manual', ["filter" => "authweb:4"]);
$routes->post('bayar/save-beasiswa', 'Peserta\Bayar::save_beasiswa', ["filter" => "authweb:4"]);
$routes->post('bayar/generate-flip', 'Peserta\Bayar::generate_flip', ["filter" => "authweb:4"]);
$routes->post('bayar/cancel', 'Peserta\Bayar::cancel', ["filter" => "authweb:4"]);

/*--- Bayar SPP---*/
$routes->get('bayar/spp', 'Peserta\BayarSPP::index', ["filter" => "authweb:4"]);

$routes->post('bayar-spp/save-manual', 'Peserta\BayarSPP::save_manual', ["filter" => "authweb:4"]);
$routes->post('bayar-spp/save-beasiswa', 'Peserta\BayarSPP::save_beasiswa', ["filter" => "authweb:4"]);
$routes->post('bayar-spp/generate-flip', 'Peserta\BayarSPP::generate_flip', ["filter" => "authweb:4"]);

/*--- API Flip Callback---*/
$routes->post('bayar/77callback77', 'API\Flip::callback');

/*--- Kelas---*/
$routes->get('peserta-kelas', 'Peserta\Kelas::index', ["filter" => "authweb:4"]);

/*--- Absensi Peserta---*/
$routes->post('peserta/absensi', 'Peserta\Absensi::index', ["filter" => "authweb:4"]);

$routes->get('peserta/absensi-regular', 'Peserta\Absensi::index_regular', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-regular-input', 'Peserta\Absensi::input_regular', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-regular-save', 'Peserta\Absensi::save_regular', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-regular-editnote', 'Peserta\Absensi::edit_note_regular', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-regular-updatenote', 'Peserta\Absensi::update_note_regular', ["filter" => "authweb:4"]);

$routes->get('peserta/absensi-bina', 'Peserta\Absensi::index_bina', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-bina-input', 'Peserta\Absensi::input_bina', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-bina-save', 'Peserta\Absensi::save_bina', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-bina-editnote', 'Peserta\Absensi::edit_note_bina', ["filter" => "authweb:4"]);
$routes->post('peserta/absensi-bina-updatenote', 'Peserta\Absensi::update_note_bina', ["filter" => "authweb:4"]);

/*--- Ujian Peserta---*/
$routes->post('peserta/ujian', 'Peserta\Ujian::index', ["filter" => "authweb:4"]);

/*--- Biodata Peserta---*/
$routes->get('biodata-peserta', 'Peserta\Biodata::index', ["filter" => "authweb:4"]);
$routes->post('biodata-peserta/edit-password', 'Peserta\Biodata::edit_password', ["filter" => "authweb:4"]);
$routes->post('biodata-peserta/update', 'Peserta\Biodata::update', ["filter" => "authweb:4"]);
$routes->post('biodata-peserta/update-password', 'Peserta\Biodata::update_password', ["filter" => "authweb:4"]);

/*--- Sertifikat Peserta---*/
$routes->get('peserta/sertifikat', 'Peserta\Sertifikat::index', ["filter" => "authweb:4"]);
$routes->get('peserta/sertifikat-input', 'Peserta\Sertifikat::input', ["filter" => "authweb:4"]);
$routes->post('peserta/sertifikat-show', 'Peserta\Sertifikat::show_sertifikat', ["filter" => "authweb:4"]);
$routes->post('peserta/save-sertifikat', 'Peserta\Sertifikat::save_sertifikat', ["filter" => "authweb:4"]);

/*
 * --------------------------------------------------------------------
 * PENGAJAR
 * --------------------------------------------------------------------
 */
/*--- Kelas---*/
$routes->get('pengajar/kelas', 'Pengajar\Kelas::index', ["filter" => "authweb:5-6"]);
$routes->get('pengajar/absensi', 'Pengajar\Kelas::absensi', ["filter" => "authweb:5-6"]);
$routes->get('pengajar/ujian', 'Pengajar\Ujian::index', ["filter" => "authweb:5-6"]);
$routes->get('pengajar/ujian-custom', 'Pengajar\UjianCustom::index', ["filter" => "authweb:5-6"]);
$routes->get('pengajar/ujian-tabel', 'Pengajar\Ujian::index_tabel', ["filter" => "authweb:5-6"]);
$routes->get('pengajar/ujian-custom-tabel', 'Pengajar\UjianCustom::index_tabel', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/atur-absensi', 'Pengajar\Kelas::atur_absensi', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/input-absensi', 'Pengajar\Kelas::input_absensi', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/save-absensi', 'Pengajar\Kelas::save_absensi', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/update-atur-absensi', 'Pengajar\Kelas::update_atur_absensi', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/absensi-note', 'Pengajar\Kelas::absensi_note', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/update-absensi-note', 'Pengajar\Kelas::update_absensi_note', ["filter" => "authweb:5-6"]);

/*--- Kelas Non Regular---*/
$routes->get('pengajar/kelas-nonreg', 'Pengajar\KelasNonreg::index', ["filter" => "authweb:5-6"]);
$routes->get('pengajar/absensi-nonreg', 'Pengajar\KelasNonreg::absensi', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/input-absensi-nonreg', 'Pengajar\KelasNonreg::input_absensi', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/save-absensi-nonreg', 'Pengajar\KelasNonreg::save_absensi', ["filter" => "authweb:5-6"]);

$routes->get('penguji/kelas', 'Pengajar\KelasPenguji::index', ["filter" => "authweb:5-6"]);
$routes->post('penguji/absen', 'Pengajar\KelasPenguji::form_absen', ["filter" => "authweb:5-6"]);
$routes->post('penguji/save-absen', 'Pengajar\KelasPenguji::save_absen', ["filter" => "authweb:5-6"]);

/*--- Show Hasil Ujian ---*/
$routes->post('pengajar/show-ujian', 'Pengajar\Ujian::show_ujian', ["filter" => "authweb:5-6"]);
$routes->post('pengajar/save-show-ujian', 'Pengajar\Ujian::save_show_ujian', ["filter" => "authweb:5-6"]);

/*--- Biodata Pengajar---*/
$routes->get('biodata-pengajar', 'Pengajar\Biodata::index', ["filter" => "authweb:5-6"]);
$routes->post('biodata-pengajar/edit-password', 'Pengajar\Biodata::edit_password', ["filter" => "authweb:5-6"]);
$routes->post('biodata-pengajar/update', 'Pengajar\Biodata::update', ["filter" => "authweb:5-6"]);
$routes->post('biodata-pengajar/update-password', 'Pengajar\Biodata::update_password', ["filter" => "authweb:5-6"]);
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
