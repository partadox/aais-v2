<?php
namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;

class Kelas extends BaseController
{
    public function index()
    {
        $user           = $this->userauth(); // Return Array
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            }else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        
        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $get_pengajar_id    = $this->pengajar->get_pengajar_id($user['user_id']);
        $pengajar_id        = $get_pengajar_id->pengajar_id;
        $list               = $this->kelas->kelas_pengajar($pengajar_id, $angkatan);
        $data = [
            'title'                 => 'Daftar Kelas Anda pada Angkatan '.$angkatan,
            'user'                  => $user,
            'list_angkatan'         => $list_angkatan,
            'angkatan_pilih'        => $angkatan,
            'list'                  => $list,
        ];

        return view('panel_pengajar/kelas/index', $data); 
    }

    public function absensi()
    {
        $user = $this->userauth(); // Return Array

        //Angkatan
        $uri = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString = $uri->getQuery();
        $params = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('kelas', $params) && ctype_digit($params['kelas'])) {
            $kelas_id = $params['kelas'];
        } else {
            return redirect()->to('/pengajar/kelas');
        }

        $peserta_onkelas = $this->peserta_kelas->peserta_onkelas_absen($kelas_id);
        $absen_pengajar_id = $this->kelas->get_data_absen_pengajar_id($kelas_id)->data_absen_pengajar;
        $absen_pengajar = $this->absen_pengajar->find($absen_pengajar_id);

        $data = [
            'title' => 'Peserta Kelas',
            'list' => $this->kelas->list(),
            'user' => $user,
            'peserta_onkelas' => $peserta_onkelas,
            'detail_kelas' => $this->kelas->list_detail_kelas($kelas_id),
            'jumlah_peserta' => $this->peserta_kelas->jumlah_peserta_onkelas($kelas_id),
            'tatapMukaData' => [],
        ];

        for ($i = 1; $i <= 16; $i++) {
            $tmData = [
                'name' => "Tatap Muka ke-$i",
                'absensi' => $absen_pengajar["tm{$i}_pengajar"],
                'note' => $absen_pengajar["note_tm$i"],
                'tanggal' => $absen_pengajar["tgl_tm$i"],
            ];
            $data['tatapMukaData'][] = $tmData;
        }

        return view('panel_pengajar/kelas/absensi', $data);
    }

    public function input_absensi()
    {
        if ($this->request->isAJAX()) {

            $tm         = $this->request->getVar('tm');
            $tm_upper   = strtoupper($tm);
            $kelas_id   = $this->request->getVar('kelas_id');
            $absen_tm   = $this->peserta_kelas->peserta_onkelas_absen_tm($tm, $kelas_id);
            $data_absen_pengajar   = $this->request->getVar('data_absen_pengajar');

            //Data Kelas
            $data_kelas         = $this->kelas->list_detail_kelas($kelas_id);
            $nama_pengajar      = $data_kelas[0]['nama_pengajar'];
            $absen_pengajar_id  = $data_kelas[0]['data_absen_pengajar'];

            //Data absen pengajar
            $absen_pengajar  = $this->absen_pengajar->find($data_absen_pengajar);

            $data = [
                'title'         => 'Absensi Pengajar & Peserta',
                'tm'            => $tm,
                'kelas_id'      => $kelas_id,
                'tm_upper'      => $tm_upper,
                'nama_pengajar' => $nama_pengajar, 
                'absen_tm'      => $absen_tm,
                'absen_pengajar'=> $absen_pengajar,
                'absen_pengajar_id' => $absen_pengajar_id,
            ];

            $msg = [
                'sukses' => view('panel_pengajar/kelas/input_absensi', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function save_absensi()
    {
        $jml_psrt   = $this->request->getPost('jml_psrt');
        $total      = count($jml_psrt);

        $tatap_muka = $this->request->getVar('tatap_muka');
        $kelas_id   = $this->request->getPost('kelas_id');

        $url_kelas  = '/pengajar/absensi?kelas=' . $kelas_id;
        $datetime   = date("Y-m-d H:i:s");

        $absen_pengajar_id = $this->request->getPost('absen_pengajar_id');

        $checkpgj = $this->request->getPost('checkpgj' . substr($tatap_muka, 2)); 
        $tgl_tm = $this->request->getPost('tgl_tm' . substr($tatap_muka, 2));
        $note_tm = $this->request->getPost('note_tm' . substr($tatap_muka, 2));

        if ($checkpgj == NULL) {
            $this->session->setFlashdata('pesan_error', 'ERROR! Data pengajar pada form absensi ' . strtoupper($tatap_muka) . ' belum diisi!, Pilih Hadir!');
            return redirect()->to($url_kelas);
        }

        $updatepengajar = [
            $tatap_muka . '_pengajar' => $checkpgj,
            'tgl_' . $tatap_muka => $tgl_tm,
            'note_' . $tatap_muka => $note_tm,
            'ts' . substr($tatap_muka, 2) => $datetime, 
        ];

        $this->absen_pengajar->update($absen_pengajar_id, $updatepengajar);

        for ($i=1; $i<=$total; $i++){
            $var_tm = 'check' . $i;
            $var_psrt = 'psrt' . $i;
            $psrt_id = intval($this->request->getPost($var_psrt)); 

            $check = $this->request->getPost($var_tm);
            if ($check == NULL) {
                $this->session->setFlashdata('pesan_error', 'ERROR! Terdapat data peserta pada form absensi ' . strtoupper($tatap_muka) . ' belum diisi!, Pilih Hadir atau Tidak Hadir');
                return redirect()->to($url_kelas);
            }
            $updatedata = [$tatap_muka => intval($check)]; 
            $this->absen_peserta->update($psrt_id, $updatedata);
        }

        $this->session->setFlashdata('pesan_sukses', 'BERHASIL! Semua data absensi pengajar dan peserta Tatap Muka terisi');
        return redirect()->to($url_kelas); 
    }
}