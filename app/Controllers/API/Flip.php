<?php

namespace App\Controllers\Api;
use App\Libraries\JWTCI4;
use App\Models\Api_peserta;
use App\Models\Model_kelas;
use App\Models\Api_bayar;
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
use App\Models\Model_log;
use App\Models\Model_log_user;
use App\Models\Model_absen_peserta;
use App\Models\Model_absen_pengajar;
use App\Models\Model_bill;
use App\Models\Model_cart;
use App\Models\Model_ujian;
use App\Models\Model_payment;
use App\Models\Model_konfigurasi;

use CodeIgniter\RESTful\ResourceController;

class Flip extends ResourceController
{
    protected $helpers = ['form', 'url', 'cookie'];

    public function callback()
    {
        $this->konfigurasi          = new Model_konfigurasi;
		$this->peserta              = new Api_peserta;
		$this->kelas                = new Model_kelas;
		$this->bayar                = new Api_bayar;
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
		$this->log                  = new Model_log;
		$this->log_user             = new Model_log_user;
		$this->absen_peserta        = new Model_absen_peserta;
		$this->absen_pengajar       = new Model_absen_pengajar;
        $this->ujian                = new Model_ujian;
        $this->cart                 = new Model_cart;
        $this->payment              = new Model_payment;
        $this->bill                 = new Model_bill;
        $this->db 			        = \Config\Database::connect();

        $request = \Config\Services::request();

        // get JSON data
        // $Data = $request->getJSON(true);  // returns assoc array if valid JSON was sent
        // if ($jsonData) {
        //     return $this->respondCreated(['message' => "Using JSON".$jsonData]);
        // } 
        
        $Data = $request->getPost();
        $data = json_decode($Data['data'], true);  // decode the 'data' JSON string into an associative array
        if ($data) {
            $id             = $data['id'];
            $bill_link_id   = $data['bill_link_id'];
            $bill_link      = $data['bill_link'];
            $bill_title     = $data['bill_title'];
            $sender_name    = $data['sender_name'];
            $sender_email   = $data['sender_email'];
            $sender_bank    = $data['sender_bank'];
            $sender_bank_type = $data['sender_bank_type'];
            $amount         = $data['amount'];
            $status         = $data['status'];
            $created_at     = $data['created_at'];
        } else {
            return $this->respondCreated(['message' => "Invalid data JSON"]);
        }

        $title_explode      = explode("-", $bill_title);
        
        $peserta_kelas_id   = $title_explode[0];
        $cart_id            = $title_explode[1];
        $bayar_id           = $title_explode[2];
        $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
        $peserta_id         = $peserta_kelas['data_peserta_id'];
        $kelas_id           = $peserta_kelas['data_kelas_id'];

        $data_kelas         = $this->kelas->find($kelas_id);
        $peserta            = $this->peserta->find($peserta_id);
        
        if ($cart_id == 00) {
            if ($status == 'SUCCESSFUL') {

                $this->db->transStart();
                $updateBayar = [
                    'status_bayar'              => 'Lunas',
                    'status_bayar_admin'        => 'SESUAI BAYAR',
                    'status_konfirmasi'         => 'Terkonfirmasi',
                    'tgl_bayar_konfirmasi'      => date("Y-m-d"),
                    'waktu_bayar_konfirmasi'    => date("H:i:s"),
                    'validator'                 => 'Flip Payment Gateway',
                ];
                $this->bayar->update($bayar_id, $updateBayar);
    
                $bayar  = $this->bayar->find($bayar_id);
                $modul  = $bayar['awal_bayar_modul'];
                $spp2   = $bayar['awal_bayar_spp2'];
                $spp3   = $bayar['awal_bayar_spp3'];
                $spp4   = $bayar['awal_bayar_spp4'];
                $infaq  = $bayar['awal_bayar_infaq'];
                $lainnya= $bayar['awal_bayar_lainnya'];
    
                if ($spp2 != '0') {
                    $PKspp2 = [
                        'byr_spp2'            => $spp2,
                        'dt_konfirmasi_spp2'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp2);
                }
    
                if ($spp3 != '0') {
                    $PKspp3 = [
                        'byr_spp3'            => $spp3,
                        'dt_konfirmasi_spp3'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp3);
                }
    
                if ($spp4 != '0') {
                    $PKspp4 = [
                        'byr_spp4'            => $spp4,
                        'dt_konfirmasi_spp4'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp4);
                }
    
                if ($modul != '0') {
                    $PKmodul = [
                        'byr_modul'            => $modul,
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKmodul);
                    $data_modul = [
                        'bayar_modul_id'        => $bayar_id,
                        'bayar_modul'           => $modul,
                        'status_bayar_modul'    => 'Lunas',
                    ];
                    $this->bayar_modul->insert($data_modul);
                }
    
                if ($lainnya != '0') {
                    $data_lain = [
                        'lainnya_bayar_id'        => $bayar_id,
                        'bayar_lainnya'           => $lainnya,
                        'data_peserta_id_lain'    => $peserta_id,
                        'status_bayar_lainnya'    => 'Lunas',
                    ];
                    $this->bayar_lain->insert($data_lain);
                }
    
                if ($infaq != '0') {
                    $data_infaq = [
                        'infaq_bayar_id'        => $bayar_id,
                        'bayar_infaq'           => $infaq,
                        'data_peserta_id_infaq' => $peserta_id
                    ];
                    $this->infaq->insert($data_infaq);
                }
    
                //Get data total bayar
                $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
                $byr_daftar         = $peserta_kelas['byr_daftar'];
                $byr_modul          = $peserta_kelas['byr_modul'];
                $byr_spp1           = $peserta_kelas['byr_spp1'];
                $byr_spp2           = $peserta_kelas['byr_spp2'];
                $byr_spp3           = $peserta_kelas['byr_spp3'];
                $byr_spp4           = $peserta_kelas['byr_spp4'];
    
                $beasiswa_daftar    = $peserta_kelas['beasiswa_daftar'];
                $beasiswa_spp1      = $peserta_kelas['beasiswa_spp1'];
                $beasiswa_spp2      = $peserta_kelas['beasiswa_spp2'];
                $beasiswa_spp3      = $peserta_kelas['beasiswa_spp3'];
                $beasiswa_spp4      = $peserta_kelas['beasiswa_spp4'];
    
                $payments = [
                    [$byr_daftar, $beasiswa_daftar],
                    [$byr_spp1, $beasiswa_spp1],
                    [$byr_spp2, $beasiswa_spp2],
                    [$byr_spp3, $beasiswa_spp3],
                    [$byr_spp4, $beasiswa_spp4]
                ];
                
                $spp_status = 'LUNAS';
                
                foreach ($payments as $payment) {
                    if (($payment[0] == '0' && $payment[1] != 1) || ($payment[0] == NULL && $payment[1] != 1)) {
                        $spp_status = 'BELUM LUNAS';
                        break;
                    }
                }
    
                $PKstatus = [
                    'spp_status'  => $spp_status,
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKstatus);
    
                $aktivitas = 'Pembayaran SPP peserta '. $peserta['nis'].'-'.$peserta['nama_peserta'] .' pada kelas ' . $data_kelas['nama_kelas']. ' terkonfirmasi oleh flip';
    
                if ($this->db->transStatus() === FALSE)
                {
                    $this->db->transRollback();
                    /*--- Log ---*/
                    $log = [
                        'username_log' => 'Flip Payment',
                        'tgl_log'      => date("Y-m-d"),
                        'waktu_log'    => date("H:i:s"),
                        'status_log'   => 'FAIL',
                        'aktivitas_log'=> $aktivitas,
                    ];
                    $this->log->insert($log);
                }
                else
                {
                    $this->db->transComplete();
                    /*--- Log ---*/
                    $log = [
                        'username_log' => 'Flip Payment',
                        'tgl_log'      => date("Y-m-d"),
                        'waktu_log'    => date("H:i:s"),
                        'status_log'   => 'BERHASIL',
                        'aktivitas_log'=> $aktivitas,
                    ];
                    $this->log->insert($log);
                }
                return $this->respondCreated([
                    'message' => 'Callback Success',
                    'id' => $id,
                    'bill_link_id' => $bill_link_id,
                    'bill_link' => $bill_link,
                    'bill_title' => $bill_title,
                    'sender_name' => $sender_name,
                    'sender_email' => $sender_email,
                    'sender_bank' => $sender_bank,
                    'sender_bank_type' => $sender_bank_type,
                    'amount' => $amount,
                    'status' => $status,
                    'created_at' => $created_at,
                ]);
            } else {
                /*--- Log ---*/
                $log = [
                    'username_log' => 'Flip Payment',
                    'tgl_log'      => date("Y-m-d"),
                    'waktu_log'    => date("H:i:s"),
                    'status_log'   => 'GAGAL',
                    'aktivitas_log'=> $bill_title.' '.$status.' invoice bill: '.$bill_title.', total: '.$amount,
                ];
                $this->log->insert($log);
                return $this->respondCreated(['message' => 'Callback Failed']);
            }
        } else {
            if ($status == 'SUCCESSFUL') {

                $this->db->transStart();
                $updateBayar = [
                    'status_bayar'              => 'Lunas',
                    'status_bayar_admin'        => 'SESUAI BAYAR',
                    'status_konfirmasi'         => 'Terkonfirmasi',
                    'tgl_bayar_konfirmasi'      => date("Y-m-d"),
                    'waktu_bayar_konfirmasi'    => date("H:i:s"),
                    'validator'                 => 'Flip Payment Gateway',
                ];
                $this->bayar->update($bayar_id, $updateBayar);
    
                $bayar  = $this->bayar->find($bayar_id);
                $daftar = $bayar['awal_bayar_daftar'];
                $modul  = $bayar['awal_bayar_modul'];
                $spp1   = $bayar['awal_bayar_spp1'];
                $spp2   = $bayar['awal_bayar_spp2'];
                $spp3   = $bayar['awal_bayar_spp3'];
                $spp4   = $bayar['awal_bayar_spp4'];
                $infaq  = $bayar['awal_bayar_infaq'];
                $lainnya= $bayar['awal_bayar_lainnya'];
    
                if ($daftar != '0') {
                    $dataabsen = [
                        'bckp_absen_peserta_id'     => $peserta_id,
                        'bckp_absen_peserta_kelas'  => $kelas_id,
                    ];
                    $this->absen_peserta->insert($dataabsen);
        
                    $dataujian = [
                        'bckp_ujian_peserta'     => $peserta_id,
                        'bckp_ujian_kelas'       => $kelas_id,
                    ];
                    $this->ujian->insert($dataujian);
                    $PKdaftar = [
                        'byr_daftar'            => $daftar,
                        'dt_konfirmasi_daftar'  => date('Y-m-d H:i:s'),
                        'data_absen'            => $this->absen_peserta->insertID(),
                        'data_ujian'            => $this->ujian->insertID(),
                        'expired_tgl_daftar'    => NULL,
                        'expired_waktu_daftar'  => NULL,
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKdaftar);
                }
    
                if ($spp1 != '0') {
                    $PKspp1 = [
                        'byr_spp1'            => $spp1,
                        'dt_konfirmasi_spp1'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp1);
                }
    
                if ($spp2 != '0') {
                    $PKspp2 = [
                        'byr_spp2'            => $spp2,
                        'dt_konfirmasi_spp2'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp2);
                }
    
                if ($spp3 != '0') {
                    $PKspp3 = [
                        'byr_spp3'            => $spp3,
                        'dt_konfirmasi_spp3'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp3);
                }
    
                if ($spp4 != '0') {
                    $PKspp4 = [
                        'byr_spp4'            => $spp4,
                        'dt_konfirmasi_spp4'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp4);
                }
    
                if ($modul != '0') {
                    $PKmodul = [
                        'byr_modul'            => $modul,
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKmodul);
                    $data_modul = [
                        'bayar_modul_id'        => $bayar_id,
                        'bayar_modul'           => $modul,
                        'status_bayar_modul'    => 'Lunas',
                    ];
                    $this->bayar_modul->insert($data_modul);
                }
    
                if ($lainnya != '0') {
                    $data_lain = [
                        'lainnya_bayar_id'        => $bayar_id,
                        'bayar_lainnya'           => $lainnya,
                        'data_peserta_id_lain'    => $peserta_id,
                        'status_bayar_lainnya'    => 'Lunas',
                    ];
                    $this->bayar_lain->insert($data_lain);
                }
    
                if ($infaq != '0') {
                    $data_infaq = [
                        'infaq_bayar_id'        => $bayar_id,
                        'bayar_infaq'           => $infaq,
                        'data_peserta_id_infaq' => $peserta_id
                    ];
                    $this->infaq->insert($data_infaq);
                }
    
                //Get data total bayar
                $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
                $byr_daftar         = $peserta_kelas['byr_daftar'];
                $byr_modul          = $peserta_kelas['byr_modul'];
                $byr_spp1           = $peserta_kelas['byr_spp1'];
                $byr_spp2           = $peserta_kelas['byr_spp2'];
                $byr_spp3           = $peserta_kelas['byr_spp3'];
                $byr_spp4           = $peserta_kelas['byr_spp4'];
    
                $beasiswa_daftar    = $peserta_kelas['beasiswa_daftar'];
                $beasiswa_spp1      = $peserta_kelas['beasiswa_spp1'];
                $beasiswa_spp2      = $peserta_kelas['beasiswa_spp2'];
                $beasiswa_spp3      = $peserta_kelas['beasiswa_spp3'];
                $beasiswa_spp4      = $peserta_kelas['beasiswa_spp4'];
    
                $payments = [
                    [$byr_daftar, $beasiswa_daftar],
                    [$byr_spp1, $beasiswa_spp1],
                    [$byr_spp2, $beasiswa_spp2],
                    [$byr_spp3, $beasiswa_spp3],
                    [$byr_spp4, $beasiswa_spp4]
                ];
                
                $spp_status = 'LUNAS';
                
                foreach ($payments as $payment) {
                    if (($payment[0] == '0' && $payment[1] != 1) || ($payment[0] == NULL && $payment[1] != 1)) {
                        $spp_status = 'BELUM LUNAS';
                        break;
                    }
                }
    
                $PKstatus = [
                    'spp_status'  => $spp_status,
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKstatus);
                $this->cart->delete($cart_id);
    
                $aktivitas = 'Pendaftaran peserta '. $peserta['nis'].'-'.$peserta['nama_peserta'] .' pada kelas ' . $data_kelas['nama_kelas']. ' terkonfirmasi oleh flip';
    
                if ($this->db->transStatus() === FALSE)
                {
                    $this->db->transRollback();
                    /*--- Log ---*/
                    $log = [
                        'username_log' => 'Flip Payment',
                        'tgl_log'      => date("Y-m-d"),
                        'waktu_log'    => date("H:i:s"),
                        'status_log'   => 'FAIL',
                        'aktivitas_log'=> $aktivitas,
                    ];
                    $this->log->insert($log);
                }
                else
                {
                    $this->db->transComplete();
                    /*--- Log ---*/
                    $log = [
                        'username_log' => 'Flip Payment',
                        'tgl_log'      => date("Y-m-d"),
                        'waktu_log'    => date("H:i:s"),
                        'status_log'   => 'BERHASIL',
                        'aktivitas_log'=> $aktivitas,
                    ];
                    $this->log->insert($log);
                }
                return $this->respondCreated([
                    'message' => 'Callback Success',
                    'id' => $id,
                    'bill_link_id' => $bill_link_id,
                    'bill_link' => $bill_link,
                    'bill_title' => $bill_title,
                    'sender_name' => $sender_name,
                    'sender_email' => $sender_email,
                    'sender_bank' => $sender_bank,
                    'sender_bank_type' => $sender_bank_type,
                    'amount' => $amount,
                    'status' => $status,
                    'created_at' => $created_at,
                ]);
            } else {
                /*--- Log ---*/
                $log = [
                    'username_log' => 'Flip Payment',
                    'tgl_log'      => date("Y-m-d"),
                    'waktu_log'    => date("H:i:s"),
                    'status_log'   => 'GAGAL',
                    'aktivitas_log'=> $bill_title.' '.$status.' invoice bill: '.$bill_title.', total: '.$amount,
                ];
                $this->log->insert($log);
                return $this->respondCreated(['message' => 'Callback Failed']);
            }
        }
        
    }
    
}
