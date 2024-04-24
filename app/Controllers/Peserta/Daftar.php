<?php
namespace App\Controllers\Peserta;
use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;

class Daftar extends BaseController
{
    public function index()
    {
        $user           = $this->userauth();
        $user_id        = $user['user_id'];
        $peserta        = $this->peserta->get_peserta($user_id);
        $peserta_id             = $peserta['peserta_id'];
        $level_peserta  = $peserta['level_peserta']; 

        # Cek Status Pendaftarn
        $get_status_daftar = $this->konfigurasi->status_pendaftaran();
        $status_daftar     = $get_status_daftar->status_pendaftaran;
        # Cek ada data yang belum dibayar
        $cek               = $this->cart->cek_daftar($peserta_id);
        // var_dump(count($cek));
        if (count($cek) == 0) {
            //Level
            $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
            $queryString    = $uri->getQuery();
            $params         = [];
            parse_str($queryString, $params);

            if (count($params) == 1 && array_key_exists('level', $params)) {
                $level           = $params['level'];
                if (ctype_digit($level)) {
                    $level           = $params['level'];
                }else {
                    $level = $level_peserta;
                }
            } else {
                $level = $level_peserta;
            }

            //Get Angkatan Perkuliahan
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;

            //Get data peserta
            $peserta_id             = $peserta['peserta_id'];
            $peserta_level          = $level;
            $peserta_jenkel         = $peserta['jenkel'];
            $peserta_status_kerja   = $peserta['status_kerja'];
            $peserta_domisili       = $peserta['domisili_peserta'];

            //Jika status bukan pekerja maka akan tampil kelas dengan status_kerja = 0 (Kelas di Weekdays saja)
            //Else status pekerja maka akan tampil kelas dengan status_kerja 1 dan 0 (Weekdays dan Weekend Akan Tampil)

            //Aktif Filter Pencocokan Domisili dengan Metode Perkuliahahn
            $get_filter_domisili    = $this->konfigurasi->filter_domisili();
            $filter_domisili        = $get_filter_domisili->filter_domisili;

            $program = $this->kelas->list_ondaftar($filter_domisili, $peserta_domisili, $peserta_level, $peserta_jenkel, $peserta_status_kerja, $angkatan, $peserta_id );

            $data = [
                'title'              => 'Pendaftaran Kelas Program',
                'user'               => $user,
                'level'              => $level,
                'tampil_ondaftar'    => $this->level->list_tampil_ondaftar(),
                'peserta'            => $peserta,
                'program'            => $program,
                'status_pendaftaran' => $status_daftar,
                'cek'                => count($cek),
            ];
            return view('panel_peserta/daftar/index', $data);
        } else {
            return redirect()->to('/bayar/daftar');
        }
        
    }

    /*--- BACKEND ---*/

    public function save()
    {

        if ($this->request->isAJAX()) {
            $peserta_id     = $this->request->getVar('peserta_id');
            $kelas_id       = $this->request->getVar('kelas_id');
            $kelas          = $this->kelas->find($kelas_id);
            $peserta        = $this->peserta->find($peserta_id);
            // Timeout 1 jam (minute format)
            $timeout        = date('Y-m-d H:i:s', strtotime('+60 minutes', strtotime(date('Y-m-d H:i:s'))));
            $dateTime       = new \DateTime($timeout);
            
            $newpesertakelas = [
                'data_peserta_id'       => $peserta_id,
                'data_kelas_id'         => $kelas_id,
                'status_peserta_kelas'  => 'BELUM LULUS',
                'spp_status'            => 'BELUM BAYAR PENDAFTARAN',
                'expired_tgl_daftar'    => $dateTime->format('Y-m-d'),
                'expired_waktu_daftar'  => $dateTime->format('H:i:s'),
            ];

            $this->db->transStart();
            $this->peserta_kelas->insert($newpesertakelas);
            $newcart = [
                'cart_peserta'       => $peserta_id,
                'cart_kelas'         => $kelas_id,
                'cart_peserta_kelas' => $this->peserta_kelas->insertID(),
                'cart_timeout'       => $timeout,
                'cart_type'          => 'daftar',
            ];
            $this->cart->insert($newcart);
            

            $aktivitas = 'Memilih kelas '.$kelas['nama_kelas']. ' waktu timeout pembayaran '.$timeout;

            if ($this->db->transStatus() === FALSE)
            {
                $this->db->transRollback();
                /*--- Log ---*/
                $this->logging('Peserta', 'FAIL', $aktivitas);
            }
            else
            {
                $this->db->transComplete();
                /*--- Log ---*/
                $this->logging('Peserta', 'BERHASIL', $aktivitas);
                $msgWA  = "Konfirmasi Pemesanan Kelas "."\n\nSelamat ".$peserta['nama_peserta'].", NIS = ".$peserta['nis']." \n\nAnda telah melakukan pemesanan kelas: ".$kelas['nama_kelas']." pada ".date("d-m-Y H:i")." WITA"."\n\nUntuk selanjutnya harap segera login ke aplikasi Alhaqq Academic Information System (AAIS) untuk melakukan pembayaran atas pemesanan tersebut https://aais.alhaqq.or.id"."\n\nPemesanan Anda akan dibatalkan oleh sistem secara otomatis jika tidak terjadi pembayaran setelah melewati ".$dateTime->format('d-m-Y H:i')." WITA\n\nAdmin\n628787890 0052\nLTTQ Al Haqq Balikpapan (Pusat)";
                $this->sendWA("aaispusat", $peserta['hp'],$msgWA);
            }

            $msg = [
                'sukses' => [
                    'link' => 'bayar/daftar'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function tes()
    {
        $length = 6;
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = mt_rand(0, strlen($characters) - 1);
            $code .= $characters[$randomIndex];
        }
        echo $code;
    }
}