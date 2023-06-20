<?php
namespace App\Controllers\Peserta;

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
        $get_peserta_id     = $this->peserta->get_peserta_id($user['user_id']);
        $peserta_id         = $get_peserta_id->peserta_id;
        $list               = $this->peserta_kelas->kelas_peserta($angkatan, $peserta_id);
        $data = [
            'title'                 => 'Daftar Kelas Anda pada Angkatan '.$angkatan,
            'user'                  => $user,
            'list_angkatan'         => $list_angkatan,
            'angkatan_pilih'        => $angkatan,
            'list'                  => $list,
        ];

        return view('panel_peserta/kelas/index', $data); 
    }
}