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

    public function show_ujian()
    {
        if ($this->request->isAJAX()) {
            $kelas_id       = $this->request->getVar('kelas_id');
            $kelas          =  $this->kelas->find($kelas_id);

            $data = [
                'title'     => 'Tampilkan Nilai Ujian ',
                'kelas'     => $kelas,
            ];
            $msg = [
                'sukses' => view('panel_pengajar/ujian/show_ujian', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function save_show_ujian()
    {
        if ($this->request->isAJAX()) {
            $show_ujian = $this->request->getVar('show_ujian');
            if ($show_ujian != '1') {
                $show_ujian = NULL;
            }
            $update_data = [
                'show_ujian'  => $show_ujian,
            ];

            $kelas_id = $this->request->getVar('kelas_id');
            $this->kelas->update($kelas_id, $update_data);

            $kelas   = $this->kelas->find($kelas_id);
            $program = $this->program->find($kelas['program_id']);

            if ($program['ujian_custom_status'] == '1') {
                $redirect_url = '/ujian-custom?kelas='.$kelas_id;
            } else {
                $redirect_url = '/ujian?kelas='.$kelas_id;
            }

            $redirect = '/pengajar'.$redirect_url;

            $msg = [
                'sukses' => [
                    'link' => $redirect
                ]
            ];
            
            echo json_encode($msg);
        }
    }
}