<?php

namespace App\Controllers;
use App\Libraries\JWTCI4;

// use App\Models\Model_User;
use App\Models\Model_user;
use App\Models\Model_peserta;
use App\Models\Model_kelas;
use App\Models\Model_bayar;
use App\Models\Model_spp1;
use App\Models\Model_spp2;
use App\Models\Model_spp3;
use App\Models\Model_spp4;
use App\Models\Model_infaq;
use App\Models\Model_bayar_lain;
use App\Models\Model_bayar_modul;
use App\Models\Model_peserta_kelas;
use App\Models\Model_program;
use App\Models\Model_pengajar;
use App\Models\Model_level;
use App\Models\Model_kantor;
use App\Models\Model_bank;
use App\Models\Model_log;
use App\Models\Model_log_user;
use App\Models\Model_absen_peserta;
use App\Models\Model_absen_pengajar;
use App\Models\Model_beasiswa;
use App\Models\Model_bill;
use App\Models\Model_cart;
use App\Models\Model_ujian;
use App\Models\Model_sertifikat;
use App\Models\Model_konfigurasi;
use App\Models\Model_nonreg_absen_peserta;
use App\Models\Model_nonreg_kelas;
use App\Models\Model_nonreg_pengajar;
use App\Models\Model_nonreg_peserta;
use App\Models\Model_payment;
use App\Models\Model_pekerjaan;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url', 'cookie', 'Tgl_indo'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->session      = \Config\Services::session();
        // $this->user         = new Model_User();
        $this->konfigurasi          = new Model_konfigurasi;
		$this->user                 = new Model_user($request);
		$this->peserta              = new Model_peserta($request);
		$this->kelas                = new Model_kelas;
		$this->bayar                = new Model_bayar;
		$this->spp1                 = new Model_spp1;
		$this->spp2                 = new Model_spp2;
		$this->spp3                 = new Model_spp3;
		$this->spp4                 = new Model_spp4;
		$this->infaq                = new Model_infaq;
		$this->bayar_lain           = new Model_bayar_lain;
		$this->bayar_modul          = new Model_bayar_modul;
		$this->peserta_kelas        = new Model_peserta_kelas;
		$this->program              = new Model_program;
		$this->pengajar             = new Model_pengajar;
		$this->level                = new Model_level;
		$this->kantor               = new Model_kantor;
		$this->bank                 = new Model_bank;
		$this->log                  = new Model_log;
		$this->log_user             = new Model_log_user;
		$this->absen_peserta        = new Model_absen_peserta;
		$this->absen_pengajar       = new Model_absen_pengajar;
		$this->ujian                = new Model_ujian;
		$this->sertifikat           = new Model_sertifikat;
        $this->pekerjaan            = new Model_pekerjaan;
        $this->cart                 = new Model_cart;
        $this->payment              = new Model_payment;
        $this->bill                 = new Model_bill;
        $this->beasiswa             = new Model_beasiswa($request);
        $this->nonreg_kelas         = new Model_nonreg_kelas;
        $this->nonreg_peserta       = new Model_nonreg_peserta;
        $this->nonreg_pengajar      = new Model_nonreg_pengajar;
        $this->nonreg_absen_peserta = new Model_nonreg_absen_peserta();
        $this->db 			= \Config\Database::connect();
    }

    public function userauth(){
		$token      = get_cookie('gem');
		$jwt        = new JWTCI4;
		$user	    = $jwt->decodeweb($token);
		$user_code  = $user->uid;
		$userdata   = $this->user->find($user_code);
		return $userdata;
	}

    public function logging($role, $status, $aktivitas){
		$user       = $this->userauth();
        if ($role == "Admin") {
            $nama   = $user['nama'];
        } else{
            $user_id  = $user['user_id'];
            $peserta  = $this->peserta->get_peserta($user_id);
            $nama     = $peserta['nis'].' - '.$peserta['nama_peserta'];
        }

        $log = [
            'username_log' => $nama,
            'tgl_log'      => date("Y-m-d"),
            'waktu_log'    => date("H:i:s"),
            'status_log'   => $status,
            'aktivitas_log'=> $aktivitas,
        ];

        if ($role == "Admin") {
            $this->log->insert($log);
        } else{
            $this->log_user->insert($log);
        }
	}
}
