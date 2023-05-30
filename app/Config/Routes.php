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
$routes->set404Override(function( $message = null )
{
    
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

$routes->post('peserta/getdata', 'Admin\Peserta::getdata', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/create', 'Admin\Peserta::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('peserta/update', 'Admin\Peserta::update', ["filter" => "authweb:1-2-3-7"]);
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

$routes->post('pengajar/getdata', 'Admin\Pengajar::getdata', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/create', 'Admin\Pengajar::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/update', 'Admin\Pengajar::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/delete', 'Admin\Pengajar::delete', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/deleteselect', 'Admin\Pengajar::deleteselect', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/import', 'Admin\Pengajar::import', ["filter" => "authweb:1-2-3-7"]);
$routes->get('pengajar/export', 'Admin\Pengajar::export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('pengajar/edit-multiple', 'Admin\Pengajar::edit_multiple', ["filter" => "authweb:1-2-3-7"]);

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

/*--- Kelas Regular---*/
$routes->get('kelas-regular', 'Admin\KelasReg::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/input', 'Admin\KelasReg::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/edit', 'Admin\KelasReg::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->get('kelas-regular/detail', 'Admin\KelasReg::detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/input-setting', 'Admin\KelasReg::input_setting', ["filter" => "authweb:1-2"]);
$routes->post('kelas-regular/input-move', 'Admin\KelasReg::input_move', ["filter" => "authweb:1-2-3-7"]);

$routes->post('kelas-regular/create', 'Admin\KelasReg::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/update', 'Admin\KelasReg::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/save-setting', 'Admin\KelasReg::save_setting', ["filter" => "authweb:1-2"]);
$routes->get('kelas-regular/export', 'Admin\KelasReg::export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/move', 'Admin\KelasReg::move', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-regular/delete-peserta', 'Admin\KelasReg::delete_peserta', ["filter" => "authweb:1-2-3-7"]);

/*--- Kelas Non-Regular---*/
$routes->get('kelas-nonreg', 'Admin\KelasNonreg::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/input', 'Admin\KelasNonreg::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/edit', 'Admin\KelasNonreg::edit', ["filter" => "authweb:1-2-3-7"]);
$routes->get('kelas-nonreg/detail', 'Admin\KelasNonreg::detail', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/input-setting', 'Admin\KelasNonreg::input_setting', ["filter" => "authweb:1-2"]);
$routes->post('kelas-nonreg/input-move', 'Admin\KelasNonreg::input_move', ["filter" => "authweb:1-2-3-7"]);

$routes->post('kelas-nonreg/create', 'Admin\KelasNonreg::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/update', 'Admin\KelasNonreg::update', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/save-setting', 'Admin\KelasNonreg::save_setting', ["filter" => "authweb:1-2"]);
$routes->get('kelas-nonreg/export', 'Admin\KelasNonreg::export', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/move', 'Admin\KelasNonreg::move', ["filter" => "authweb:1-2-3-7"]);
$routes->post('kelas-nonreg/delete-peserta', 'Admin\KelasNonreg::delete_peserta', ["filter" => "authweb:1-2-3-7"]);

/*--- Level---*/
$routes->get('level', 'Admin\Level::index', ["filter" => "authweb:1-2-3-7"]);
$routes->post('level/input', 'Admin\Level::input', ["filter" => "authweb:1-2-3-7"]);
$routes->post('level/edit', 'Admin\Level::edit', ["filter" => "authweb:1-2-3-7"]);

$routes->post('level/create', 'Admin\Level::create', ["filter" => "authweb:1-2-3-7"]);
$routes->post('level/update', 'Admin\Level::update', ["filter" => "authweb:1-2-3-7"]);

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

/*--- Bayar---*/
$routes->get('bayar/daftar', 'Peserta\Bayar::index', ["filter" => "authweb:4"]);

$routes->post('bayar/save-manual', 'Peserta\Bayar::save_manual', ["filter" => "authweb:4"]);
$routes->post('bayar/generate-flip', 'Peserta\Bayar::generate_flip', ["filter" => "authweb:4"]);
$routes->post('bayar/cancel', 'Peserta\Bayar::cancel', ["filter" => "authweb:4"]);

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
