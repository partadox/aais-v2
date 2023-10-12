<?php
namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;

class KelasPenguji extends BaseController
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
        $penguji_id         = $get_pengajar_id->pengajar_id;
        $list               = $this->kelas->kelas_penguji($penguji_id, $angkatan);
        $data = [
            'title'                 => 'Daftar Kelas Anda pada Angkatan '.$angkatan.' Sebagai Penguji',
            'user'                  => $user,
            'list_angkatan'         => $list_angkatan,
            'angkatan_pilih'        => $angkatan,
            'list'                  => $list,
        ];
        
        return view('panel_pengajar/kelaspenguji/index', $data); 
    }

    public function form_absen()
    {
        if ($this->request->isAJAX()) {

            $kelas_id  = $this->request->getVar('kelas_id');
            $kelas     = $this->kelas->find($kelas_id);

            $data = [
                'title' => 'Form Absensi Penguji',
                'kelas' => $kelas,
            ];

            $msg = [
                'sukses' => view('panel_pengajar/kelaspenguji/absen', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function save_absen()
    {
        if ($this->request->isAJAX()) {

            if ($this->request->isAJAX()) {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'absen_tgl' => [
                        'label' => 'Tgl absen',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                    'absen_waktu' => [
                        'label' => 'Waktu absen',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'absen_tgl'  => $validation->getError('absen_tgl'),
                            'absen_waktu'=> $validation->getError('absen_waktu'),
                        ]
                    ];
                } else {
                    $kelas_id    = $this->request->getVar('kelas_id');
                    $absen_tgl   = $this->request->getVar('absen_tgl');
                    $absen_waktu = $this->request->getVar('absen_waktu');
                    $updatedata = [
                        'absen_penguji'  => $absen_tgl.' '.$absen_waktu,
                    ];

                    $this->kelas->update($kelas_id, $updatedata);

                    $msg = [
                        'sukses' => [
                            'link' => '/penguji/kelas'
                        ]
                    ];

                }
            }
        }
        echo json_encode($msg);
    }
}