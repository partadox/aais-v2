<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class KelasReg extends BaseController
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
        
        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_kelas         = $this->kelas->list_2nd($angkatan);
        $data = [
            'title'             => 'Manajamen Kelas Regular Angkatan ' . $angkatan,
            'list'              => $list_kelas,
            'list_angkatan'     => $list_angkatan,
            'angkatan_pilih'    => $angkatan,
            'user'              => $user,
        ];
        return view('panel_admin/kelas_regular/index', $data);
    }

    public function input()
    {
        if ($this->request->isAJAX()) {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;

            $data = [
                'title'     => 'Form Input Kelas Baru',
                'program'   => $this->program->list_aktif(),
                'pengajar'  => $this->pengajar->list(),
                'level'     => $this->level->list(),
                'angkatan'  => $angkatan,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_regular/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $kelas_id   = $this->request->getVar('kelas_id');
            $kelas      =  $this->kelas->find($kelas_id);
            $data = [
                'title'     => 'Ubah Data Kelas '.$kelas['nama_kelas'],
                'program'   => $this->program->list_aktif(),
                'pengajar'  => $this->pengajar->list(),
                'level'     => $this->level->list(),
                'kelas'     => $kelas,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_regular/edit', $data)
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
            $kelas_id           = $params['id'];
            $peserta_onkelas    = $this->peserta_kelas->peserta_onkelas($kelas_id);
            $kelas              = $this->kelas->find($kelas_id);
            $data = [
                'title'             => 'Al-Haqq - Peserta Kelas',
                'user'              => $user,
                'list'              => $this->kelas->list(),
                'peserta_onkelas'   => $peserta_onkelas,
                'detail_kelas'      => $kelas,
                'pengajar'          => $this->pengajar->find($kelas['pengajar_id']),
                'jumlah_peserta'    => count($peserta_onkelas),
            ];
            return view('panel_admin/kelas_regular/detail', $data);
        } else {
            return redirect()->to('kelas-regular');
        }
    }

    public function input_setting()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Pengaturan Pembukaan Pendaftaran Program',
                'konfig'  => $this->konfigurasi->list()
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_regular/setting', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function input_move()
    {
        if ($this->request->isAJAX()) {

            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;

            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');
            $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
            

            //get id peserta
            $peserta_id        = $peserta_kelas['data_peserta_id'];
            $data_peserta      = $this->peserta->find($peserta_id );
            $list_kelas        = $this->kelas->list_2nd($angkatan); 

            $data = [
                'title'             => 'Pindah Kelas Peserta',
                'peserta_kelas_id'  => $peserta_kelas_id,
                'kelas'             => $list_kelas,
                'data_kelas_id'     => $peserta_kelas['data_kelas_id'],
                'nama_peserta'      => $data_peserta['nama_peserta'],
                'nis'               => $data_peserta['nis'],
                'domisili'          => $data_peserta['domisili_peserta']
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_regular/move', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function atur_absensi()
    {
        if ($this->request->isAJAX()) {

            $kelas_id  = $this->request->getVar('kelas_id');
            $kelas     = $this->kelas->find($kelas_id);
            if ($kelas['metode_absen'] == NULL) {
                $metode = 'Pengajar';
            } else{
                $metode = $kelas['metode_absen'];
            }
            $data = [
                'title' => 'Pengaturan Absensi Mandiri',
                'kelas' => $kelas,
                'metode'=> $metode,
            ];

            $msg = [
                'sukses' => view('panel_admin/kelas_regular/atur_absensi', $data)
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
                'program_id' => [
                    'label' => 'program_id',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nama_kelas' => [
                    'label' => 'nama_kelas',
                    'rules' => 'required|is_unique[program_kelas.nama_kelas]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'angkatan_kelas' => [
                    'label' => 'angkatan_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pengajar_id' => [
                    'label' => 'pengajar_id',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hari_kelas' => [
                    'label' => 'hari_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_kelas' => [
                    'label' => 'waktu_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'zona_waktu_kelas' => [
                    'label' => 'zona_waktu_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'peserta_level' => [
                    'label' => 'peserta_level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel' => [
                    'label' => 'jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'status_kerja' => [
                //     'label' => 'status_kerja',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                'kouta' => [
                    'label' => 'kouta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'metode_kelas' => [
                    'label' => 'metode_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_kelas' => [
                    'label' => 'status_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'program_id'        => $validation->getError('program_id'),
                        'nama_kelas'        => $validation->getError('nama_kelas'),
                        'angkatan_kelas'    => $validation->getError('angkatan_kelas'),
                        'pengajar_id'       => $validation->getError('pengajar_id'),
                        'hari_kelas'        => $validation->getError('hari_kelas'),
                        'waktu_kelas'       => $validation->getError('waktu_kelas'),
                        'zona_waktu_kelas'  => $validation->getError('zona_waktu_kelas'),
                        'peserta_level'     => $validation->getError('peserta_level'),
                        'jenkel'            => $validation->getError('jenkel'),
                        // 'status_kerja'      => $validation->getError('status_kerja'),
                        'kouta'             => $validation->getError('kouta'),
                        'metode_kelas'      => $validation->getError('metode_kelas'),
                        'status_kelas'      => $validation->getError('status_kelas'),
                    ]
                ];
            } else {
                
                $hari_kelas     = $this->request->getVar('hari_kelas');

                if($hari_kelas == 'SABTU' || $hari_kelas == 'MINGGU'){
                    $status_kerja   = '1';
                } else{
                    $status_kerja   = '0';
                }

                $wag = $this->request->getVar('wag');
                if ($wag == "") {
                    $wag == NULL;
                }

                //Create data absen pengajar
                $dataabsen = [
                    'bckp_absen_pengajar_id'      => $this->request->getVar('pengajar_id'),
                    'bckp_absen_pengajar_kelas'   => strtoupper($this->request->getVar('nama_kelas')),
                ];

                $this->db->transStart();
                $this->absen_pengajar->insert($dataabsen);
                $simpandata = [
                    'program_id'            => $this->request->getVar('program_id'),
                    'nama_kelas'            => strtoupper($this->request->getVar('nama_kelas')),
                    'angkatan_kelas'        => $this->request->getVar('angkatan_kelas'),
                    'pengajar_id'           => $this->request->getVar('pengajar_id'),
                    'data_absen_pengajar'   => $this->absen_pengajar->insertID(),
                    'hari_kelas'            => $this->request->getVar('hari_kelas'),
                    'waktu_kelas'           => $this->request->getVar('waktu_kelas'),
                    'zona_waktu_kelas'      => $this->request->getVar('zona_waktu_kelas'),
                    'peserta_level'         => $this->request->getVar('peserta_level'),
                    'jenkel'                => $this->request->getVar('jenkel'),
                    'status_kerja'          => $status_kerja,
                    'kouta'                 => $this->request->getVar('kouta'),
                    'sisa_kouta'            => $this->request->getVar('kouta'),
                    'jumlah_peserta'        => '0',
                    'metode_kelas'          => $this->request->getVar('metode_kelas'),
                    'status_kelas'          => $this->request->getVar('status_kelas'),
                    'wag'                   => $wag,
                ];
                $this->kelas->insert($simpandata);
                $this->db->transComplete();
                
                $aktivitas = 'Buat Data Kelas Nama : ' .  $this->request->getVar('nama_kelas');

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
                        'link' => 'kelas-regular'
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
                'program_id' => [
                    'label' => 'program_id',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nama_kelas' => [
                    'label' => 'nama_kelas',
                    'rules' => 'required|is_unique_except[program_kelas.nama_kelas.kelas_id.'. $this->request->getVar('kelas_id').']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'angkatan_kelas' => [
                    'label' => 'angkatan_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pengajar_id' => [
                    'label' => 'pengajar_id',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hari_kelas' => [
                    'label' => 'hari_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_kelas' => [
                    'label' => 'waktu_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'zona_waktu_kelas' => [
                    'label' => 'zona_waktu_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'peserta_level' => [
                    'label' => 'peserta_level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel' => [
                    'label' => 'jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kouta' => [
                    'label' => 'kouta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'metode_kelas' => [
                    'label' => 'metode_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_kelas' => [
                    'label' => 'status_kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'program_id'        => $validation->getError('program_id'),
                        'nama_kelas'        => $validation->getError('nama_kelas'),
                        'angkatan_kelas'    => $validation->getError('angkatan_kelas'),
                        'pengajar_id'       => $validation->getError('pengajar_id'),
                        'hari_kelas'        => $validation->getError('hari_kelas'),
                        'waktu_kelas'       => $validation->getError('waktu_kelas'),
                        'zona_waktu_kelas'  => $validation->getError('zona_waktu_kelas'),
                        'peserta_level'     => $validation->getError('peserta_level'),
                        'jenkel'            => $validation->getError('jenkel'),
                        'kouta'             => $validation->getError('kouta'),
                        'metode_kelas'      => $validation->getError('metode_kelas'),
                        'status_kelas'      => $validation->getError('status_kelas'),
                    ]
                ];
            } else {

                $hari_kelas     = $this->request->getVar('hari_kelas');

                if($hari_kelas == 'SABTU' || $hari_kelas == 'MINGGU'){
                    $status_kerja   = '1';
                } else{
                    $status_kerja   = '0';
                }

                $wag = $this->request->getVar('wag');
                if ($wag == "") {
                    $wag == NULL;
                }

                $penguji_id = $this->request->getVar('penguji_id');
                if ($penguji_id == "" || $penguji_id == 'kosong') {
                    $penguji_id = NULL; 
                } else {
                    $penguji_id = $penguji_id;
                }
                

                $updatedata = [
                    'program_id'        => $this->request->getVar('program_id'),
                    'nama_kelas'        => strtoupper($this->request->getVar('nama_kelas')),
                    'angkatan_kelas'    => $this->request->getVar('angkatan_kelas'),
                    'pengajar_id'       => $this->request->getVar('pengajar_id'),
                    'hari_kelas'        => $this->request->getVar('hari_kelas'),
                    'waktu_kelas'       => $this->request->getVar('waktu_kelas'),
                    'zona_waktu_kelas'  => $this->request->getVar('zona_waktu_kelas'),
                    'peserta_level'     => $this->request->getVar('peserta_level'),
                    'jenkel'            => $this->request->getVar('jenkel'),
                    'status_kerja'      => $status_kerja,
                    'kouta'             => $this->request->getVar('kouta'),
                    // 'sisa_kouta'        => $this->request->getVar('sisa_kouta'),
                    'metode_kelas'      => $this->request->getVar('metode_kelas'),
                    'status_kelas'      => $this->request->getVar('status_kelas'),
                    'penguji_id'        => $penguji_id,
                    'wag'               => $wag,
                ];

                $kelas_id = $this->request->getVar('kelas_id');
                $this->kelas->update($kelas_id, $updatedata);

                // Data Log END
                $aktivitas = 'Ubah Data Kelas Nama : ' .  $this->request->getVar('nama_kelas');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-regular'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function save_setting()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'angkatan_kuliah' => [
                    'label' => 'angkatan_kuliah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_pendaftaran' => [
                    'label' => 'status_pendaftaran',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'filter_domisili' => [
                    'label' => 'filter_domisili',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'angkatan_kuliah'        => $validation->getError('angkatan_kuliah'),
                        'status_pendaftaran'     => $validation->getError('status_pendaftaran'),
                        'filter_domisili'        => $validation->getError('filter_domisili'),
                    ]
                ];
            } else {

                $angkatan_kuliah = $this->request->getVar('angkatan_kuliah');
                $status_daftar   = $this->request->getVar('status_pendaftaran');
                $filter_domisili = $this->request->getVar('filter_domisili');

                $data = [
                    'angkatan_kuliah'            => $angkatan_kuliah,
                    'status_pendaftaran'         => $status_daftar,
                    'filter_domisili'            => $filter_domisili, 
                ];

                $konfig_id = 1;

                $this->konfigurasi->update($konfig_id, $data);
                $aktivitas = 'Ubah Pengaturan Pendaftarn Menjadi : ' .   $status_daftar . ' | Angkatan Perkuliahan : ' . $angkatan_kuliah . ' | Filter Domisili - Metode Kuliah : ' . $filter_domisili;
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-regular'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function move()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'data_kelas_id' => [
                    'label' => 'data_kelas_id',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'data_kelas_id'    => $validation->getError('data_kelas_id'),
                    ]
                ];
            } else {

                $tujuan_kelas_id    = $this->request->getVar('data_kelas_id');
                $asal_kelas_id      = $this->request->getVar('asal_kelas_id');

                $updatedata = [
                    'data_kelas_id'        => $tujuan_kelas_id,
                ];

                $peserta_kelas_id = $this->request->getVar('peserta_kelas_id');
                $this->peserta_kelas->update($peserta_kelas_id, $updatedata);

                //3. START - Get Nama peserta, Nama kelas asal dan nama kelas tujuan
                $find_kelas_asal_nama       = $this->kelas->find($asal_kelas_id);
                $nama_kelas_asal            = $find_kelas_asal_nama['nama_kelas'];
                $find_kelas_tujuan_nama     = $this->kelas->find($tujuan_kelas_id);
                $nama_kelas_tujuan          = $find_kelas_tujuan_nama['nama_kelas'];
                $find_peserta_id            = $this->peserta_kelas->find($peserta_kelas_id);
                $get_peserta_id             = $find_peserta_id['data_peserta_id'];
                $peserta_data               = $this->peserta->find($get_peserta_id);
                $nama_peserta               = $peserta_data['nama_peserta'];
                //END - Get Nama peserta, Nama kelas asal dan nama kelas tujuan

                $aktivitas                  = 'Pindah Peserta Nama : ' . $nama_peserta . ' Dipindahkan Ke Kelas ' . $nama_kelas_tujuan   . ' Dari Kelas ' . $nama_kelas_asal;
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'detail?id='. $asal_kelas_id
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function delete_peserta()
    {
        if ($this->request->isAJAX()) {

            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');

            //get data kelas peserta
            $get_kelas_peserta  = $this->peserta_kelas->get_kelas_peserta($peserta_kelas_id);
            $kelas_id           = $get_kelas_peserta->data_kelas_id;

            //Data Peserta Kelas - untuk delete data ujian dan data absen
            $peserta_kelas_data = $this->peserta_kelas->find($peserta_kelas_id);
            $data_absen         = $peserta_kelas_data['data_absen'];
            $data_ujian         = $peserta_kelas_data['data_ujian'];

            //Untuk penulisan di log
            $get_peserta_id    = $this->peserta_kelas->get_peserta_id($peserta_kelas_id);
            $peserta_id        = $get_peserta_id->data_peserta_id;
            $data_peserta      = $this->peserta->find($peserta_id);
            $data_kelas        = $this->kelas->find($kelas_id);
            $nama_peserta      = $data_peserta['nama_peserta'];
            $nama_kelas        = $data_kelas['nama_kelas'];

            //hapus data peserta_kelas, ujian dan absen
            $this->db->transStart();
            $this->peserta_kelas->delete($peserta_kelas_id);
            $this->absen_peserta->delete($data_absen);
            $this->ujian->delete($data_ujian);
            $this->db->transComplete();

            $aktivitas = 'Hapus Peserta Kelas, Nama Peserta : ' .  $nama_peserta . ' Pada Kelas ' .  $nama_kelas;

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
                    'link' => 'detail?id='. $kelas_id 
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function export()
    {
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

        $kelas      =  $this->kelas->list_2nd($angkatan);
        $total_row  = count($kelas)+5;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $styleColumn = [
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ];

        $style_up = [
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'D9D9D9',
                ],
                'endColor' => [
                    'argb' => 'D9D9D9',
                ],
            ],        
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $isi_tengah = [
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $judul = "DATA KELAS ALHAQQ ANGAKATAN ".$angkatan." - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:N2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:N4')->applyFromArray($style_up);

        $sheet->getStyle('A5:N'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NAMA KELAS')
            ->setCellValue('B4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('C4', 'PROGRAM')
            ->setCellValue('D4', 'HARI')
            ->setCellValue('E4', 'JAM')
            ->setCellValue('F4', 'PENGAJAR')
            ->setCellValue('G4', 'METODE TATAP MUKA')
            ->setCellValue('H4', 'LEVEL')
            ->setCellValue('I4', 'JENKEL')
            ->setCellValue('J4', 'KUOTA DAFTAR')
            ->setCellValue('K4', 'SISA KUOTA')
            ->setCellValue('L4', 'JUMLAH PESERTA')
            ->setCellValue('M4', 'STATUS KELAS')
            ->setCellValue('N4', 'KELAS ID');

            $columns = range('A', 'N');
            foreach ($columns as $column) {
                $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

        $row = 5;

        foreach ($kelas as $data) {

            $sheet->getStyle('F' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->getStyle('S' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['nama_kelas'])
                ->setCellValue('B' . $row, $data['angkatan_kelas'])
                ->setCellValue('C' . $row, $data['nama_program'])
                ->setCellValue('D' . $row, $data['hari_kelas'])
                ->setCellValue('E' . $row, $data['waktu_kelas'] . ' ' . $data['zona_waktu_kelas'])
                ->setCellValue('F' . $row, $data['nama_pengajar'])
                ->setCellValue('G' . $row, $data['metode_kelas'])
                ->setCellValue('H' . $row, $data['nama_level'])
                ->setCellValue('I' . $row, $data['jenkel'])
                ->setCellValue('J' . $row, $data['kouta'])
                ->setCellValue('K' . $row, $data['kouta']-$data['peserta_kelas_count'])
                ->setCellValue('L' . $row, $data['peserta_kelas_count'])
                ->setCellValue('M' . $row, $data['status_kelas'])
                ->setCellValue('N' . $row, $data['kelas_id']);

            $row++;
        }

        $writer     = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename   =  'Data-Kelas-'. date('Y-m-d-His');
        $aktivitas  = 'Download Data Kelas via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');
        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    
    public function update_atur_absensi()
    {
        $kelas_id       = $this->request->getVar('kelas_id');
        $kelas          = $this->kelas->find($kelas_id);
        $metode_absen   = $this->request->getVar('metode_absen');
        $tm_absen       = $this->request->getVar('tm_absen');
        $expired_absen  = $this->request->getVar('expired_absen');

        if ($metode_absen == "Mandiri") {
            if ($this->request->isAJAX()) {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'expired_absen_waktu' => [
                        'label' => 'Waktu expired absen mandiri',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'expired_absen_waktu'  => $validation->getError('expired_absen_waktu'),
                        ]
                    ];
                } else {
                    $updatedata = [
                        'metode_absen'  => $metode_absen,
                        'tm_absen'      => $tm_absen,
                        'expired_absen' => $expired_absen,
                    ];
    
                    $this->kelas->update($kelas_id, $updatedata);
    
                    $aktivitas = 'Mengubah Metode Absen Menjadi Mandiri di Kelas' . $kelas['nama_kelas'] . ' sampai ' . $expired_absen ;
    
                    $this->logging('Admin', 'BERHASIL', $aktivitas);
    
                    $msg = [
                        'sukses' => [
                            'link' => '/kelas-regular/detail?id='.$kelas_id
                        ]
                    ];
                }
                
            }
        }

        echo json_encode($msg);
        
    }

    public function update_atur_absensi_config()
    {
        $kelas_id           = $this->request->getVar('kelas_id');
        $kelas              = $this->kelas->find($kelas_id);
        $config_absen       = $this->request->getVar('config_absen');
        if ($config_absen == 1) {
            $config_absen_txt   = 'TERLIHAT';
            $config_absen       = 1;
        } else {
            $config_absen_txt   = 'TIDAK TERLIHAT';
            $config_absen       = NULL;
        }
        

        if ($this->request->isAJAX()) {
            $updatedata = [
                'config_absen'  => $config_absen,
            ];

            $this->kelas->update($kelas_id, $updatedata);

            $aktivitas = 'Mengubah Pengaturan Metode Absen Menjadi Mandiri di Kelas' . $kelas['nama_kelas'] . ' Dapat Dilihat Pengajar = ' . $config_absen_txt ;

            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => '/kelas-regular/detail?id='.$kelas_id
                ]
            ];
        }

        echo json_encode($msg);
        
    }
}