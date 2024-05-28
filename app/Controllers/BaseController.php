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
use App\Models\Model_bina_absen_peserta;
use App\Models\Model_bina_kelas;
use App\Models\Model_bina_pengajar;
use App\Models\Model_bina_peserta;
use App\Models\Model_nonreg_kelas;
use App\Models\Model_nonreg_kelas_level;
use App\Models\Model_nonreg_peserta;
use App\Models\Model_nonreg_tipe;
use App\Models\Model_nonreg_usaha;
use App\Models\Model_payment;
use App\Models\Model_pekerjaan;
use App\Models\Model_pengumuman;
use App\Models\Model_ujian_custom_config;
use App\Models\Model_ujian_custom_value;
use App\Models\Model_wa;
use App\Models\Model_wa_switch;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use Mpdf\Mpdf;
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
		$this->bayar                = new Model_bayar($request);
		$this->spp1                 = new Model_spp1;
		$this->spp2                 = new Model_spp2;
		$this->spp3                 = new Model_spp3;
		$this->spp4                 = new Model_spp4;
		$this->infaq                = new Model_infaq;
		$this->bayar_lain           = new Model_bayar_lain;
		$this->bayar_modul          = new Model_bayar_modul;
		$this->peserta_kelas        = new Model_peserta_kelas($request);
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
        $this->bina_kelas           = new Model_bina_kelas;
        $this->bina_peserta         = new Model_bina_peserta;
        $this->bina_pengajar        = new Model_bina_pengajar;
        $this->bina_absen_peserta   = new Model_bina_absen_peserta();
        $this->pengumuman           = new Model_pengumuman();
        $this->ujian_custom_config  = new Model_ujian_custom_config();
        $this->ujian_custom_value   = new Model_ujian_custom_value();
        $this->nonreg_tipe          = new Model_nonreg_tipe();
        $this->nonreg_kelas         = new Model_nonreg_kelas();
        $this->nonreg_peserta       = new Model_nonreg_peserta();
        $this->nonreg_usaha         = new Model_nonreg_usaha();
        $this->nonreg_kelas_level   = new Model_nonreg_kelas_level();
        $this->wa                   = new Model_wa();
        $this->wa_switch            = new Model_wa_switch();
        $this->db 			        = \Config\Database::connect();
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

    public function generate_nomor_sertifikat($kodeProgram)
    {
        $last           = $this->sertifikat->where('status','1')->orderBy('sertifikat_id', 'desc')->first();  
        if ($last != NULL) {
            $part       = explode("/", $last['nomor_sertifikat']); 
            $nomor_urut = $part[0];
            $tahun      = $part[4];

            if ($tahun == date('Y')) {
                $nomor_urut     = str_pad(($part[0]+1),4,"0",STR_PAD_LEFT);
            }else{
                $nomor_urut     = '0001';
            }
        } else{
            $nomor_urut     = '0001';
        }
        $bulan = romawi(date('m'));
        $nomor_sertifikat = $nomor_urut.'/SER'.'/'.$kodeProgram.'/'.$bulan.'/'.date('Y');
        return $nomor_sertifikat;
    }

    public function generate_sertifikat($sertifikat_id)
    {
        // Create Mpdf instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        // Add a page
        $mpdf->AddPage();
        $sertifikat = $this->sertifikat->find($sertifikat_id);
        $program    = $this->program->find($sertifikat['sertifikat_program']);
        $peserta    = $this->peserta->find($sertifikat['sertifikat_peserta_id']);
        $template   = $program['sertemp_program'];
        if ($template == NULL) {
            $template = "Sertifikat_Tes.pdf";
        }
        

        // Set the source file (PDF, image, etc.)
        $sourceFile     = 'public/assets/template/'.$template;
        // Output file path
        $outputFilePath = 'public/sertifikat/'.$sertifikat['sertifikat_file'];

        $pageCount = $mpdf->SetSourceFile($sourceFile);

        // Import a page from the source file
        $templateId = $mpdf->ImportPage($pageCount);

        // Use the imported page as a template
        $mpdf->UseTemplate($templateId);

        $pageWidth = $mpdf->w;

        // Variable Nomor Sertifikat
        $mpdf->SetFont('arial', '', 15);
        $mpdf->SetTextColor(235, 183, 52);
        $textWidth  = $mpdf->GetStringWidth($sertifikat['nomor_sertifikat']);
        $centerX    = ($pageWidth - $textWidth) / 2;
        $y          = 77;
        $mpdf->Text($centerX, $y, $sertifikat['nomor_sertifikat']);

        // Variable Nama Peserta
        $mpdf->SetFont('sertifikat-nama', '', 80); //
        $mpdf->SetTextColor(255, 255, 255);
        $namaSert   = ucwords(strtolower($peserta['nama_peserta'])); 
        $textWidth  = $mpdf->GetStringWidth($namaSert);
        $centerX    = ($pageWidth - $textWidth) / 2;
        $y          = 118;
        $mpdf->Text($centerX, $y, $namaSert);

        // Variable tgl
        $mpdf->SetFont('arial', '', 13);
        $mpdf->SetTextColor(255, 255, 255);
        $varTgl     = $sertifikat['sertifikat_tgl'];
        $tglSert    = "Balikpapan, ". date_indo($varTgl);
        $textWidth  = $mpdf->GetStringWidth($tglSert);
        $centerX    = (($pageWidth - $textWidth)) / 2;
        $y          = 153;
        $mpdf->Text($centerX, $y, $tglSert); // Adjusted coordinates for certificate number

        // Save the generated PDF
        $mpdf->Output($outputFilePath, 'F');
        return True;
    }

    public function sendWA($session, $to, $text) 
    {
        if ($to[0] == '0') {
            $to = '62' . substr($to, 1);
        }

        $countryCode ="62";
        if (substr($to, 0, 2) == "62" || substr($to, 0, 2) == "08") {
            $countryCode ="62";
        } else {
            $countryCode = substr($to, 0, 2);
        }
        // // API URL
        // $apiUrl = 'https://wa-gateway.alhaqq.or.id/send-message?session='.$session.'&to='.$to.'&text='.urlencode($text);

        // // Initialize cURL session
        // $ch = curl_init($apiUrl);

        // // Set cURL options
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPGET, true); 

        // // Execute cURL session
        // $response = curl_exec($ch);

        // // Close cURL session
        // curl_close($ch);

        // return $response;

        $dataWA = $this->wa->find(1);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $to,
                'message' => $text, 
                'countryCode' => $countryCode, //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization:'.$dataWA['wa_key'] //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }
}
