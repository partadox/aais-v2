<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Ujian extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
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
        $list_ujian         = $this->peserta_kelas->admin_rekap_ujian($angkatan);

        $data = [
            'title'         => 'Data Ujian Peserta pada Angkatan Perkuliahan ' . $angkatan,
            'user'          => $user,
            'list'          => $list_ujian,
            'list_angkatan' => $list_angkatan,
            'angkatan_pilih'=> $angkatan,
        ];
        return view('panel_admin/ujian/index', $data);
    }

    /*--- BACKEND ---*/


}