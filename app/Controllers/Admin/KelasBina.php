<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class KelasBina extends BaseController
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

        $list_angkatan      = $this->bina_kelas->list_unik_angkatan();
        $list_kelas         = $this->bina_kelas->list($angkatan);
        $data = [
            'title'             => 'Manajamen Kelas Pembinaan Angkatan ' . $angkatan,
            'list'              => $list_kelas,
            'list_angkatan'     => $list_angkatan,
            'angkatan_pilih'    => $angkatan,
            'user'              => $user,
        ];
        return view('panel_admin/kelas_bina/index', $data);
    }

    public function input()
    {
        if ($this->request->isAJAX()) {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;

            $data = [
                'title'     => 'Form Input Pembinaan Baru',
                'pengajar'  => $this->pengajar->list(),
                'peserta'   => $this->peserta->list(),
                'level'     => $this->level->list(),
                'angkatan'  => $angkatan,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_bina/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $bk_id          = $this->request->getVar('bk_id');
            $bina_kelas   =  $this->bina_kelas->find($bk_id);
            $data = [
                'title'     => 'Ubah Data Kelas Pembinaan ' . $bina_kelas['bk_name'],
                'pengajar'  => $this->pengajar->list(),
                'bina'    => $bina_kelas,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_bina/edit', $data)
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
            $bk_id              = $params['id'];
            $peserta_onkelas    = $this->bina_peserta->peserta_onkelas($bk_id);
            $kelas              = $this->bina_kelas->find($bk_id);
            $koor               = NULL;
            $expired            = NULL;
            if ($kelas['bk_absen_koor'] != NULL) {
                $koor_peserta_id    = $kelas['bk_absen_koor'];
                $koor_peserta       = $this->peserta->find($koor_peserta_id);
                $koor               = $koor_peserta['nis'] . '-' . $koor_peserta['nama_peserta'];
            }
            if ($kelas['bk_absen_expired'] != NULL) {
                $expired            = shortdate_indo(substr($kelas['bk_absen_expired'], 0, 10)) . ', ' . substr($kelas['bk_absen_expired'], 11, 5) . ' WITA';
            }

            $data = [
                'title'             => 'Al-Haqq - Detail Kelas Pembinaan',
                'user'              => $user,
                'peserta_onkelas'   => $peserta_onkelas,
                'koor'              => $koor,
                'expired'           => $expired,
                'detail_kelas'      => $kelas,
                'pengajar'          => $this->bina_pengajar->pengajar_onkelas($bk_id),
                'jumlah_peserta'    => count($peserta_onkelas),
            ];
            return view('panel_admin/kelas_bina/detail', $data);
        } else {
            return redirect()->to('kelas-bina');
        }
    }

    public function detail_modal()
    {
        if ($this->request->isAJAX()) {
            $modul              = $this->request->getVar('modul');
            $bk_id              = $this->request->getVar('bk_id');
            $bina_kelas       = $this->bina_kelas->find($bk_id);
            $peserta            = NULL;
            $pengajar           = NULL;
            $koor               = NULL;

            if ($modul == 'peserta') {
                $title = 'Form Input Peserta';
                $peserta = $this->peserta->list();
            } elseif ($modul == 'pengajar') {
                $title = 'Form Input Pengjar';
                $pengajar = $this->pengajar->list();
            } elseif ($modul == 'absensi') {
                $title        = 'Form Pengaturan Absensi Kelas Pembinaan';
                $koor         = $this->bina_peserta->peserta_onkelas($bk_id);
            }

            $data = [
                'title'     => $title,
                'pengajar'  => $pengajar,
                'peserta'   => $peserta,
                'bina'    => $bina_kelas,
                'koor'      => $koor,
                'modul'     => $modul,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_bina/detail_modal', $data)
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
                'bk_name' => [
                    'label' => 'bk_name',
                    'rules' => 'required|is_unique[bina_kelas.bk_name]',
                    'errors' => [
                        'required' => 'Nama Kelas tidak boleh kosong',
                        'is_unique' => 'Nama Kelas harus unik, sudah ada yang menggunakan Nama Kelas ini',
                    ]
                ],
                'bk_angkatan' => [
                    'label' => 'bk_angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angakatan tidak boleh kosong',
                    ]
                ],
                'bj_pengajar' => [
                    'label' => 'bj_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pengajar tidak boleh kosong',
                    ]
                ],
                'bk_hari' => [
                    'label' => 'bk_hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari tidak boleh kosong',
                    ]
                ],
                'bk_waktu' => [
                    'label' => 'bk_waktu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Waktu tidak boleh kosong',
                    ]
                ],
                'bk_timezone' => [
                    'label' => 'bk_timezone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Zona Waktu tidak boleh kosong',
                    ]
                ],
                'bk_jenkel' => [
                    'label' => 'bk_jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin tidak boleh kosong',
                    ]
                ],
                'bk_tm_total' => [
                    'label' => 'bk_tm_total',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'TM Total tidak boleh kosong',
                    ]
                ],
                'bk_tm_methode' => [
                    'label' => 'bk_tm_methode',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Metode TM tidak boleh kosong',
                    ]
                ],
                'bk_status' => [
                    'label' => 'bk_status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status Kelas tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'bk_name'      => $validation->getError('bk_name'),
                        'bk_angkatan'  => $validation->getError('bk_angkatan'),
                        'bj_pengajar'  => $validation->getError('bj_pengajar'),
                        'bk_hari'      => $validation->getError('bk_hari'),
                        'bk_waktu'     => $validation->getError('bk_waktu'),
                        'bk_timezone'  => $validation->getError('bk_timezone'),
                        'bk_jenkel'    => $validation->getError('bk_jenkel'),
                        'bk_tm_total'  => $validation->getError('bk_tm_total'),
                        'bk_tm_methode' => $validation->getError('bk_tm_methode'),
                        'bk_status'    => $validation->getError('bk_status'),
                    ]
                ];
            } else {


                $this->db->transStart();
                $bina_kelas_New = [
                    'bk_name'          => strtoupper($this->request->getVar('bk_name')),
                    'bk_angkatan'      => $this->request->getVar('bk_angkatan'),
                    'bk_hari'          => $this->request->getVar('bk_hari'),
                    'bk_waktu'         => $this->request->getVar('bk_waktu'),
                    'bk_timezone'      => $this->request->getVar('bk_timezone'),
                    'bk_jenkel'        => $this->request->getVar('bk_jenkel'),
                    'bk_tm_total'      => $this->request->getVar('bk_tm_total'),
                    'bk_tm_methode'    => $this->request->getVar('bk_tm_methode'),
                    'bk_created'       => date('Y-m-d H:i:s'),
                    'bk_status'        => $this->request->getVar('bk_status'),
                    'bk_absen_status'  => '0',
                    'bk_absen_methode' => 'Mandiri',
                ];
                $this->bina_kelas->insert($bina_kelas_New);
                $bj_kelas = $this->bina_kelas->insertID();
                $pengajar     = $this->request->getPost('bj_pengajar');
                foreach ($pengajar as $item) {
                    $bina_pengajar_NEW = [
                        'bj_pengajar' => $item,
                        'bj_kelas'    => $bj_kelas,
                    ];
                    $this->bina_pengajar->insert($bina_pengajar_NEW);
                }
                $this->db->transComplete();

                $aktivitas = 'Buat Data Kelas Pembinaan Nama : ' .  $this->request->getVar('bk_name');

                if ($this->db->transStatus() === FALSE) {
                    /*--- Log ---*/
                    $this->logging('Admin', 'FAIL', $aktivitas);
                } else {
                    /*--- Log ---*/
                    $this->logging('Admin', 'BERHASIL', $aktivitas);
                }

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-bina'
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

                'bk_name' => [
                    'label' => 'bk_name',
                    'rules' => 'required|is_unique_except[bina_kelas.bk_name.bk_id.' . $this->request->getVar('bk_id') . ']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'bk_angkatan' => [
                    'label' => 'bk_angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angakatan tidak boleh kosong',
                    ]
                ],
                'bk_hari' => [
                    'label' => 'bk_hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari tidak boleh kosong',
                    ]
                ],
                'bk_waktu' => [
                    'label' => 'bk_waktu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Waktu tidak boleh kosong',
                    ]
                ],
                'bk_timezone' => [
                    'label' => 'bk_timezone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Zona Waktu tidak boleh kosong',
                    ]
                ],
                'bk_jenkel' => [
                    'label' => 'bk_jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin tidak boleh kosong',
                    ]
                ],
                'bk_tm_total' => [
                    'label' => 'bk_tm_total',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'TM Total tidak boleh kosong',
                    ]
                ],
                'bk_tm_methode' => [
                    'label' => 'bk_tm_methode',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Metode TM tidak boleh kosong',
                    ]
                ],
                'bk_status' => [
                    'label' => 'bk_status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status Kelas tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'bk_name'      => $validation->getError('bk_name'),
                        'bk_angkatan'  => $validation->getError('bk_angkatan'),
                        'bk_hari'      => $validation->getError('bk_hari'),
                        'bk_waktu'     => $validation->getError('bk_waktu'),
                        'bk_timezone'  => $validation->getError('bk_timezone'),
                        'bk_jenkel'    => $validation->getError('bk_jenkel'),
                        'bk_tm_total'  => $validation->getError('bk_tm_total'),
                        'bk_tm_methode' => $validation->getError('bk_tm_methode'),
                        'bk_status'    => $validation->getError('bk_status'),
                    ]
                ];
            } else {

                $updatedata = [
                    'bk_name'          => strtoupper($this->request->getVar('bk_name')),
                    'bk_angkatan'      => $this->request->getVar('bk_angkatan'),
                    'bk_hari'          => $this->request->getVar('bk_hari'),
                    'bk_waktu'         => $this->request->getVar('bk_waktu'),
                    'bk_timezone'      => $this->request->getVar('bk_timezone'),
                    'bk_jenkel'        => $this->request->getVar('bk_jenkel'),
                    'bk_tm_total'      => $this->request->getVar('bk_tm_total'),
                    'bk_tm_methode'    => $this->request->getVar('bk_tm_methode'),
                    'bk_status'        => $this->request->getVar('bk_status'),
                ];

                $bk_id = $this->request->getVar('bk_id');
                $this->bina_kelas->update($bk_id, $updatedata);

                // Data Log END
                $aktivitas = 'Ubah Data Kelas Pembinaan Nama : ' .  $this->request->getVar('nama_kelas');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-bina'
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
            $bk_id  = $this->request->getVar('bk_id');
            $bina = $this->bina_kelas->find($bk_id);

            if ($modul == 'peserta') {
                $peserta     = $this->request->getPost('bs_peserta');
                foreach ($peserta as $item) {
                    $bina_peserta_NEW = [
                        'bs_peserta' => $item,
                        'bs_kelas'   => $bk_id,
                        'bs_status'  => 'BELUM LULUS',
                    ];
                    $this->bina_peserta->insert($bina_peserta_NEW);
                }
                $pesan      = 'Berhasil Tambah Data Peserta';
                $aktivitas  = 'Memasukan data peserta di kelas pembinaan ' .  $bina['bk_name'];
            } elseif ($modul == 'pengajar') {
                $pengajar     = $this->request->getPost('bj_pengajar');
                foreach ($pengajar as $item) {
                    $bina_pengajar_NEW = [
                        'bj_pengajar' => $item,
                        'bj_kelas'    => $bk_id,
                    ];
                    $this->bina_pengajar->insert($bina_pengajar_NEW);
                }
                $pesan      = 'Berhasil Tambah Data Pengajar';
                $aktivitas  = 'Memasukan data pengajar di kelas pembinaan ' .  $bina['bk_name'];
            } elseif ($modul == 'absensi') {
                $metode = $this->request->getVar('bk_absen_methode');
                $koor = NULL;
                $expired = NULL;
                if ($metode == 'Perwakilan') {
                    $koor = $this->request->getVar('bk_absen_koor');
                } elseif ($metode == 'Mandiri') {
                    $expired = $this->request->getVar('bk_absen_expired');
                }
                $updatedata = [
                    'bk_absen_status'   => $this->request->getVar('bk_absen_status'),
                    'bk_absen_methode'  => $metode,
                    'bk_absen_koor'     => $koor,
                    'bk_absen_expired'  => $expired,
                ];
                $this->bina_kelas->update($bk_id, $updatedata);
                $pesan      = 'Berhasil Ganti Pengaturan Absensi';
                $aktivitas  = 'Mengubah pengaturan absensi di kelas pembinaan ' .  $bina['bk_name'];
            }

            // Data Log END
            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => '/kelas-bina/detail?id=' . $bk_id,
                    'pesan' => $pesan
                ]
            ];

            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $modul   = $this->request->getVar('modul');
            $bk_id   = $this->request->getVar('bk_id');
            $nama  = $this->request->getVar('nama');
            $bina  = $this->bina_kelas->find($bk_id);

            if ($modul == 'pengajar') {
                $bj_id = $this->request->getVar('id');
                $this->bina_pengajar->delete($bj_id);
            } elseif ($modul == 'peserta') {
                $bs_id = $this->request->getVar('id');
                $this->bina_peserta->delete($bs_id);
            }

            $aktivitas = 'Hapus ' . $modul . ' nama  : ' .  $nama . ' pada kelas ' .  $bina['bk_name'];

            if ($this->db->transStatus() === FALSE) {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            } else {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => '/kelas-bina/detail?id=' . $bk_id
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function duplicate()
    {
        if ($this->request->isAJAX()) {
            $bk_id   = $this->request->getVar('bk_id');
            $binaKl  = $this->bina_kelas->find($bk_id);

            if (!$binaKl) {
                $msg = ['error' => 'Data kelas tidak ditemukan'];
                echo json_encode($msg);
                return;
            }

            $this->db->transStart();

            $bina_kelas_New = [
                'bk_name'          => 'COPY ' . $binaKl['bk_name'],
                'bk_angkatan'      => $binaKl['bk_angkatan'],
                'bk_hari'          => $binaKl['bk_hari'],
                'bk_waktu'         => $binaKl['bk_waktu'],
                'bk_timezone'      => $binaKl['bk_timezone'],
                'bk_jenkel'        => $binaKl['bk_jenkel'],
                'bk_tm_total'      => $binaKl['bk_tm_total'],
                'bk_tm_methode'    => $binaKl['bk_tm_methode'],
                'bk_created'       => date('Y-m-d H:i:s'),
                'bk_status'        => $binaKl['bk_status'],
                'bk_absen_status'  => $binaKl['bk_absen_status'],
                'bk_absen_methode' => $binaKl['bk_absen_methode'],
            ];
            $this->bina_kelas->insert($bina_kelas_New);
            $bj_kelas = $this->bina_kelas->insertID();

            // Duplicate pengajar
            $pengajar = $this->bina_pengajar->where('bj_kelas', $binaKl['bk_id'])->findAll();
            foreach ($pengajar as $item) {
                $bina_pengajar_NEW = [
                    'bj_pengajar' => $item['bj_pengajar'], // perbaikan: ambil value dari array
                    'bj_kelas'    => $bj_kelas,
                ];
                $this->bina_pengajar->insert($bina_pengajar_NEW);
            }

            // Duplicate peserta
            $peserta = $this->bina_peserta->where('bs_kelas', $binaKl['bk_id'])->findAll();
            foreach ($peserta as $item) {
                $bina_peserta_NEW = [
                    'bs_peserta' => $item['bs_peserta'], // perbaikan: ambil value dari array
                    'bs_kelas'   => $bj_kelas, // perbaikan: gunakan ID kelas baru
                    'bs_status'  => 'BELUM LULUS',
                ];
                $this->bina_peserta->insert($bina_peserta_NEW);
            }

            $this->db->transComplete();

            $aktivitas = 'Buat Data Duplicate Kelas Pembinaan Nama : ' . $binaKl['bk_name'];

            if ($this->db->transStatus() === FALSE) {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
                $msg = ['error' => 'Gagal menduplikasi kelas'];
            } else {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
                $msg = [
                    'sukses' => [
                        'message' => 'Kelas berhasil diduplikasi',
                        'link' => 'kelas-bina'
                    ]
                ];
            }

            echo json_encode($msg);
        }
    }
}
