<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Absensi extends BaseController
{
    public function index()
    {
        if ($this->request->isAJAX()) {

            $user           = $this->userauth(); // Return Array
            $absen_peserta_id     = $this->request->getVar('data_absen');
            $kelas_id             = $this->request->getVar('kelas_id');

            $data_absen_peserta   = $this->absen_peserta->find($absen_peserta_id);
            $data_kelas           = $this->kelas->list_detail_kelas($kelas_id);

            $data = [
                'title'             => 'Absensi Peserta Kelas ' . $data_kelas[0]['nama_kelas'],
                'detail_kelas'      => $data_kelas,
                'tm1'               => $data_absen_peserta ['tm1'],
                'tm2'               => $data_absen_peserta ['tm2'],
                'tm3'               => $data_absen_peserta ['tm3'],
                'tm4'               => $data_absen_peserta ['tm4'],
                'tm5'               => $data_absen_peserta ['tm5'],
                'tm6'               => $data_absen_peserta ['tm6'],
                'tm7'               => $data_absen_peserta ['tm7'],
                'tm8'               => $data_absen_peserta ['tm8'],
                'tm9'               => $data_absen_peserta ['tm9'],
                'tm10'              => $data_absen_peserta ['tm10'],
                'tm11'              => $data_absen_peserta ['tm11'],
                'tm12'              => $data_absen_peserta ['tm12'],
                'tm13'              => $data_absen_peserta ['tm13'],
                'tm14'              => $data_absen_peserta ['tm14'],
                'tm15'              => $data_absen_peserta ['tm15'],
                'tm16'              => $data_absen_peserta ['tm16'],
            ];

            $msg = [
                'sukses' => view('panel_peserta/absensi/index', $data)
            ];
            echo json_encode($msg);
        }

    }

    /*--- REGULAR FRONTEND ---*/

    public function index_regular()
    {
        $user           = $this->userauth();
        $user_id        = $user['user_id'];
        $peserta        = $this->peserta->get_peserta($user_id);
        $peserta_id     = $peserta['peserta_id'];

        //Kelas id
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('absen', $params) && array_key_exists('kelas', $params)) {
            $absen   = $params['absen'];
            $kelas   = $params['kelas'];
            if (ctype_digit($absen) && ctype_digit($kelas)) {
                $absen_peserta_id   = $params['absen'];
                $kelas_id           = $params['kelas'];
            }else {
                return redirect()->to('/peserta-kelas');
            }
        } else {
            return redirect()->to('/peserta-kelas');
        }

        $absensi  = $this->absen_peserta->find($absen_peserta_id);
        $kelas    = $this->kelas->find($kelas_id);

        if ((!$absensi && !$kelas) == true) {
            return redirect()->to('/peserta-kelas');
        }

        $absensi_pengajar = $this->absen_pengajar->find($kelas['data_absen_pengajar']);

        $pengajar       = $this->pengajar->find($kelas['pengajar_id']);
        $nama_pengajar  = $pengajar['nama_pengajar'];

        $data = [
            'title'             => 'Absensi Kelas Regular ',
            'user'              => $user,
            'peserta_id'        => $peserta_id,
            'kelas'             => $kelas,
            'nama_pengajar'     => $nama_pengajar,
            'absensi'           => $absensi,
            'absensi_pengajar'  => $absensi_pengajar
        ];
        return view('panel_peserta/absensi/regular/index', $data);
    }

    public function input_regular()
    {
        if ($this->request->isAJAX()) {

            $user               = $this->userauth(); // Return Array
            $user_id            = $user['user_id'];
            $peserta            = $this->peserta->get_peserta($user_id);
            $peserta_id         = $peserta['peserta_id'];
            $methode            = $this->request->getVar('methode');
            $absen_peserta_id   = $this->request->getVar('absen_peserta_id');
            $kelas_id           = $this->request->getVar('kelas_id');

            $kelas     = $this->kelas->find($kelas_id);

            if ($methode == 'Mandiri') {
                $absensi  = $this->absen_peserta->find($absen_peserta_id);
                $peserta        = $this->peserta->find($peserta_id );
                $data = [
                    'title'         => 'Absensi Peserta Kelas ' . $kelas['nama_kelas'] . ' - Absensi Mandiri',
                    'absensi' => $absensi,
                    'kelas'         => $kelas,
                    'peserta'       => $peserta
                ];
    
                $msg = [
                    'sukses' => view('panel_peserta/absensi/regular/input-mandiri', $data)
                ];
            }
            
            echo json_encode($msg);
        }
    }

    public function edit_note_regular()
    {
        if ($this->request->isAJAX()) {

            $absen_peserta_id   = $this->request->getVar('absen_peserta_id');
            $note_ps_tm         = $this->request->getVar('note_ps_tm');
            $absen              = $this->absen_peserta->find($absen_peserta_id);
            $note               = $absen[$note_ps_tm];
            $data = [
                'title'            => 'Ubah Catatan Absen TM',
                'absen_peserta_id' => $absen_peserta_id,
                'note_ps_tm'       => $note_ps_tm,
                'note'             => $note,
            ];
            $msg = [
                'sukses' => view('panel_peserta/absensi/regular/edit-note', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- REGULAR BACKEND ---*/

    public function save_regular()
    {
        $metode               = $this->request->getVar('metode');
        $kelas_id             = $this->request->getVar('kelas_id');
        $absen_peserta_id     = $this->request->getVar('absen_peserta_id');
        $tm                   = $this->request->getVar('tm');
        $check                = $this->request->getVar('check');
        $note_ps_tm           = str_replace(array("\r", "\n"), ' ',$this->request->getVar('note_ps_tm'));

        $kelas                = $this->kelas->find($kelas_id);

        $url_kelas  = '/peserta/absensi-regular?absen='.$absen_peserta_id.'&kelas=' . $kelas_id;

        if ($metode == 'Mandiri') {
            $this->db->transBegin();
            $results = [];
            $check = $this->request->getPost('check');
            if ($check == NULL) {
                $this->db->transRollback();
                $this->session->setFlashdata('pesan_error', 'GAGAL! Absensi belum diisi!, Pilih Hadir atau Tidak Hadir');
                return redirect()->to($url_kelas);
            }
            if (strtotime(date('Y-m-d H:i:s')) > strtotime($kelas['expired_absen'])) {
                $this->db->transRollback();
                $this->session->setFlashdata('pesan_error', 'GAGAL! Waktu melakukan absensi sudah habis');
                return redirect()->to($url_kelas);
            }
            $update = [
                'tm'.$tm => $check,
                'note_ps_tm'.$tm => $note_ps_tm
            ]; 
            $results[] = $this->absen_peserta->update($absen_peserta_id, $update);
            if (in_array(FALSE, $results, true)) {
                $this->db->transRollback();
                $aktivitas = "Penyimpanan Absen pada ".$kelas['nama_kelas']." ada yg Gagal (Mandiri)";
                $this->logging('Peserta', 'GAGAL', $aktivitas);
            } else {
                $this->db->transCommit();
                $aktivitas = "Penyimpanan Absen pada ".$kelas['nama_kelas']." Berhasil (Mandiri)";
                $this->logging('Peserta', 'BERHASIL', $aktivitas);
            }
            $this->session->setFlashdata('pesan_sukses', 'BERHASIL! Semua data absensi pengajar dan peserta Tatap Muka terisi');
            return redirect()->to($url_kelas); 
        }
    }

    public function update_note_regular()
    {
        if ($this->request->isAJAX()) {
            $absen_peserta_id    = $this->request->getVar('absen_peserta_id');
            $note_ps_tm          = $this->request->getVar('note_ps_tm');

            $absen               = $this->absen_peserta->find($absen_peserta_id );

            $update_data = [
                $note_ps_tm  => str_replace(array("\r", "\n"), ' ',$this->request->getVar('note'))
            ];
            $this->absen_peserta->update($absen_peserta_id, $update_data);

            $aktivitas = 'Edit Catatan '.$note_ps_tm;
            $this->logging('Peserta', 'BERHASIL', $aktivitas);


            $msg = [
                'sukses' => [
                    'link' => '/peserta/absensi-regular?absen='.$absen_peserta_id.'&kelas='.$absen['bckp_absen_peserta_kelas']
                ]
            ];
        }
        echo json_encode($msg);
    }

    /*--- PEMBINAAN FRONTEND ---*/

    public function index_bina()
    {
        $user           = $this->userauth();
        $user_id        = $user['user_id'];
        $peserta        = $this->peserta->get_peserta($user_id);
        $peserta_id     = $peserta['peserta_id'];

        //Kelas id
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('bs', $params) && array_key_exists('bk', $params)) {
            $bk_id           = $params['bk'];
            $bs_id           = $params['bs'];
            if (ctype_digit($bk_id) && ctype_digit($bs_id)) {
                $bk_id           = $params['bk'];
                $bs_id           = $params['bs'];
            }else {
                return redirect()->to('/peserta-kelas');
            }
        } else {
            return redirect()->to('/peserta-kelas');
        }

        $bk   = $this->bina_kelas->find($bk_id);
        $bs   = $this->bina_peserta->find($bs_id);

        if ((!$bs && !$bk) == true) {
            return redirect()->to('/peserta-kelas');
        }

        $absensi = $this->bina_absen_peserta->absen_peserta($bs_id); 

        $data = [
            'title'             => 'Absensi Kelas',
            'user'              => $user,
            'peserta_id'        => $peserta_id,
            'bs_id'             => $bs_id,
            'kelas'             => $bk,
            'absensi'           => $absensi
        ];
        return view('panel_peserta/absensi/bina/index', $data);
    }

    public function input_bina()
    {
        if ($this->request->isAJAX()) {

            $user      = $this->userauth(); // Return Array
            $methode   = $this->request->getVar('methode');
            $bk_id     = $this->request->getVar('bk_id');
            $bs_id     = $this->request->getVar('bs_id');

            $kelas     = $this->bina_kelas->find($bk_id);
            $list      = $this->bina_peserta->peserta_kelas($bk_id);
            
            $list_tm    = $this->bina_absen_peserta->tm_kelas($bk_id);
                
            if (!$list_tm) {
                $tm = 1;
            } else {
                $highest_tm = max(array_column($list_tm, 'bas_tm'));
                $tm         = $highest_tm + 1;
            }

            if ($methode == 'Perwakilan') {
                
                
                $data = [
                    'title' => 'Absensi Peserta Kelas ' . $kelas['bk_name'] . ' (Perwakilan)',
                    'tm'    => $tm,
                    'kelas' => $kelas,
                    'bs_id' => $bs_id,
                    'list'  => $list,
                ];
    
                $msg = [
                    'sukses' => view('panel_peserta/absensi/bina/input-koor', $data)
                ];
            } elseif ($methode == 'Mandiri') {
                $bs         = $this->bina_peserta->find($bs_id);
                $peserta    = $this->peserta->find($bs['bs_peserta']);
                $data = [
                    'title'     => 'Absensi Peserta Kelas ' . $kelas['bk_name'] . ' (Mandiri)',
                    'tm'        => $tm,
                    'kelas'     => $kelas,
                    'bs_id'     => $bs_id,
                    'bs'        => $bs,
                    'peserta'   => $peserta
                ];
    
                $msg = [
                    'sukses' => view('panel_peserta/absensi/bina/input-mandiri', $data)
                ];
            }
            
            echo json_encode($msg);
        }
    }

    public function edit_note_bina()
    {
        if ($this->request->isAJAX()) {

            $bas_id = $this->request->getVar('bas_id');
            $bas    =  $this->bina_absen_peserta->find($bas_id);
            $data = [
                'title'=> 'Ubah Catatan Absen TM-'.$bas['bas_tm'],
                'bas'  => $bas,
            ];
            $msg = [
                'sukses' => view('panel_peserta/absensi/bina/edit-note', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- PEMBINAAN BACKEND ---*/

    public function save_bina()
    {
        $metode     = $this->request->getVar('metode');

        $bs_id      = $this->request->getVar('bs_id');

        $bs         = $this->bina_peserta->find($bs_id);
        $peserta_id = $bs['bs_peserta'];
        $peserta    = $this->peserta->find($peserta_id);

        $bas_tm     = $this->request->getVar('bas_tm');
        $bas_tm_dt  = $this->request->getVar('bas_tm_dt');
        $bas_bkid   = $this->request->getVar('bk_id');

        $kelas      = $this->bina_kelas->find($bas_bkid);

        $url_kelas  = '/peserta/absensi-bina?bs='.$bs_id.'&bk=' . $bas_bkid;

        if ($metode == 'Perwakilan') {
            $jml_psrt   = $this->request->getPost('jml_psrt');
            $total      = count($jml_psrt);
    
            $this->db->transBegin();
            $results = [];
            for ($i=1; $i<=$total; $i++){
                $var_tm = 'check' . $i;
                $var_psrt = 'psrt' . $i;
                $bas_nsid = intval($this->request->getPost($var_psrt)); 
    
                $check = $this->request->getPost($var_tm);
                if ($check == NULL) {
                    $this->db->transRollback();
                    $this->session->setFlashdata('pesan_error', 'ERROR! Terdapat data peserta pada form absensi belum diisi!, Pilih Hadir atau Tidak Hadir');
                    return redirect()->to($url_kelas);
                }
                $new = [
                    'bas_nsid' => $bas_nsid,
                    'bas_bkid' => $bas_bkid,
                    'bas_tm'   => $bas_tm,
                    'bas_tm_dt'=> $bas_tm_dt,
                    'bas_absen'=> $check,
                    'bas_create'=> date('Y-m-d H:i:s'),
                    'bas_by'    => $peserta['nis'] .' - '. $peserta['nama_peserta'],
                ]; 
    
                $results[] = $this->bina_absen_peserta->insert($new);
            }
            if (in_array(FALSE, $results, true)) {
                $this->db->transRollback();
                $aktivitas = "Penyimpanan Absen pada ".$kelas['bk_name']." ada yg Gagal (Perwakilan)";
                $this->logging('Peserta', 'GAGAL', $aktivitas);
            } else {
                $this->db->transCommit();
                $aktivitas = "Penyimpanan Absen pada ".$kelas['bk_name']." Berhasil (Perwakilan)";
                $this->logging('Peserta', 'BERHASIL', $aktivitas);
            }
            $this->session->setFlashdata('pesan_sukses', 'BERHASIL! Semua data absensi pengajar dan peserta Tatap Muka terisi');
            return redirect()->to($url_kelas); 
        } elseif ($metode == 'Mandiri') {
            $this->db->transBegin();
            $results = [];
            $bas_nsid = intval($this->request->getVar('bs_id')); 
            $check = $this->request->getPost('check');
            if ($check == NULL) {
                $this->db->transRollback();
                $this->session->setFlashdata('pesan_error', 'GAGAL! Absensi belum diisi!, Pilih Hadir atau Tidak Hadir');
                return redirect()->to($url_kelas);
            }
            if (strtotime(date('Y-m-d H:i:s')) > strtotime($kelas['bk_absen_expired'])) {
                $this->db->transRollback();
                $this->session->setFlashdata('pesan_error', 'GAGAL! Waktu melakukan absensi sudah habis');
                return redirect()->to($url_kelas);
            }
            $new = [
                'bas_nsid' => $bas_nsid,
                'bas_bkid' => $bas_bkid,
                'bas_tm'   => $bas_tm,
                'bas_tm_dt'=> $bas_tm_dt,
                'bas_absen'=> $check,
                'bas_create'=> date('Y-m-d H:i:s'),
                'bas_by'    => $peserta['nis'] .' - '. $peserta['nama_peserta'],
                'bas_note'  => str_replace(array("\r", "\n"), ' ',$this->request->getVar('bas_note'))
            ]; 
            $results[] = $this->bina_absen_peserta->insert($new);
            if (in_array(FALSE, $results, true)) {
                $this->db->transRollback();
                $aktivitas = "Penyimpanan Absen pada ".$kelas['bk_name']." ada yg Gagal (Mandiri)";
                $this->logging('Peserta', 'GAGAL', $aktivitas);
            } else {
                $this->db->transCommit();
                $aktivitas = "Penyimpanan Absen pada ".$kelas['bk_name']." Berhasil (Mandiri)";
                $this->logging('Peserta', 'BERHASIL', $aktivitas);
            }
            $this->session->setFlashdata('pesan_sukses', 'BERHASIL! Semua data absensi pengajar dan peserta Tatap Muka terisi');
            return redirect()->to($url_kelas); 
        }
    }

    public function update_note_bina()
    {
        if ($this->request->isAJAX()) {
            $bas_id    = $this->request->getVar('bas_id');
            $bas       = $this->bina_absen_peserta->find($bas_id);
            $update_data = [
                'bas_note'  => str_replace(array("\r", "\n"), ' ',$this->request->getVar('bas_note'))
            ];
            $this->bina_absen_peserta->update($bas_id, $update_data);

            $aktivitas = 'Edit Catatan TM-'.$bas['bas_tm'];
            $this->logging('Peserta', 'BERHASIL', $aktivitas);


            $msg = [
                'sukses' => [
                    'link' => '/peserta/absensi-bina?bs='.$bas['bas_nsid'].'&bk='.$bas['bas_bkid']
                ]
            ];
        }
        echo json_encode($msg);
    }
}