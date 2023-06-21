<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Biodata extends BaseController
{
    public function index()
    {
        $user = $this->userauth();
        $user_id = $user['user_id'];

        //Get data peserta id
        $get_peserta_id = $this->peserta->get_peserta_id($user_id);
        $peserta_id = $get_peserta_id->peserta_id;

        $peserta =  $this->peserta->find($peserta_id);

        $data = [
            'title'                 => 'Manajemen Data Diri dan Akun Peserta',
            'user'                  => $user,
            'user_id'               => $user_id,
            'peserta_id'            => $peserta['peserta_id'],
            'nama'                  => $peserta['nama_peserta'],
            'nis'                   => $peserta['nis'],
            'nik'                   => $peserta['nik'],
            'jenkel'                => $peserta['jenkel'],
            'tmp_lahir'             => $peserta['tmp_lahir'],
            'tgl_lahir'             => $peserta['tgl_lahir'],
            'pendidikan'            => $peserta['pendidikan'],
            'jurusan'               => $peserta['jurusan'],
            'status_kerja'          => $peserta['status_kerja'],
            'pekerjaan'             => $peserta['pekerjaan'],
            'domisili_peserta'      => $peserta['domisili_peserta'],
            'alamat'                => $peserta['alamat'],
            'hp'                    => $peserta['hp'],
            'email'                 => $peserta['email'],
        ];
        return view('panel_peserta/biodata/index', $data);
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
                'sukses' => view('panel_peserta/biodata/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nik' => [
                    'label' => 'nik',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nama' => [
                    'label' => 'Nama',
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
                'jenkel' => [
                    'label' => 'jenkel',
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
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nik'               => $validation->getError('nik'),
                        'nama'              => $validation->getError('nama'),
                        'tmp_lahir'         => $validation->getError('tmp_lahir'),
                        'tgl_lahir'         => $validation->getError('tgl_lahir'),
                        'jenkel'            => $validation->getError('jenkel'),
                        'pendidikan'        => $validation->getError('pendidikan'),
                        'jurusan'           => $validation->getError('jurusan'),
                        'status_kerja'      => $validation->getError('status_kerja'),
                        'pekerjaan'         => $validation->getError('pekerjaan'),
                        'hp'                => $validation->getError('hp'),
                        'email'             => $validation->getError('email'),
                        'domisili_peserta'  => $validation->getError('domisili_peserta'),
                        'alamat'            => $validation->getError('alamat'),
                    ]
                ];
            } else {

                $update_data = [
                    'user_id'               => $this->request->getVar('user_id'),
                    'nik'                   => $this->request->getVar('nik'),
                    'nama_peserta'          => strtoupper($this->request->getVar('nama')),
                    'tmp_lahir'             => strtoupper($this->request->getVar('tmp_lahir')),
                    'tgl_lahir'             => $this->request->getVar('tgl_lahir'),
                    'jenkel'                => $this->request->getVar('jenkel'),
                    'pendidikan'            => $this->request->getVar('pendidikan'),
                    'jurusan'               => strtoupper($this->request->getVar('jurusan')),
                    'status_kerja'          => $this->request->getVar('status_kerja'),
                    'pekerjaan'             => $this->request->getVar('pekerjaan'),
                    'hp'                    => $this->request->getVar('hp'),
                    'email'                 => strtolower($this->request->getVar('email')),
                    'domisili_peserta'      => $this->request->getVar('domisili_peserta'),
                    'alamat'                => strtoupper($this->request->getVar('alamat')),
                ];

                $peserta_id = $this->request->getVar('peserta_id');
                $this->peserta->update($peserta_id, $update_data);

                $aktivitas = "Peserta mengubah biodata dirinya";
                $this->logging('Peserta', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'biodata-peserta'
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

                $redirect = 'biodata-peserta';

                $aktivitas = "Peserta mengubah akun passwordnya";
                $this->logging('Peserta', 'BERHASIL', $aktivitas);

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