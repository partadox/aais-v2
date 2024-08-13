<?php
namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;

class UjianCustom extends BaseController
{

    public function index()
    {
        $user           = $this->userauth(); // Return Array
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('kelas', $params)) {
            $kelas_id           = $params['kelas'];
            if (!ctype_digit($kelas_id)) {
                return redirect()->to('/pengajar/kelas');
            }
        } else {
            return redirect()->to('/pengajar/kelas');
        }

        $kelas                  = $this->kelas->find($kelas_id);
        $peserta_onkelas        = $this->peserta_kelas->peserta_onkelas_ujian_custom($kelas_id);
        $pengajar               = $this->pengajar->find($kelas['pengajar_id']);
        $program                = $this->program->find($kelas['program_id']);
        $ucc                    = $this->ujian_custom_config->find($program['ujian_custom_id']);

        // Menghapus duplikasi berdasarkan ucv_ujian_id
        $temp_array = array();
        $key_array = array();

        foreach ($peserta_onkelas as $val) {
            if (!in_array($val['ucv_ujian_id'], $key_array)) {
                $key_array[] = $val['ucv_ujian_id'];
                $temp_array[] = $val;
            }
        }
        
        $peserta_onkelas_unique = array_values($temp_array);

        $data = [
            'title'             => 'Hasil Ujian Peserta Kelas',
            'user'              => $user,
            // 'list'              => $this->kelas->list(),
            'nama_pengajar'     => $pengajar['nama_pengajar'],
            'peserta_onkelas'   => $peserta_onkelas_unique,
            'ucc'               => $ucc,
            'kelas'             => $kelas,
            'program'           => $program
        ];
        return view('panel_pengajar/ujian_custom/index', $data);
    }

    public function index_tabel()
    {
        $user           = $this->userauth(); // Return Array
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('kelas', $params)) {
            $kelas_id           = $params['kelas'];
            if (!ctype_digit($kelas_id)) {
                return redirect()->to('/pengajar/kelas');
            }
        } else {
            return redirect()->to('/pengajar/kelas');
        }

        $kelas                  = $this->kelas->find($kelas_id);
        $peserta_onkelas        = $this->peserta_kelas->peserta_onkelas_ujian_custom($kelas_id);
        $pengajar               = $this->pengajar->find($kelas['pengajar_id']);
        $program                = $this->program->find($kelas['program_id']);
        $ucc                    = $this->ujian_custom_config->find($program['ujian_custom_id']);

        $data = [
            'title'             => 'Hasil Ujian Peserta Kelas',
            'user'              => $user,
            // 'list'              => $this->kelas->list(),
            'nama_pengajar'     => $pengajar['nama_pengajar'],
            'peserta_onkelas'   => $peserta_onkelas,
            'ucc'               => $ucc,
            'kelas'             => $kelas,
            'program'           => $program
        ];
        return view('panel_pengajar/ujian_custom/index_tabel', $data);
    }

    /*--- BACKEND ---*/

    
}