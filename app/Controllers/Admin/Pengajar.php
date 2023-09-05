<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pengajar extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Pengajar',
            'list'  => $this->pengajar->list(),
            'user'  => $user,
        ];
        return view('panel_admin/pengajar/index', $data);
    }

    public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'    => 'Form Input Pengajar Baru',
                'kantor'   => $this->kantor->list(),
            ];
            $msg = [
                'sukses' => view('panel_admin/pengajar/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {

            $pengajar_id = $this->request->getVar('pengajar_id');
            $pengajar =  $this->pengajar->find($pengajar_id);
            $data = [
                'title'     => 'Data Diri Pengajar',
                'pengajar'  => $pengajar,
            ];
            $msg = [
                'sukses' => view('panel_admin/pengajar/detail', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $pengajar_id    = $this->request->getVar('pengajar_id');
            $pengajar       = $this->pengajar->find($pengajar_id);
            $user_pengajar  = $this->user->find($pengajar['user_id']);
            $data = [
                'title'         => 'Ubah Data Pengajar',
                'kantor'        => $this->kantor->list(),
                'pengajar'      => $pengajar,
                'user_pengajar' => $user_pengajar
            ];
            $msg = [
                'sukses' => view('panel_admin/pengajar/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit_akun()
    {
        if ($this->request->isAJAX()) {

            $user_id    = $this->request->getVar('user_id');
            $user       = $this->user->find($user_id);
            $data = [
                'title'         => 'Ubah Data Akun Pengajar',
                'kantor'        => $this->kantor->list(),
                'user' => $user
            ];
            $msg = [
                'sukses' => view('panel_admin/pengajar/edit_akun', $data)
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
                'nama_pengajar' => [
                    'label' => 'nama_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nik_pengajar' => [
                    'label' => 'nik_pengajar',
                    'rules' => 'required|is_unique[pengajar.nik_pengajar]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'tipe_pengajar' => [
                    'label' => 'tipe_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kantor_cabang' => [
                    'label' => 'kantor_cabang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel_pengajar' => [
                    'label' => 'jenkel_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tmp_lahir_pengajar' => [
                    'label' => 'tmp_lahir_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_lahir_pengajar' => [
                    'label' => 'tgl_lahir_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'suku_bangsa' => [
                    'label' => 'suku_bangsa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_nikah' => [
                    'label' => 'status_nikah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jumlah_anak' => [
                    'label' => 'jumlah_anak',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pendidikan_pengajar' => [
                    'label' => 'pendidikan_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jurusan_pengajar' => [
                    'label' => 'jurusan_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hp_pengajar' => [
                    'label' => 'hp_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email_pengajar' => [
                    'label' => 'email_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat_pengajar' => [
                    'label' => 'alamat_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'username' => [
                    'label' => 'username',
                    'rules' => 'required|is_unique[user.username]',
                    'errors' => [
                        'required'  => '{field} tidak boleh kosong',
                        'is_unique' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'tgl_gabung_pengajar' => [
                    'label' => 'tgl_gabung_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_pengajar'           => $validation->getError('nama_pengajar'),
                        'nik_pengajar'            => $validation->getError('nik_pengajar'),
                        'tipe_pengajar'           => $validation->getError('tipe_pengajar'),
                        'kantor_cabang'           => $validation->getError('kantor_cabang'),
                        'jenkel_pengajar'         => $validation->getError('jenkel_pengajar'),
                        'tmp_lahir_pengajar'      => $validation->getError('tmp_lahir_pengajar'),
                        'tgl_lahir_pengajar'      => $validation->getError('tgl_lahir_pengajar'),
                        'suku_bangsa'             => $validation->getError('suku_bangsa'),
                        'status_nikah'            => $validation->getError('status_nikah'),
                        'jumlah_anak'             => $validation->getError('jumlah_anak'),
                        'pendidikan_pengajar'     => $validation->getError('pendidikan_pengajar'),
                        'jurusan_pengajar'        => $validation->getError('jurusan_pengajar'),
                        'hp_pengajar'             => $validation->getError('hp_pengajar'),
                        'email_pengajar'          => $validation->getError('email_pengajar'),
                        'alamat_pengajar'         => $validation->getError('alamat_pengajar'),
                        'username'                 => $validation->getError('username'),
                        'tgl_gabung_pengajar'     => $validation->getError('tgl_gabung_pengajar'),
                    ]
                ];
            } else {
                $tipe_pengajar = $this->request->getVar('tipe_pengajar');
                if ($tipe_pengajar == 'PENGAJAR') {
                    $level = 5;
                } else {
                    $level = 6;
                }
                
                $newUser    = [
					'username' 				=> $this->request->getVar('username'),
					'nama'					=> strtoupper($this->request->getVar('nama_pengajar')),
					'password'				=> (password_hash(getenv('password_default'), PASSWORD_BCRYPT)),
					'foto'					=> 'default.png',
					'level'					=> $level,
					'active'				=> 1,
				];
                $this->db->transStart();
                $this->user->insert($newUser);
                $newPengajar = [
                    'nama_pengajar'           => strtoupper($this->request->getVar('nama_pengajar')),
                    'nik_pengajar'            => $this->request->getVar('nik_pengajar'),
                    'tipe_pengajar'           => $this->request->getVar('tipe_pengajar'),
                    'asal_kantor'             => $this->request->getVar('kantor_cabang'),
                    'jenkel_pengajar'         => $this->request->getVar('jenkel_pengajar'),
                    'tmp_lahir_pengajar'      => strtoupper($this->request->getVar('tmp_lahir_pengajar')),
                    'tgl_lahir_pengajar'      => $this->request->getVar('tgl_lahir_pengajar'),
                    'suku_bangsa'             => strtoupper($this->request->getVar('suku_bangsa')),
                    'status_nikah'            => $this->request->getVar('status_nikah'),
                    'jumlah_anak'             => $this->request->getVar('jumlah_anak'),
                    'pendidikan_pengajar'     => $this->request->getVar('pendidikan_pengajar'),
                    'jurusan_pengajar'        => strtoupper($this->request->getVar('jurusan_pengajar')),
                    'hp_pengajar'             => $this->request->getVar('hp_pengajar'),
                    'email_pengajar'          => strtolower($this->request->getVar('email_pengajar')),
                    'alamat_pengajar'         => strtoupper($this->request->getVar('alamat_pengajar')),
                    'user_id'                 => $this->user->insertID(),
                    'tgl_gabung_pengajar'     => $this->request->getVar('tgl_gabung_pengajar'),
                    'foto_pengajar'           => 'default.png',
                ];

                $this->pengajar->insert($newPengajar);
                $this->db->transComplete();
                
                $aktivitas = 'Buat Data Pengajar Nama : ' .  $this->request->getVar('nama_pengajar');

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
                        'link' => 'pengajar'
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
            $user_id    = $this->request->getVar('user_id');
            $valid = $this->validate([
                'nama_pengajar' => [
                    'label' => 'nama_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nik_pengajar' => [
                    'label' => 'nik_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tipe_pengajar' => [
                    'label' => 'tipe_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kantor_cabang' => [
                    'label' => 'kantor_cabang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenkel_pengajar' => [
                    'label' => 'jenkel_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tmp_lahir_pengajar' => [
                    'label' => 'tmp_lahir_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_lahir_pengajar' => [
                    'label' => 'tgl_lahir_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'suku_bangsa' => [
                    'label' => 'suku_bangsa',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_nikah' => [
                    'label' => 'status_nikah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jumlah_anak' => [
                    'label' => 'jumlah_anak',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pendidikan_pengajar' => [
                    'label' => 'pendidikan_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jurusan_pengajar' => [
                    'label' => 'jurusan_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hp_pengajar' => [
                    'label' => 'hp_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email_pengajar' => [
                    'label' => 'email_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat_pengajar' => [
                    'label' => 'alamat_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'username' => [
                    'label' => 'username',
                    'rules' => 'required|is_unique_except[user.username.user_id.'.$user_id.']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'tgl_gabung_pengajar' => [
                    'label' => 'tgl_gabung_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_pengajar'           => $validation->getError('nama_pengajar'),
                        'nik_pengajar'            => $validation->getError('nik_pengajar'),
                        'tipe_pengajar'           => $validation->getError('tipe_pengajar'),
                        'kantor_cabang'           => $validation->getError('kantor_cabang'),
                        'jenkel_pengajar'         => $validation->getError('jenkel_pengajar'),
                        'tmp_lahir_pengajar'      => $validation->getError('tmp_lahir_pengajar'),
                        'tgl_lahir_pengajar'      => $validation->getError('tgl_lahir_pengajar'),
                        'suku_bangsa'             => $validation->getError('suku_bangsa'),
                        'status_nikah'            => $validation->getError('status_nikah'),
                        'jumlah_anak'             => $validation->getError('jumlah_anak'),
                        'pendidikan_pengajar'     => $validation->getError('pendidikan_pengajar'),
                        'jurusan_pengajar'        => $validation->getError('jurusan_pengajar'),
                        'hp_pengajar'             => $validation->getError('hp_pengajar'),
                        'email_pengajar'          => $validation->getError('email_pengajar'),
                        'alamat_pengajar'         => $validation->getError('alamat_pengajar'),
                        'username'                 => $validation->getError('username'),
                        'tgl_gabung_pengajar'     => $validation->getError('tgl_gabung_pengajar'),
                    ]
                ];
            } else {
                $update_data = [
                    'nama_pengajar'           => strtoupper($this->request->getVar('nama_pengajar')),
                    'nik_pengajar'            => $this->request->getVar('nik_pengajar'),
                    'tipe_pengajar'           => $this->request->getVar('tipe_pengajar'),
                    'asal_kantor'             => $this->request->getVar('kantor_cabang'),
                    'jenkel_pengajar'         => $this->request->getVar('jenkel_pengajar'),
                    'tmp_lahir_pengajar'      => strtoupper($this->request->getVar('tmp_lahir_pengajar')),
                    'tgl_lahir_pengajar'      => $this->request->getVar('tgl_lahir_pengajar'),
                    'suku_bangsa'             => strtoupper($this->request->getVar('suku_bangsa')),
                    'status_nikah'            => $this->request->getVar('status_nikah'),
                    'jumlah_anak'             => $this->request->getVar('jumlah_anak'),
                    'pendidikan_pengajar'     => $this->request->getVar('pendidikan_pengajar'),
                    'jurusan_pengajar'        => strtoupper($this->request->getVar('jurusan_pengajar')),
                    'hp_pengajar'             => $this->request->getVar('hp_pengajar'),
                    'email_pengajar'          => strtolower($this->request->getVar('email_pengajar')),
                    'alamat_pengajar'         => strtoupper($this->request->getVar('alamat_pengajar')),
                    'tgl_gabung_pengajar'     => $this->request->getVar('tgl_gabung_pengajar'),
                ];

                $this->db->transStart();
                $pengajar_id = $this->request->getVar('pengajar_id');
                $this->pengajar->update($pengajar_id, $update_data);
                $pengajar       = $this->pengajar->find($pengajar_id);
                $user_id        = $pengajar['user_id'];
                $username_old   = $this->request->getVar('username_old');
                $username       = $this->request->getVar('username');

                if ($username != $username_old) {
                    $updateUser = [
                        'username' => $username, 
                    ];
                    $this->user->update($user_id, $updateUser);
                }
                $this->db->transComplete();
                

                $aktivitas = 'Edit Data Pengajar Nama : ' .  $this->request->getVar('nama_pengajar');
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
                        'link' => 'pengajar'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update_akun()
    {
        if ($this->request->isAJAX()) {
            $user_id    = $this->request->getVar('user_id');
            $password   = $this->request->getVar('password');
            if (!$password) {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'username' => [
                        'label' => 'username',
                        'rules' => 'required|is_unique_except[user.username.user_id.'.$user_id.']',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                        ]
                    ],
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'username'    => $validation->getError('username'),
                        ]
                    ];
                } else {
                    $updatedata = [
                        'username' => $this->request->getVar('username'),
                        'active'   => $this->request->getVar('active'),
                    ];
    
                    $user_id = $this->request->getVar('user_id');
                    $this->db->transStart();
                    $this->user->update($user_id, $updatedata);
    
                    $aktivitas = 'Edit Data Akun Pengajar ' . $this->request->getVar('username');
    
                    if ($this->db->transStatus() === FALSE)
                    {
                        $this->db->transRollback();
                        /*--- Log ---*/
                        $this->logging('Admin', 'FAIL', $aktivitas);
                    }
                    else
                    {
                        $this->db->transComplete();
                        /*--- Log ---*/
                        $this->logging('Admin', 'BERHASIL', $aktivitas);
                    }
    
                    $msg = [
                        'sukses' => [
                            'link' => 'pengajar'
                        ]
                    ];
                }
                
               
            } else {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'username' => [
                        'label' => 'username',
                        'rules' => 'required|is_unique_except[user.username.user_id.'.$user_id.']',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                        ]
                    ],
                    'password' => [
                        'label' => 'Password',
                        'rules' => 'min_length[8]|max_length[50]',
                        'errors' => [
                            'min_length' => 'Password minimal memiliki panjang 8 character.',
                            'max_length' => 'Password maximal memiliki panjang 50 character.'
                        ]
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'username'    => $validation->getError('username'),
                            'password'    => $validation->getError('password'),
                        ]
                    ];
                } else {
    
                    $updatedata = [
                        'username'   => $this->request->getVar('username'),
                        'active'   => $this->request->getVar('active'),
                        'password' => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                    ];
    
                    $this->db->transStart();
                    $this->user->update($user_id, $updatedata);
    
                    $aktivitas = 'Edit Data Akun Pengajar (Password) ' . $this->request->getVar('username');
    
                    if ($this->db->transStatus() === FALSE)
                    {
                        $this->db->transRollback();
                        /*--- Log ---*/
                        $this->logging('Admin', 'FAIL', $aktivitas);
                    }
                    else
                    {
                        $this->db->transComplete();
                        /*--- Log ---*/
                        $this->logging('Admin', 'BERHASIL', $aktivitas);
                    }
    
                    $msg = [
                        'sukses' => [
                            'link' => 'pengajar'
                        ]
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $pengajar_id = $this->request->getVar('pengajar_id');

            $pengajar    = $this->pengajar->find($pengajar_id);
            $aktivitas   = 'Hapus Data Pengajar/Penguji : ' . $pengajar['nama_pengajar'];

            $this->db->transStart();
            $this->pengajar->delete($pengajar_id);
            $this->user->delete($pengajar['user_id']);
            $this->db->transComplete();

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
                    'link' => 'pengajar'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function deleteselect()
    {
        if ($this->request->isAJAX()) {
            $pengajar_id = $this->request->getVar('pengajar_id');
            if (count($pengajar_id) != NULL) {
                foreach ($pengajar_id as $item) {
                    $pengajar    = $this->pengajar->find($item);
                    $aktivitas  = 'Hapus Data Pengajar/Penguji : '  . $pengajar['nama_pengajar'];
                    $this->db->transStart();
                    $this->pengajar->delete($pengajar['pengajar_id']);
                    $this->user->delete($pengajar['user_id']);
                    $this->db->transComplete();

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
                }
            }

            $msg = [
                'sukses' => [
                    'link' => 'pengajar'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function import()
    {
        $valid = $this->validate([
            'file_excel' => [
                'rules' => 'uploaded[file_excel]|ext_in[file_excel,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Harap Upload',
                    'ext_in' => 'Harus File Excel!'
                ]
            ]
        ]);

        if (!$valid) {
            $this->session->setFlashdata('pesan_error', 'ERROR! Untuk Import Harap Upload File Berjenis Excel!');
            return redirect()->to('index');
        } else {

            $file   = $this->request->getFile('file_excel');
            $ext    = $file->getClientExtension();

            if ($ext == 'xls') {
                $render     = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else{
                $render     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $render->load($file);
            $sheet       = $spreadsheet->getActiveSheet()->toArray();

            $jumlaherror   = 0;
            $jumlahsukses  = 0;

            foreach ($sheet as $x => $excel) {

                //Skip row pertama - keempat (judul tabel)
                if ($x == 0) {
                    continue;
                }
                if ($x == 1) {
                    continue;
                }
                if ($x == 2) {
                    continue;
                }
                if ($x == 3) {
                    continue;
                }

                //Skip data duplikat
                $nik            = $this->pengajar->cek_duplikat_import($excel['5']);

                if ($nik != 0) {
                    $jumlaherror++;

                    if ($nik != 0) {
                        $gagal1 =  ' Karena NIK Duplikat';
                    } else{
                        $gagal1 = '';
                    }
                    
                    
                    $aktivitas1 = 'Buat Data Pengajar via Import Excel, Nama Pengajar : ' .  $excel['5'] . $gagal1;
                    /*--- Log ---*/
                    $this->logging('Admin', 'GAGAL', $aktivitas1);

                } elseif($nik == 0) {

                    if($excel['3'] == 'PENGUJI'){
                        $level = 6;
                    }else{
                        $level = 5;
                    }

                    $newUser    = [
                        'username' 				=> strtolower(str_replace(' ', '', $excel['1'])),
                        'nama'					=> strtoupper($excel['4']),
                        'password'				=> (password_hash(getenv('password_default'), PASSWORD_BCRYPT)),
                        'foto'					=> 'default.png',
                        'level'					=> $level,
                        'active'				=> 1,
                    ];
    
                    $this->db->transStart();
                    $this->user->insert($newUser);

                    $data   = [
                        'user_id'               => $this->user->insertID(),
                        'asal_kantor'           => $excel['2'],
                        'tipe_pengajar'         => $excel['3'],
                        'nama_pengajar'         => strtoupper($excel['4']),
                        'nik_pengajar'          => $excel['5'],
                        'jenkel_pengajar'       => strtoupper($excel['6']),
                        'tmp_lahir_pengajar'    => strtoupper($excel['7']),
                        'tgl_lahir_pengajar'    => $excel['8'],
                        'suku_bangsa'           => strtoupper($excel['9']),
                        'status_nikah'          => strtoupper($excel['10']),
                        'jumlah_anak'           => $excel['11'],
                        'pendidikan_pengajar'   => strtoupper($excel['12']),
                        'jurusan_pengajar'      => strtoupper($excel['13']),
                        'tgl_gabung_pengajar'   => $excel['14'],
                        'hp_pengajar'           => $excel['15'],
                        'email_pengajar'        => strtolower($excel['16']),
                        'alamat_pengajar'       => strtoupper($excel['17']),
                        'foto_pengajar'         => 'default.png',
                    ];

                    $this->pengajar->insert($data);
                    $this->db->transComplete();

                    $aktivitas = 'Buat Data Pengajar via Import Excel, Nama Pengajar : ' .  $excel['4'];

                    if ($this->db->transStatus() === FALSE)
                    {
                        /*--- Log ---*/
                        $this->logging('Admin', 'FAIL', $aktivitas);
                    }
                    else
                    {
                        $jumlahsukses++;
                        /*--- Log ---*/
                        $this->logging('Admin', 'BERHASIL', $aktivitas);
                    }
                                
                }
            }

            $this->session->setFlashdata('pesan_sukses', "Data Excel Berhasil Import = $jumlahsukses <br> Data Gagal Import = $jumlaherror");
            return redirect()->to('pengajar');

        }
    }

    public function export()
    {
        $pengajar    =  $this->pengajar->list();
        $total_row   =  count($pengajar) + 5;

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

        $judul = "DATA PENGAJAR & PENGUJI ALHAQQ - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:R1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:R2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:R4')->applyFromArray($style_up);

        $sheet->getStyle('A5:R'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'PENGAJAR ID')
            ->setCellValue('B4', 'USERNAME')
            ->setCellValue('C4', 'ASAL CABANG')
            ->setCellValue('D4', 'TIPE PENGAJAR/PENGUJI')
            ->setCellValue('E4', 'NAMA')
            ->setCellValue('F4', 'NIK')
            ->setCellValue('G4', 'JENKEL')
            ->setCellValue('H4', 'TMP. LAHIR')
            ->setCellValue('I4', 'TGL. LAHIR')
            ->setCellValue('J4', 'SUKU BANGSA')
            ->setCellValue('K4', 'STATUS NIKAH')
            ->setCellValue('L4', 'JUMLAH ANAK')
            ->setCellValue('M4', 'PENDIDIKAN')
            ->setCellValue('N4', 'JURUSAN')
            ->setCellValue('O4', 'TGL. GABUNG')
            ->setCellValue('P4', 'NO. HP')
            ->setCellValue('Q4', 'EMAIL')
            ->setCellValue('R4', 'ALAMAT');

        $columns = range('A', 'R');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;

        foreach ($pengajar as $pgjdata) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $pgjdata['pengajar_id'])
                ->setCellValue('B' . $row, $pgjdata['username'])
                ->setCellValue('C' . $row, $pgjdata['asal_kantor'])
                ->setCellValue('D' . $row, $pgjdata['tipe_pengajar'])
                ->setCellValue('E' . $row, $pgjdata['nama_pengajar'])
                ->setCellValue('F' . $row, $pgjdata['nik_pengajar'])
                ->setCellValue('G' . $row, $pgjdata['jenkel_pengajar'])
                ->setCellValue('H' . $row, $pgjdata['tmp_lahir_pengajar'])
                ->setCellValue('I' . $row, $pgjdata['tgl_lahir_pengajar'])
                ->setCellValue('J' . $row, $pgjdata['suku_bangsa'])
                ->setCellValue('K' . $row, $pgjdata['status_nikah'])
                ->setCellValue('L' . $row, $pgjdata['jumlah_anak'])
                ->setCellValue('M' . $row, $pgjdata['pendidikan_pengajar'])
                ->setCellValue('N' . $row, $pgjdata['jurusan_pengajar'])
                ->setCellValue('O' . $row, $pgjdata['tgl_gabung_pengajar'])
                ->setCellValue('P' . $row, $pgjdata['hp_pengajar'])
                ->setCellValue('Q' . $row, $pgjdata['email_pengajar'])
                ->setCellValue('R' . $row, $pgjdata['alamat_pengajar']);

            $sheet->getStyle('F' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Pengajar_Penguji-'. date('Y-m-d-His');

        $aktivitas = 'Download Data Pengajar / Penguji via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function edit_multiple()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'file_excel' => [
                'rules' => 'uploaded[file_excel]|ext_in[file_excel,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Harap Upload',
                    'ext_in' => 'Harus File Excel!'
                ]
            ]
        ]);

        if (!$valid) {
            $this->session->setFlashdata('pesan_error', 'ERROR! Untuk Import Harap Upload File Berjenis Excel!');
            return redirect()->to('index');
        } else {

            $file   = $this->request->getFile('file_excel');
            $ext    = $file->getClientExtension();

            if ($ext == 'xls') {
                $render     = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else{
                $render     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $render->load($file);
            $sheet       = $spreadsheet->getActiveSheet()->toArray();

            $jumlaherror   = 0;
            $jumlahsukses  = 0;

            foreach ($sheet as $x => $excel) {

                //Skip row pertama - keempat (judul tabel)
                if ($x == 0) {
                    continue;
                }
                if ($x == 1) {
                    continue;
                }
                if ($x == 2) {
                    continue;
                }
                if ($x == 3) {
                    continue;
                }

                //Skip data duplikat
                $pengajar_id    = $this->pengajar->cek_multiple_edit($excel['1']);

                if ($pengajar_id == 0) {
                    $jumlaherror++;

                    if ($pengajar_id == 0) {
                        $gagal1 =  ' Karena Pengajar ID Tidak Ditemukan';
                    } else{
                        $gagal1 = '';
                    }

                    $aktivitas1 = 'Edit Data Pengajar via Multiple Edit, Pengajar : ' .  $excel['5'] . ' ' . $gagal1;

                    /*--- Log ---*/
                    $this->logging('Admin', 'GAGAL', $aktivitas1);
                    
                } elseif($pengajar_id == 1) {

                    $jumlahsukses++;

                    $updatedata   = [
                        'asal_kantor'           => $excel['3'],
                        'tipe_pengajar'         => $excel['4'],
                        'nama_pengajar'         => strtoupper($excel['5']),
                        'nik_pengajar'          => $excel['6'],
                        'jenkel_pengajar'       => strtoupper($excel['7']),
                        'tmp_lahir_pengajar'    => strtoupper($excel['8']),
                        'tgl_lahir_pengajar'    => $excel['9'],
                        'suku_bangsa'           => strtoupper($excel['10']),
                        'status_nikah'          => strtoupper($excel['11']),
                        'jumlah_anak'           => $excel['12'],
                        'pendidikan_pengajar'   => strtoupper($excel['13']),
                        'jurusan_pengajar'      => strtoupper($excel['14']),
                        'tgl_gabung_pengajar'   => $excel['15'],
                        'hp_pengajar'           => $excel['16'],
                        'email_pengajar'        => strtolower($excel['17']),
                        'alamat_pengajar'       => strtoupper($excel['18']),
                        'foto_pengajar'         => 'default.png',
                    ];

                    $pgjid = $excel['1'];
                    $this->pengajar->update($pgjid, $updatedata);
                    $aktivitas = 'Edit Data Pengajar via Multiple Edit, Nama Pengajar : ' .  $excel['4'];
                    $this->logging('Admin', 'BERHASIL', $aktivitas);
                }
            }
            $this->session->setFlashdata('pesan_sukses', "Data Excel Berhasil Import = $jumlahsukses <br> Data Gagal Import = $jumlaherror");
            return redirect()->to('pengajar');
        }
        
    }
}