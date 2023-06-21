<?php
namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;

class Biodata extends BaseController
{
    public function index()
    {
        $user    = $this->userauth();
        $user_id = $user['user_id'];

        //Get data pengajar id
        $get_pengajar_id = $this->pengajar->get_pengajar_id($user_id);
        $pengajar_id = $get_pengajar_id->pengajar_id;

        $pengajar =  $this->pengajar->find($pengajar_id);

        $data = [
            'title'                 => 'Manajemen Data Diri dan Akun Pengajar',
            'user'                  => $user,
            'user_id'               => $user_id,
            'pengajar_id'           => $pengajar['pengajar_id'],
            'nama_pengajar'         => $pengajar['nama_pengajar'],
            'nik_pengajar'          => $pengajar['nik_pengajar'],
            'jenkel_pengajar'       => $pengajar['jenkel_pengajar'],
            'tmp_lahir_pengajar'    => $pengajar['tmp_lahir_pengajar'],
            'tgl_lahir_pengajar'    => $pengajar['tgl_lahir_pengajar'],
            'suku_bangsa'           => $pengajar['suku_bangsa'],
            'status_nikah'          => $pengajar['status_nikah'],
            'jumlah_anak'           => $pengajar['jumlah_anak'],
            'pendidikan_pengajar'   => $pengajar['pendidikan_pengajar'],
            'jurusan_pengajar'      => $pengajar['jurusan_pengajar'],
            'alamat_pengajar'       => $pengajar['alamat_pengajar'],
            'hp_pengajar'           => $pengajar['hp_pengajar'],
            'email_pengajar'        => $pengajar['email_pengajar'],
        ];
        return view('panel_pengajar/biodata/index', $data);
    }

    public function edit_password()
    {
        if ($this->request->isAJAX()) {

            $user_id = $this->request->getVar('user_id');
            $user =  $this->user->find($user_id);
            $data = [
                'title'      => 'Ubah Password',
                'user_id'    => $user['user_id'],
                'level'      => $user['level'],
            ];
            $msg = [
                'sukses' => view('panel_pengajar/biodata/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nik_pengajar' => [
                    'label' => 'nik_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nama_pengajar' => [
                    'label' => 'nama_pengajar',
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
                'jenkel_pengajar' => [
                    'label' => 'jenkel_pengajar',
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
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nik_pengajar'               => $validation->getError('nik_pengajar'),
                        'nama_pengajar'              => $validation->getError('nama_pengajar'),
                        'tmp_lahir_pengajar'         => $validation->getError('tmp_lahir_pengajar'),
                        'tgl_lahir_pengajar'         => $validation->getError('tgl_lahir_pengajar'),
                        'jenkel_pengajar'            => $validation->getError('jenkel_pengajar'),
                        'suku_bangsa'                => $validation->getError('suku_bangsa'),
                        'status_nikah'               => $validation->getError('status_nikah'),
                        'jumlah_anak'                => $validation->getError('jumlah_anak'),
                        'pendidikan_pengajar'        => $validation->getError('pendidikan_pengajar'),
                        'jurusan_pengajar'           => $validation->getError('jurusan_pengajar'),
                        'hp_pengajar'                => $validation->getError('hp_pengajar'),
                        'email_pengajar'             => $validation->getError('email_pengajar'),
                        'alamat_pengajar'            => $validation->getError('alamat_pengajar'),
                    ]
                ];
            } else {

                $update_data = [
                    // 'user_id'                        => $this->request->getVar('user_id'),
                    'nik_pengajar'                   => $this->request->getVar('nik_pengajar'),
                    'nama_pengajar'                  => strtoupper($this->request->getVar('nama_pengajar')),
                    'tmp_lahir_pengajar'             => strtoupper($this->request->getVar('tmp_lahir_pengajar')),
                    'tgl_lahir_pengajar'             => $this->request->getVar('tgl_lahir_pengajar'),
                    'jenkel_pengajar'                => $this->request->getVar('jenkel_pengajar'),
                    'suku_bangsa'                    => strtoupper($this->request->getVar('suku_bangsa')),
                    'status_nikah'                   => $this->request->getVar('status_nikah'),
                    'jumlah_anak'                    => $this->request->getVar('jumlah_anak'),
                    'pendidikan_pengajar'            => $this->request->getVar('pendidikan_pengajar'),
                    'jurusan_pengajar'               => strtoupper($this->request->getVar('jurusan_pengajar')),
                    'hp_pengajar'                    => $this->request->getVar('hp_pengajar'),
                    'email_pengajar'                 => strtolower($this->request->getVar('email_pengajar')),
                    'alamat_pengajar'                => strtoupper($this->request->getVar('alamat_pengajar')),
                ];

                $pengajar_id = $this->request->getVar('pengajar_id');
                $this->pengajar->update($pengajar_id, $update_data);

                $aktivitas = "Pengajar mengubah data pada biodatanya";
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => '/biodata-pengajar'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update_password()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'password' => [
                    'label' => 'password',
                    'rules' => 'required|min_length[8]|max_length[50]',
                    'errors' => [
                        'required'   => '{field} tidak boleh kosong',
                        'min_length' => 'Password minimal memiliki panjang 8 character.',
                        'max_length' => 'Password maximal memiliki panjang 50 character.'
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'password'   => $validation->getError('password'),
                    ]
                ];
            } else {

                $update_data = [
                    'password'  => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                ];

                $user_id = $this->request->getVar('user_id');
                $this->user->update($user_id, $update_data);

                $redirect = 'biodata-pengajar';

                $aktivitas = "Pengajar mengubah akun passwordnya";
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => $redirect
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }
}