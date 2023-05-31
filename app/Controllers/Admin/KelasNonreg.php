<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class KelasNonreg extends BaseController
{
    public function index()
    {
        $user           = $this->userauth();

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        
        $list_angkatan      = $this->nonreg_kelas->list_unik_angkatan();
        $list_kelas         = $this->nonreg_kelas->list($angkatan);
        $data = [
            'title'             => 'Manajamen Kelas Non-Regular Angkatan ' . $angkatan,
            'list'              => $list_kelas,
            'list_angkatan'     => $list_angkatan,
            'angkatan_pilih'    => $angkatan,
            'user'              => $user,
        ];
        return view('panel_admin/kelas_nonreg/index', $data);
    }

    public function input()
    {
        if ($this->request->isAJAX()) {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;

            $data = [
                'title'     => 'Form Input Kelas Non-Regular Baru',
                'pengajar'  => $this->pengajar->list(),
                'peserta'   => $this->peserta->list(),
                'level'     => $this->level->list(),
                'angkatan'  => $angkatan,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_nonreg/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $nk_id          = $this->request->getVar('nk_id');
            $nonreg_kelas   =  $this->nonreg_kelas->find($nk_id);
            $data = [
                'title'     => 'Ubah Data Kelas Non-Regular '.$nonreg_kelas['nk_name'],
                'pengajar'  => $this->pengajar->list(),
                'nonreg'    => $nonreg_kelas,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_nonreg/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function detail()
    {
        $user           = $this->userauth();
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('id', $params)) {
            $nk_id              = $params['id'];
            $peserta_onkelas    = $this->nonreg_peserta->peserta_onkelas($nk_id);
            $kelas              = $this->nonreg_kelas->find($nk_id);
            $koor               = NULL;
            if ($kelas['nk_absen_koor'] != NULL) {
                $koor_peserta_id    = $kelas['nk_absen_koor'];
                $koor_peserta       = $this->peserta->find($koor_peserta_id);
                $koor               = $koor_peserta['nis'] .'-'. $koor_peserta['nama_peserta'];
            }
            
            $data = [
                'title'             => 'Al-Haqq - Detail Kelas Non-Regular',
                'user'              => $user,
                'peserta_onkelas'   => $peserta_onkelas,
                'koor'              => $koor,
                'detail_kelas'      => $kelas,
                'pengajar'          => $this->nonreg_pengajar->pengajar_onkelas($nk_id),
                'jumlah_peserta'    => count($peserta_onkelas),
            ];
            return view('panel_admin/kelas_nonreg/detail', $data);
        } else {
            return redirect()->to('kelas-nonreg');
        }
    }

    public function detail_modal()
    {
        if ($this->request->isAJAX()) {
            $modul              = $this->request->getVar('modul');
            $nk_id              = $this->request->getVar('nk_id');
            $nonreg_kelas       = $this->nonreg_kelas->find($nk_id);
            $peserta            = NULL;
            $pengajar           = NULL;
            $koor               = NULL;

            if ($modul == 'peserta') {
                $title = 'Form Input Peserta';
                $peserta = $this->peserta->list();
            } elseif ($modul == 'pengajar') {
                $title = 'Form Input Pengjar';
                $pengajar = $this->pengajar->list();
            } elseif($modul == 'absensi'){
                $title        = 'Form Pengaturan Absensi Kelas Non-Regular';
                $koor         = $this->nonreg_peserta->peserta_onkelas($nk_id);
            }

            $data = [
                'title'     => $title,
                'pengajar'  => $pengajar,
                'peserta'   => $peserta,
                'nonreg'    => $nonreg_kelas,
                'koor'      => $koor,
                'modul'     => $modul,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_nonreg/detail_modal', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- BACKEND ---*/
    public function create()
    {
        
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nk_name' => [
                    'label' => 'nk_name',
                    'rules' => 'required|is_unique[nonreg_kelas.nk_name]',
                    'errors' => [
                        'required' => 'Nama Kelas tidak boleh kosong',
                        'is_unique' => 'Nama Kelas harus unik, sudah ada yang menggunakan Nama Kelas ini',
                    ]
                ],
                'nk_angkatan' => [
                    'label' => 'nk_angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angakatan tidak boleh kosong',
                    ]
                ],
                'nj_pengajar' => [
                    'label' => 'nj_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pengajar tidak boleh kosong',
                    ]
                ],
                'nk_hari' => [
                    'label' => 'nk_hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari tidak boleh kosong',
                    ]
                ],
                'nk_waktu' => [
                    'label' => 'nk_waktu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Waktu tidak boleh kosong',
                    ]
                ],
                'nk_timezone' => [
                    'label' => 'nk_timezone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Zona Waktu tidak boleh kosong',
                    ]
                ],
                'nk_jenkel' => [
                    'label' => 'nk_jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin tidak boleh kosong',
                    ]
                ],
                'nk_tm_total' => [
                    'label' => 'nk_tm_total',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'TM Total tidak boleh kosong',
                    ]
                ],
                'nk_tm_methode' => [
                    'label' => 'nk_tm_methode',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Metode TM tidak boleh kosong',
                    ]
                ],
                'nk_status' => [
                    'label' => 'nk_status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status Kelas tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nk_name'      => $validation->getError('nk_name'),
                        'nk_angkatan'  => $validation->getError('nk_angkatan'),
                        'nj_pengajar'  => $validation->getError('nj_pengajar'),
                        'nk_hari'      => $validation->getError('nk_hari'),
                        'nk_waktu'     => $validation->getError('nk_waktu'),
                        'nk_timezone'  => $validation->getError('nk_timezone'),
                        'nk_jenkel'    => $validation->getError('nk_jenkel'),
                        'nk_tm_total'  => $validation->getError('nk_tm_total'),
                        'nk_tm_methode'=> $validation->getError('nk_tm_methode'),
                        'nk_status'    => $validation->getError('nk_status'),
                    ]
                ];
            } else {
                
                
                $this->db->transStart();
                $nonreg_kelas_New = [
                    'nk_name'          => strtoupper($this->request->getVar('nk_name')),
                    'nk_angkatan'      => $this->request->getVar('nk_angkatan'),
                    'nk_hari'          => $this->request->getVar('nk_hari'),
                    'nk_waktu'         => $this->request->getVar('nk_waktu'),
                    'nk_timezone'      => $this->request->getVar('nk_timezone'),
                    'nk_jenkel'        => $this->request->getVar('nk_jenkel'),
                    'nk_tm_total'      => $this->request->getVar('nk_tm_total'),
                    'nk_tm_methode'    => $this->request->getVar('nk_tm_methode'),
                    'nk_created'       => date('Y-m-d H:i:s'),
                    'nk_status'        => $this->request->getVar('nk_status'),
                    'nk_absen_status'  => '0',
                    'nk_absen_methode' => 'Mandiri',
                ];
                $this->nonreg_kelas->insert($nonreg_kelas_New);
                $nj_kelas = $this->nonreg_kelas->insertID();
                $pengajar     = $this->request->getPost('nj_pengajar');
                foreach ($pengajar as $item) {
                    $nonreg_pengajar_NEW = [
                        'nj_pengajar' => $item,
                        'nj_kelas'    => $nj_kelas,
                    ];
                    $this->nonreg_pengajar->insert($nonreg_pengajar_NEW);
                }
                $this->db->transComplete();
                
                $aktivitas = 'Buat Data Kelas Non-Regular Nama : ' .  $this->request->getVar('nama_kelas');

                if ($this->db->transStatus() === FALSE)
                {
                    /*--- Log ---*/
				    $this->logging('Admin', 'FAIL', $aktivitas);
                }
                else
                {
                    /*--- Log ---*/
				    $this->logging('Admin', 'BERHASIL', $aktivitas);
                }

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-nonreg'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                
                'nk_name' => [
                    'label' => 'nk_name',
                    'rules' => 'required|is_unique_except[nonreg_kelas.nk_name.nk_id.'. $this->request->getVar('nk_id').']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'nk_angkatan' => [
                    'label' => 'nk_angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angakatan tidak boleh kosong',
                    ]
                ],
                'nk_hari' => [
                    'label' => 'nk_hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari tidak boleh kosong',
                    ]
                ],
                'nk_waktu' => [
                    'label' => 'nk_waktu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Waktu tidak boleh kosong',
                    ]
                ],
                'nk_timezone' => [
                    'label' => 'nk_timezone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Zona Waktu tidak boleh kosong',
                    ]
                ],
                'nk_jenkel' => [
                    'label' => 'nk_jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin tidak boleh kosong',
                    ]
                ],
                'nk_tm_total' => [
                    'label' => 'nk_tm_total',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'TM Total tidak boleh kosong',
                    ]
                ],
                'nk_tm_methode' => [
                    'label' => 'nk_tm_methode',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Metode TM tidak boleh kosong',
                    ]
                ],
                'nk_status' => [
                    'label' => 'nk_status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status Kelas tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nk_name'      => $validation->getError('nk_name'),
                        'nk_angkatan'  => $validation->getError('nk_angkatan'),
                        'nk_hari'      => $validation->getError('nk_hari'),
                        'nk_waktu'     => $validation->getError('nk_waktu'),
                        'nk_timezone'  => $validation->getError('nk_timezone'),
                        'nk_jenkel'    => $validation->getError('nk_jenkel'),
                        'nk_tm_total'  => $validation->getError('nk_tm_total'),
                        'nk_tm_methode'=> $validation->getError('nk_tm_methode'),
                        'nk_status'    => $validation->getError('nk_status'),
                    ]
                ];
            } else {

                $updatedata = [
                    'nk_name'          => strtoupper($this->request->getVar('nk_name')),
                    'nk_angkatan'      => $this->request->getVar('nk_angkatan'),
                    'nk_hari'          => $this->request->getVar('nk_hari'),
                    'nk_waktu'         => $this->request->getVar('nk_waktu'),
                    'nk_timezone'      => $this->request->getVar('nk_timezone'),
                    'nk_jenkel'        => $this->request->getVar('nk_jenkel'),
                    'nk_tm_total'      => $this->request->getVar('nk_tm_total'),
                    'nk_tm_methode'    => $this->request->getVar('nk_tm_methode'),
                    'nk_status'        => $this->request->getVar('nk_status'),
                ];

                $nk_id = $this->request->getVar('nk_id');
                $this->nonreg_kelas->update($nk_id, $updatedata);

                // Data Log END
                $aktivitas = 'Ubah Data Kelas Non-Regular Nama : ' .  $this->request->getVar('nama_kelas');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-nonreg'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update_detail()
    {
        if ($this->request->isAJAX()) {

            $modul  = $this->request->getVar('modul');
            $nk_id  = $this->request->getVar('nk_id');
            $nonreg = $this->nonreg_kelas->find($nk_id);

            if ($modul == 'peserta') {
                $peserta     = $this->request->getPost('ns_peserta');
                foreach ($peserta as $item) {
                    $nonreg_peserta_NEW = [
                        'ns_peserta' => $item,
                        'ns_kelas'   => $nk_id,
                        'ns_status'  => 'BELUM LULUS',
                    ];
                    $this->nonreg_peserta->insert($nonreg_peserta_NEW);
                }
                $pesan      = 'Berhasil Tambah Data Peserta';
                $aktivitas  = 'Memasukan data peserta di kelas non regular ' .  $nonreg['nk_name'];
            } elseif ($modul == 'pengajar') {
                $pengajar     = $this->request->getPost('nj_pengajar');
                foreach ($pengajar as $item) {
                    $nonreg_pengajar_NEW = [
                        'nj_pengajar' => $item,
                        'nj_kelas'    => $nk_id,
                    ];
                    $this->nonreg_pengajar->insert($nonreg_pengajar_NEW);
                }
                $pesan      = 'Berhasil Tambah Data Pengajar';
                $aktivitas  = 'Memasukan data pengajar di kelas non regular ' .  $nonreg['nk_name'];
            } elseif ($modul == 'absensi') {
                $metode = $this->request->getVar('nk_absen_methode');
                if ($metode == 'Perwakilan') {
                    $koor = $this->request->getVar('nk_absen_koor');
                } elseif ($metode == 'Mandiri') {
                    $koor = NULL;
                }
                $updatedata = [
                    'nk_absen_status'   => $this->request->getVar('nk_absen_status'),
                    'nk_absen_methode'  => $metode,
                    'nk_absen_koor'     => $koor,
                ];
                $this->nonreg_kelas->update($nk_id, $updatedata);
                $pesan      = 'Berhasil Ganti Pengaturan Absensi';
                $aktivitas  = 'Mengubah pengaturan absensi di kelas non regular ' .  $nonreg['nk_name'];
            }

                // Data Log END
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => '/kelas-nonreg/detail?id='.$nk_id,
                        'pesan'=> $pesan
                    ]
                ];
            
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $modul   = $this->request->getVar('modul');
            $nk_id   = $this->request->getVar('nk_id');
            $nama  = $this->request->getVar('nama');
            $nonreg  = $this->nonreg_kelas->find($nk_id);

            if ($modul == 'pengajar') {
                $nj_id = $this->request->getVar('id');
                $this->nonreg_pengajar->delete($nj_id);
            } elseif ($modul == 'peserta') {
                $ns_id = $this->request->getVar('id');
                $this->nonreg_peserta->delete($ns_id);
            }

            $aktivitas = 'Hapus ' . $modul . ' nama  : ' .  $nama . ' pada kelas ' .  $nonreg['nk_name'];

            if ($this->db->transStatus() === FALSE)
            {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            }
            else
            {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => '/kelas-nonreg/detail?id='. $nk_id 
                ]
            ];
            echo json_encode($msg);
        }
    }

    
    
}