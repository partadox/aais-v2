<?php
namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;

class Ujian extends BaseController
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

        $peserta_onkelas        = $this->peserta_kelas->peserta_onkelas_ujian($kelas_id);

        $data = [
            'title'             => 'Hasil Ujian Peserta Kelas',
            'user'              => $user,
            'list'              => $this->kelas->list(),
            'peserta_onkelas'   => $peserta_onkelas,
            'detail_kelas'      => $this->kelas->list_detail_kelas($kelas_id),
        ];
        return view('panel_pengajar/ujian/index', $data);
    }
}