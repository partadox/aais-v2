<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Peserta extends BaseController
{
	public function index()
	{
		$user  = $this->userauth(); // Return Array

		$data = [
			'title' 				=> 'Peserta',
			'user'  				=> $user,
		];
		return view('panel_admin/peserta/index', $data);
	}

	public function list()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Peserta',
            ];
            $msg = [
                'data' => view('panel_admin/peserta/list', $data)
            ];
            echo json_encode($msg);
        }
    }

	public function getdata()
    {
		
		if ($this->request->isAJAX()) {
			$user  		= $this->userauth(); // Return Array
			$level_user = $user['level'];
			$lists 		= $this->peserta->get_datatables();
            $data 		= [];
            $no 		= $this->request->getPost('start');
            foreach ($lists as $list) {
                $no++;

                $row = [];
                if ($level_user == 1) {
                    
                    $hapus = "<button type=\"button\" title=\"Hapus Peserta\" class=\"btn btn-danger btn-sm\" onclick=\"hapus('" . $list->peserta_id . "','" . $list->nama_peserta . "'" ." )\">
                    <i class=\"fa fa-trash\"></i>
                    </button>";
                } else {
                    $hapus = "";
                }

                if ($level_user == 1 || $level_user == 2) {
                    $akun = "<button type=\"button\" title=\"Akun Peserta\" class=\"btn btn-info btn-sm\" onclick=\"akun('" . $list->user_id . "')\">
                    <i class=\"fa fa-user\"></i>
                    </button>";
                } else {
                    $akun  = "";
                }

                if ( $list->active == 1) {
                    $active = "<span class=\"badge badge-success\">Aktif</span>";
                } else {
                    $active = "<span class=\"badge badge-secondary\">Disable</span>";
                }
                
                
                
                $edit = "<button type=\"button\" title=\"Edit Data Peserta\" class=\"btn btn-warning btn-sm\" onclick=\"edit('" . $list->peserta_id . "')\">
                    <i class=\"fa fa-edit\"></i>
                </button>";

                $datadiri = "<button type=\"button\" title=\"Data Diri Peserta\" class=\"btn btn-secondary btn-sm\" onclick=\"datadiri('" . $list->peserta_id ."')\">
                <i class=\"fa fa-info\"></i>
            </button>";
                if($list->status_peserta == 'AKTIF'){$status_peserta = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled>AKTIF</button>";}
                elseif($list->status_peserta == 'OFF'){$status_peserta = "<button type=\"button\" class=\"btn btn-secondary btn-sm\" disabled>OFF</button>";}
                elseif($list->status_peserta == 'CUTI'){$status_peserta = "<button type=\"button\" class=\"btn btn-info btn-sm\" disabled>CUTI</button>";};

                $row[] = "<input type=\"checkbox\" name=\"peserta_id[]\" class=\"centangPesertaid\" value=\"$list->peserta_id\">" ." ".$no;
				$row[] = $list->nis;
				$row[] = $list->nama_peserta;
                $row[] = $list->peserta_id;
                $row[] = $list->nik;
                $row[] = $list->nama_kantor;
                $row[] = $list->jenkel;
                $row[] = $list->hp;
                $row[] = $list->nama_level;
                $row[] = $list->angkatan;
                $row[] = umur($list->tgl_lahir);
                $row[] = $status_peserta;
                $row[] = "ID:" . $list->user_id . "-" . $list->username . " " . $active;
                $row[] = $datadiri . " " . $edit . " " . $akun . " " . $hapus;
                $data[] = $row;
            }
            $output = [
                "recordTotal"     => $this->peserta->count_all(),
                "recordsFiltered" => $this->peserta->count_filtered(),
                "data"            => $data,
                "userLevel"       => $level_user 
            ];
            echo json_encode($output);
			
		}
        
    }

	public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'             => 'Form Input Peserta Baru',
                'level'             => $this->level->list(),
                'kantor_cabang'     => $this->kantor->list(),
                'user'              => $this->user->getnonaktif_peserta(),
            ];
            $msg = [
                'sukses' => view('panel_admin/peserta/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {

            $peserta_id     = $this->request->getVar('peserta_id');
            $peserta        =  $this->peserta->find($peserta_id);
            $data = [
                'title'     => 'Data Diri Peserta',
                'peserta'   => $peserta,
            ];
            $msg = [
                'sukses' => view('panel_admin/peserta/detail', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $peserta_id = $this->request->getVar('peserta_id');
            $peserta    = $this->peserta->find($peserta_id);
            $user       = $this->user->find($peserta['user_id']);
            $data = [
                'title'     => 'Ubah Data Peserta',
                'level'     => $this->level->list(),
                'kantor'    => $this->kantor->list(),
                'pekerjaan' => $this->pekerjaan->list(),
                'user'      => $user,
                'peserta'   => $peserta,
            ];
            $msg = [
                'sukses' => view('panel_admin/peserta/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit_akun()
    {
        if ($this->request->isAJAX()) {

            $user_id = $this->request->getVar('user_id');
            $user    = $this->user->find($user_id);
            $data = [
                'title'     => 'Ubah Data Akun Peserta',
                'user'      => $user,
            ];
            $msg = [
                'sukses' => view('panel_admin/peserta/edit_akun', $data)
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
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nis' => [
                    'label' => 'nis',
                    'rules' => 'required|is_unique[peserta.nis]',
                    'errors' => [
                        'required' => 'nis tidak boleh kosong',
                        'is_unique' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'angkatan' => [
                    'label' => 'angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'angkatan tidak boleh kosong',
                    ]
                ],
                'asal_cabang_peserta' => [
                    'label' => 'asal_cabang_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'level_peserta' => [
                    'label' => 'level_peserta',
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
                'nik' => [
                    'label' => 'nik',
                    'rules' => 'required|is_unique[peserta.nik]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'tmp_lahir' => [
                    'label' => 'tmp_lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_lahir' => [
                    'label' => 'tgl_lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pendidikan' => [
                    'label' => 'pendidikan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jurusan' => [
                    'label' => 'jurusan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_kerja' => [
                    'label' => 'status_kerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pekerjaan' => [
                    'label' => 'pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hp' => [
                    'label' => 'hp',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email' => [
                    'label' => 'email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'domisili_peserta' => [
                    'label' => 'domisili_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_peserta' => [
                    'label' => 'status_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'                  => $validation->getError('nama'),
                        'asal_cabang_peserta'   => $validation->getError('asal_cabang_peserta'),
                        'nis'                   => $validation->getError('nis'),
                        'angkatan'              => $validation->getError('angkatan'),
                        'level_peserta'         => $validation->getError('level_peserta'),
                        'jenkel'                => $validation->getError('jenkel'),
                        'nik'                   => $validation->getError('nik'),
                        'tmp_lahir'             => $validation->getError('tmp_lahir'),
                        'tgl_lahir'             => $validation->getError('tgl_lahir'),
                        'pendidikan'            => $validation->getError('pendidikan'),
                        'jurusan'               => $validation->getError('jurusan'),
                        'status_kerja'          => $validation->getError('status_kerja'),
                        'pekerjaan'             => $validation->getError('pekerjaan'),
                        'hp'                    => $validation->getError('hp'),
                        'email'                 => $validation->getError('email'),
                        'domisili_peserta'      => $validation->getError('domisili_peserta'),
                        'alamat'                => $validation->getError('alamat'),
                        'status_peserta'        => $validation->getError('status_peserta'),
                    ]
                ];
            } else {
				$newUser    = [
					'username' 				=> $this->request->getVar('nis'),
					'nama'					=> strtoupper($this->request->getVar('nama')),
					'password'				=> (password_hash(getenv('password_default'), PASSWORD_BCRYPT)),
					'foto'					=> 'default.png',
					'level'					=> 4,
					'active'				=> 1,
				];

                $this->db->transStart();
                $this->user->insert($newUser);
                $newpeserta = [
                    'nama_peserta'          => strtoupper($this->request->getVar('nama')),
                    'asal_cabang_peserta'   => $this->request->getVar('asal_cabang_peserta'),
                    'nis'                   => $this->request->getVar('nis'),
                    'angkatan'              => $this->request->getVar('angkatan'),
                    'level_peserta'         => $this->request->getVar('level_peserta'),
                    'jenkel'                => $this->request->getVar('jenkel'),
                    'nik'                   => $this->request->getVar('nik'),
                    'tmp_lahir'             => strtoupper($this->request->getVar('tmp_lahir')),
                    'tgl_lahir'             => $this->request->getVar('tgl_lahir'),
                    'pendidikan'            => $this->request->getVar('pendidikan'),
                    'jurusan'               => strtoupper($this->request->getVar('jurusan')),
                    'status_kerja'          => $this->request->getVar('status_kerja'),
                    'pekerjaan'             => $this->request->getVar('pekerjaan'),
                    'hp'                    => $this->request->getVar('hp'),
                    'email'                 => strtolower($this->request->getVar('email')),
                    'domisili_peserta'      => $this->request->getVar('domisili_peserta'),
                    'alamat'                => strtoupper($this->request->getVar('alamat')),
                    'status_peserta'        => $this->request->getVar('status_peserta'),
                    'user_id'               => $this->user->insertID(),
                    'tgl_gabung'            => date("Y-m-d"),
                    'peserta_note'          => str_replace(array("\r", "\n"), ' ',$this->request->getVar('peserta_note')),
                ];
                $this->peserta->insert($newpeserta);
                $this->db->transComplete();

                $aktivitas = 'Buat Data Peserta ' . $this->request->getVar('nama');

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
                        'link' => 'peserta'
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
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'asal_cabang_peserta' => [
                    'label' => 'asal_cabang_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'level_peserta' => [
                    'label' => 'level_peserta',
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
                'nis' => [
                    'label' => 'nis',
                    'rules' => 'required|is_unique_except[peserta.nis.peserta_id.'. $this->request->getVar('peserta_id').']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'nik' => [
                    'label' => 'nik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tmp_lahir' => [
                    'label' => 'tmp_lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_lahir' => [
                    'label' => 'tgl_lahir',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pendidikan' => [
                    'label' => 'pendidikan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jurusan' => [
                    'label' => 'jurusan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_kerja' => [
                    'label' => 'status_kerja',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'pekerjaan' => [
                    'label' => 'pekerjaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hp' => [
                    'label' => 'hp',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email' => [
                    'label' => 'email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'domisili_peserta' => [
                    'label' => 'domisili_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_peserta' => [
                    'label' => 'status_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'                  => $validation->getError('nama'),
                        'asal_cabang_peserta'   => $validation->getError('asal_cabang_peserta'),
                        'level_peserta'         => $validation->getError('level_peserta'),
                        'jenkel'                => $validation->getError('jenkel'),
                        'nis'                   => $validation->getError('nis'),
                        'nik'                   => $validation->getError('nik'),
                        'tmp_lahir'             => $validation->getError('tmp_lahir'),
                        'tgl_lahir'             => $validation->getError('tgl_lahir'),
                        'pendidikan'            => $validation->getError('pendidikan'),
                        'jurusan'               => $validation->getError('jurusan'),
                        'status_kerja'          => $validation->getError('status_kerja'),
                        'pekerjaan'             => $validation->getError('pekerjaan'),
                        'hp'                    => $validation->getError('hp'),
                        'email'                 => $validation->getError('email'),
                        'domisili_peserta'      => $validation->getError('domisili_peserta'),
                        'alamat'                => $validation->getError('alamat'),
                        'status_peserta'        => $validation->getError('status_peserta'),
                    ]
                ];
            } else {

                $updatedata = [
                    'nama_peserta'          => strtoupper($this->request->getVar('nama')),
                    'asal_cabang_peserta'   => $this->request->getVar('asal_cabang_peserta'),
                    'nis'                   => $this->request->getVar('nis'),
                    'angkatan'              => $this->request->getVar('angkatan'),
                    'level_peserta'         => $this->request->getVar('level_peserta'),
                    'jenkel'                => $this->request->getVar('jenkel'),
                    'nik'                   => $this->request->getVar('nik'),
                    'tmp_lahir'             => strtoupper($this->request->getVar('tmp_lahir')),
                    'tgl_lahir'             => $this->request->getVar('tgl_lahir'),
                    'pendidikan'            => $this->request->getVar('pendidikan'),
                    'jurusan'               => strtoupper($this->request->getVar('jurusan')),
                    'status_kerja'          => $this->request->getVar('status_kerja'),
                    'pekerjaan'             => $this->request->getVar('pekerjaan'),
                    'hp'                    => $this->request->getVar('hp'),
                    'email'                 => strtolower($this->request->getVar('email')),
                    'domisili_peserta'      => $this->request->getVar('domisili_peserta'),
                    'alamat'                => strtoupper($this->request->getVar('alamat')),
                    'status_peserta'        => $this->request->getVar('status_peserta'),
                    'peserta_note'          => str_replace(array("\r", "\n"), ' ',$this->request->getVar('peserta_note')),
                ];

                $peserta_id = $this->request->getVar('peserta_id');
                $this->db->transStart();
                $this->peserta->update($peserta_id, $updatedata);
                $this->db->transComplete();

                $aktivitas = 'Edit Data Peserta ' . $this->request->getVar('nama');

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
                        'link' => 'peserta'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update_akun()
    {
        if ($this->request->isAJAX()) {
            $password   = $this->request->getVar('password');
            if (!$password) {
                $updatedata = [
                    'active'   => $this->request->getVar('active'),
                ];

                $user_id = $this->request->getVar('user_id');
                $this->db->transStart();
                $this->user->update($user_id, $updatedata);

                $aktivitas = 'Edit Data Akun Peserta ' . $this->request->getVar('nis');

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
                        'link' => 'peserta'
                    ]
                ];
            } else {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
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
                            'password'                  => $validation->getError('password'),
                        ]
                    ];
                } else {
    
                    $updatedata = [
                        'active'   => $this->request->getVar('active'),
                        'password' => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                    ];
    
                    $user_id = $this->request->getVar('user_id');
                    $this->db->transStart();
                    $this->user->update($user_id, $updatedata);
    
                    $aktivitas = 'Edit Data Akun Peserta (Password) ' . $this->request->getVar('nis');
    
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
                            'link' => 'peserta'
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

            $peserta_id = $this->request->getVar('peserta_id');
            $peserta    = $this->peserta->find($peserta_id);
            $aktivitas  = 'Hapus Data Peserta : ' .  $peserta['nis'] . ' ' . $peserta['nama_peserta'];

            $this->db->transStart();
            $this->peserta->delete($peserta_id);
            $this->user->delete($peserta['user_id']);
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
                    'link' => 'peserta'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function deleteselect()
    {
        if ($this->request->isAJAX()) {
            $peserta_id = $this->request->getVar('peserta_id');
            if (count($peserta_id) != NULL) {
                foreach ($peserta_id as $item) {
                    $peserta    = $this->peserta->find($item);
                    $aktivitas  = 'Hapus Data Peserta : ' .  $peserta['nis'] . ' ' . $peserta['nama_peserta'];
                    $this->db->transStart();
                    $this->peserta->delete($peserta['peserta_id']);
                    $this->user->delete($peserta['user_id']);
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
            //var_dump($peserta);
            $msg = [
                'sukses' => [
                    'link' => 'peserta'
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

                //Cek Duplikat Nis
                $nis            = $this->peserta->cek_duplikat_import($excel['3']);
                //Cek Data User ada
                // $user           = $this->user->cek_user_ada($excel['1']); 
                //Cek Duplikat User
                // $duplikat_user  = $this->peserta->cek_duplikat_user($excel['1']);
                
                //Validasi Setelah Meet tgl 30-06-2022

                //1. Cek Angkatan is numerik
                $cek_angkatan = is_numeric($excel['2']);

                //2a. Cek NIK is numerik
                $cek_nik = is_numeric($excel['5']);
                //2b. Cek NIK berjumlah 16 digits
                $cek2_nik = strlen((string)$excel['5']);
                if ($cek2_nik == "16") {
                    $cek_nik_digit = true;
                } else {
                    $cek_nik_digit = false;
                }

                //3. Cek Level is numerik
                $cek_level = is_numeric($excel['6']);

                //4. Cek Status Peserta harus AKTIF/OFF/CUTI
                if ($excel['7'] == "AKTIF" || $excel['7'] == "OFF" || $excel['7'] == "CUTI") {
                    $cek_status_peserta = true;
                } else {
                    $cek_status_peserta = false;
                }

                //5. Cek asal cabang is numerik
                $cek_cabang = is_numeric($excel['8']);

                //6. Cek format tgl lahir YYYY-MM-DD
                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$excel['10'])) {
                    $cek_tgl_lahir = true;
                } else {
                    $cek_tgl_lahir = false;
                }

                //7. Cek Jenis Kelamin
                if ($excel['11'] == "IKHWAN" || $excel['11'] == "AKHWAT") {
                    $cek_jenkel = true;
                } else {
                    $cek_jenkel = false;
                }

                //8. Cek pendidikan
                if ($excel['12'] == "SD" || $excel['12'] == "SLTP" || $excel['12'] == "SLTA" || $excel['12'] == "DIPLOMA" || $excel['12'] == "SARJANA (S1)" || $excel['12'] == "MAGISTER (S2)" || $excel['12'] == "DOKTOR (S3)" || $excel['12'] == "TIDAK DIKETAHUI") {
                    $cek_pendidikan = true;
                } else {
                    $cek_pendidikan = false;
                }

                //9. Status Pekerjaan
                if ($excel['14'] == "1" || $excel['14'] == "0") {
                    $cek_status_pekerjaan = true;
                } else {
                    $cek_status_pekerjaan = false;
                }

                //10. Pekerjaan
                if ($excel['15'] == "WIRASWASTA" || $excel['15'] == "PEGAWAI SWASTA" || $excel['15'] == "PEMERINTAH/PNS" || $excel['15'] == "BUMN" || $excel['15'] == "USAHA/DAGANG" || $excel['15'] == "KEAMANAN/MILITER/POLISI" || $excel['15'] == "PERBANKAN/KEUANGAN" || $excel['15'] == "PENDIDIKAN" || $excel['15'] == "OLAHRAGA/ATLET" || $excel['15'] == "KESENIAN/ARTIS" || $excel['15'] == "KEAGAMAAN/MAJELIS" || $excel['15'] == "PELAJAR/MAHASISWA" || $excel['15'] == "KESEHATAN" || $excel['15'] == "KELUARGA/RUMAH TANGGA" || $excel['15'] == "FREELANCE"  || $excel['15'] == "LAINNYA" || $excel['15'] == "PENSIUNAN" || $excel['15'] == "TIDAK DIKETAHUI") {
                    $cek_pekerjaan = true;
                } else {
                    $cek_pekerjaan = false;
                }

                //11. Cek Domisili
                if ($excel['16'] == "BALIKPAPAN" || $excel['16'] == "LUAR BALIKPAPAN") {
                    $cek_domisili = true;
                } else {
                    $cek_domisili = false;
                }

                //12. Cek format tgl gabung YYYY-MM-DD
                if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$excel['20'])) {
                    $cek_tgl_gabung = true;
                } else {
                    $cek_tgl_gabung = false;
                }

                //13. Cek No HP Awal harus 62 (Nomor Indonesia)
                $cek2_hp = substr($excel['18'], 0, 2);
                if ($cek2_hp == "62") {
                    $cek_hp = true;
                } else {
                    $cek_hp = false;
                }


                if ($nis != 0 
                    
                    || $cek_angkatan == false
                    || $cek_nik == false
                    || $cek_nik_digit == false
                    || $cek_level == false
                    || $cek_status_peserta == false
                    || $cek_cabang == false
                    || $cek_tgl_lahir == false
                    || $cek_jenkel == false
                    || $cek_pendidikan == false
                    || $cek_status_pekerjaan == false
                    || $cek_pekerjaan == false
                    || $cek_domisili == false
                    || $cek_tgl_gabung == false
                    || $cek_hp = false) {
                    $jumlaherror++;
                    if ($nis != 0) {
                        $gagal1 =  ' NIS Duplikat';
                    } else{
                        $gagal1 = '';
                    }
                    
                    // if ($user != 1) {
                    //     $gagal2 = ', User ID Tidak Ditemukan';
                    // } else{
                    //     $gagal2 ='';
                    // }
                    
                    // if ($duplikat_user != 0) {
                    //     $gagal3 =  ', User ID Duplikat';
                    // } else{
                    //     $gagal3 = '';
                    // }

                    
                    if ($cek_angkatan == false) {
                       $gagal4 = ', Penulisan Angkatan Tidak Sesuai Format';
                    } else {
                        $gagal4 = '';
                    }

                    if ($cek_nik == false) {
                        $gagal5 = ', Format NIK Tidak Numerik';
                    } else {
                        $gagal5 = '';
                    }

                    if ($cek_nik_digit == false) {
                        $gagal6 = ', NIK Tidak Berdigit 16';
                    } else {
                        $gagal6 = '';
                    }

                    if ($cek_level == false) {
                        $gagal7 = ', Level Tidak Numerik';
                    } else {
                        $gagal7 = '';
                    }

                    if ($cek_status_peserta == false) {
                        $gagal8 = ', Karena Status Peserta Tidak Sesuai Pilihan AKTIF/OFF/CUTI';
                    } else {
                        $gagal8 = '';
                    }

                    if ($cek_cabang == false) {
                        $gagal9 = ', Karena Level Tidak Numerik';
                    } else {
                        $gagal9 = '';
                    }

                    if ($cek_tgl_lahir == false) {
                        $gagal10 = ', Karena Tanggal Lahir Tidak Sesuai Format Tanggal (Harap Perhatikan di bar value excel bukan ditampilan kolom. Format harus kolom harus text dan penulisan YYYY-MM-DD)';
                    } else {
                        $gagal10 = '';
                    }

                    if ($cek_pendidikan == false) {
                        $gagal11 = ', Karena Pendidikan Tidak Sesuai Pilihan'; 
                    } else {
                        $gagal11 = '';
                    }

                    if ($cek_status_pekerjaan == false) {
                        $gagal12 = ', Karena Status Bekerja Tidak Numerik';
                    } else {
                        $gagal12 = '';
                    }
                    
                    if ($cek_pekerjaan == false) {
                        $gagal13 = ', Karena Pekerjaan Tidak Sesuai Pilihan';
                    } else {
                        $gagal13 = '';
                    }

                    if ($cek_domisili == false) {
                        $gagal14 = ', Karena Domisili Tidak BALIKPAPAN/LUAR BALIKPAPAN';
                    } else {
                        $gagal14 = '';
                    }

                    if ($cek_tgl_gabung == false) {
                        $gagal15 = ', Karena Tgl Gabung Tidak Sesuai Format Tanggal';
                    } else {
                        $gagal15 = '';
                    }

                    if ($cek_hp == false) {
                        $gagal16 = ', Karena No HP Tidak Berawalan 62';
                    } else {
                        $gagal16 = '';
                    }

                    if ($cek_jenkel == false) {
                        $gagal17 = ', Karena Penulisan Jenis Kelamin Harus IKHWAN/AKHWAT';
                    } else {
                        $gagal17 = '';
                    }

                    $aktivitas1 = 'Buat Data Peserta via Import Excel, Peserta : '  . $excel['3'] . ' - ' .  $excel['4'] . $gagal1 . $gagal4 . $gagal5 . $gagal6 . $gagal7 . $gagal8 . $gagal9 . $gagal10 . $gagal11 . $gagal12 . $gagal13 . $gagal14 . $gagal15 . $gagal16 . $gagal17;

                     /*--- Log ---*/
                     $this->logging('Admin', 'GAGAL', $aktivitas1);

                } elseif($nis == 0 
                    || $cek_angkatan == true
                    || $cek_nik == true
                    || $cek_nik_digit == true
                    || $cek_level == true
                    || $cek_status_peserta == true
                    || $cek_cabang == true
                    || $cek_tgl_lahir == true
                    || $cek_status_peserta == true
                    || $cek_pendidikan == true
                    || $cek_status_pekerjaan == true
                    || $cek_pekerjaan == true
                    || $cek_domisili == true
                    || $cek_tgl_gabung == true
                    || $cek_hp = true) {

                    $newUser    = [
                        'username' 				=> $excel['3'],
                        'nama'					=> strtoupper($excel['4']),
                        'password'				=> (password_hash(getenv('password_default'), PASSWORD_BCRYPT)),
                        'foto'					=> 'default.png',
                        'level'					=> 4,
                        'active'				=> 1,
                    ];
    
                    $this->db->transStart();
                    $this->user->insert($newUser);

                    $data   = [
                        'user_id'               => $this->user->insertID(),
                        'angkatan'              => $excel['2'],
                        'nis'                   => $excel['3'],
                        'nama_peserta'          => strtoupper($excel['4']),
                        'nik'                   => $excel['5'],
                        'level_peserta'         => $excel['6'],
                        'status_peserta'        => strtoupper($excel['7']),
                        'asal_cabang_peserta'   => $excel['8'],
                        'tmp_lahir'             => strtoupper($excel['9']),
                        'tgl_lahir'             => $excel['10'],
                        'jenkel'                => strtoupper($excel['11']),
                        'pendidikan'            => strtoupper($excel['12']),
                        'jurusan'               => strtoupper($excel['13']),
                        'status_kerja'          => $excel['14'],
                        'pekerjaan'             => strtoupper($excel['15']),
                        'domisili_peserta'      => strtoupper($excel['16']),
                        'alamat'                => strtoupper($excel['17']),
                        'hp'                    => $excel['18'],
                        'email'                 => strtolower($excel['19']),
                        'tgl_gabung'            => $excel['20'],
                        'peserta_note'          => $excel['21'],
                    ];

                    $this->peserta->insert($data);
                    $this->db->transComplete();

                    $aktivitas = 'Buat Data Peserta via Import Excel, Nama Peserta : ' .  $excel['4'];

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
            return redirect()->to('peserta');
        }
    }

    public function export()
    {
        $peserta    =  $this->peserta->list();
        $total_row  =  count($peserta) + 5;

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

        $judul = "DATA PESERTA ALHAQQ - ACADEMIC ALHAQQ INFORMATION SYSTEM";
        $tgl   = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:V1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:V2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:V4')->applyFromArray($style_up);

        $sheet->getStyle('v4')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A5:V'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'PESERTA ID')
            ->setCellValue('B4', 'USER ID')
            ->setCellValue('C4', 'ANGKATAN')
            ->setCellValue('D4', 'NIS')
            ->setCellValue('E4', 'NAMA PESERTA')
            ->setCellValue('F4', 'NIK')
            ->setCellValue('G4', 'LEVEL')
            ->setCellValue('H4', 'STATUS')
            ->setCellValue('I4', 'ASAL CABANG')
            ->setCellValue('J4', 'TMP. LAHIR')
            ->setCellValue('K4', 'TGL. LAHIR')
            ->setCellValue('L4', 'JENKEL')
            ->setCellValue('M4', 'PENDIDIKAN')
            ->setCellValue('N4', 'JURUSAN')
            ->setCellValue('O4', 'STATUS KERJA')
            ->setCellValue('P4', 'PEKERJAAN')
            ->setCellValue('Q4', 'DOMISILI')
            ->setCellValue('R4', 'ALAMAT')
            ->setCellValue('S4', 'HP')
            ->setCellValue('T4', 'EMAIL')
            ->setCellValue('U4', 'TGL GABUNG')
            ->setCellValue('V4', 'CATATAN');

        $columns = range('A', 'U');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(35);
        $row = 5;

        foreach ($peserta as $psrtdata) {

            $sheet->getStyle('F' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->getStyle('S' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $psrtdata['peserta_id'])
                ->setCellValue('B' . $row, $psrtdata['user_id'])
                ->setCellValue('C' . $row, $psrtdata['angkatan'])
                ->setCellValue('D' . $row, $psrtdata['nis'])
                ->setCellValue('E' . $row, $psrtdata['nama_peserta'])
                ->setCellValue('F' . $row,  "'". $psrtdata['nik'])
                ->setCellValue('G' . $row, $psrtdata['level_peserta'])
                ->setCellValue('H' . $row, $psrtdata['status_peserta'])
                ->setCellValue('I' . $row, $psrtdata['asal_cabang_peserta'])
                ->setCellValue('J' . $row, $psrtdata['tmp_lahir'])
                ->setCellValue('K' . $row, $psrtdata['tgl_lahir'])
                ->setCellValue('L' . $row, $psrtdata['jenkel'])
                ->setCellValue('M' . $row, $psrtdata['pendidikan'])
                ->setCellValue('N' . $row, $psrtdata['jurusan'])
                ->setCellValue('O' . $row, $psrtdata['status_kerja'])
                ->setCellValue('P' . $row, $psrtdata['pekerjaan'])
                ->setCellValue('Q' . $row, $psrtdata['domisili_peserta'])
                ->setCellValue('R' . $row, $psrtdata['alamat'])
                ->setCellValue('S' . $row, $psrtdata['hp'])
                ->setCellValue('T' . $row, $psrtdata['email'])
                ->setCellValue('U' . $row, $psrtdata['tgl_gabung'])
                ->setCellValue('V' . $row, $psrtdata['peserta_note']);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Peserta-'. date('Y-m-d-His');

        $aktivitas =  'Download Data Peserta via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function edit_multiple()
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
                $peserta_id    = $this->peserta->cek_multiple_edit($excel['1']);
                //Cek Duplikat Nis
                $nis           = $this->peserta->cek_duplikat_import($excel['4']);
                

                if ($peserta_id == 0 || $nis != 1 ) {
                    $jumlaherror++;

                    if ($nis != 1) {
                        $gagal1 =  ' NIS Duplikat';
                    } else{
                        $gagal1 = '';
                    }

                    if ($peserta_id == 0) {
                        $gagal4 =  ', Peserta ID Tidak Ditemukan';
                    } else{
                        $gagal4 = '';
                    }
                    $aktivitas = 'Edit Data Peserta via Multiple Edit, Peserta : ' .  $excel['4'] . ' - ' .  $excel['5'] . ' ' . $gagal1 . $gagal4;
                    $this->logging('Admin', 'GAGAL', $aktivitas);

                    
                    //Data Log END
                } elseif($peserta_id == 1 && $nis == 1 ) {

                    $jumlahsukses++;

                    //$nik = substr($excel['6'], 1);

                    $updatedata   = [
                        'angkatan'              => $excel['3'],
                        'nis'                   => $excel['4'],
                        'nama_peserta'          => strtoupper($excel['5']),
                        'nik'                   => $excel['6'],
                        'level_peserta'         => $excel['7'],
                        'status_peserta'        => strtoupper($excel['8']),
                        'asal_cabang_peserta'   => $excel['9'],
                        'tmp_lahir'             => strtoupper($excel['10']),
                        'tgl_lahir'             => $excel['11'],
                        'jenkel'                => strtoupper($excel['12']),
                        'pendidikan'            => strtoupper($excel['13']),
                        'jurusan'               => strtoupper($excel['14']),
                        'status_kerja'          => $excel['15'],
                        'pekerjaan'             => strtoupper($excel['16']),
                        'domisili_peserta'      => strtoupper($excel['17']),
                        'alamat'                => strtoupper($excel['18']),
                        'hp'                    => $excel['19'],
                        'email'                 => strtolower($excel['20']),
                        'tgl_gabung'            => $excel['21'],
                        'peserta_note'          => $excel['22'],
                    ];

                    // Update Data Peserta
                    $psrtid = $excel['1'];
                    $this->peserta->update($psrtid, $updatedata);

                    $aktivitas = 'Edit Data Peserta via Multiple Edit, Peserta : '  .  $excel['4'] . ' | ' .  $excel['5'];

                    $this->logging('Admin', 'BERHASIL', $aktivitas);
                }
            }
            

            $this->session->setFlashdata('pesan_sukses', "Data Berhasil Diedit = $jumlahsukses <br> Data Gagal Diedit = $jumlaherror");
            return redirect()->to('peserta');
        }
        
    }

}