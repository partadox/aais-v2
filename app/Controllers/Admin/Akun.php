<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Akun extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Management Akun Admin',
            'list'  => $this->user->list_admin(),
            'user'  => $user,
        ];
        return view('panel_admin/akun/index', $data);
    }

    public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Input Akun Admin Baru',
            ];
            $msg = [
                'sukses' => view('panel_admin/akun/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $user_id = $this->request->getVar('user_id');
            $user    =  $this->user->find($user_id);
            $data = [
                'title'=> 'Ubah Data Akun Admin',
                'user' => $user,
            ];
            $msg = [
                'sukses' => view('panel_admin/akun/edit', $data)
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
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[user.username]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => 'sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'level' => [
                    'label' => 'level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'username'  => $validation->getError('username'),
                        'nama'      => $validation->getError('nama'),
                        'level'     => $validation->getError('level'),
                        'password'  => $validation->getError('password'),
                    ]
                ];
            } else {
                $simpandata = [
                    'username'     =>  str_replace(' ', '',strtolower($this->request->getVar('username'))),
                    'nama'         => strtoupper($this->request->getVar('nama')),
                    'password'     => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                    'level'        => $this->request->getVar('level'),
                    'foto'         => 'default.png',
                    'active'       => '1',
                ];

                $this->user->insert($simpandata);

                $aktivitas = 'Buat Data Akun Admin Nama : ' . $this->request->getVar('nama');

                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'akun'
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

            $valid  = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'level' => [
                    'label' => 'level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'active' => [
                    'label' => 'active',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique_except[user.username.user_id.'.$user_id.']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique_except' => 'sudah ada admin yang menggunakan {field} ini',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'       => $validation->getError('nama'),
                        'level'      => $validation->getError('level'),
                        'active'     => $validation->getError('active'),
                        'username'   => $validation->getError('username'),
                    ]
                ];
            } else {

                $password = $this->request->getVar('password');

                if ($password == NULL) {
                    $update_data = [
                        'nama'      => strtoupper($this->request->getVar('nama')),
                        'username'  =>  str_replace(' ', '',strtolower($this->request->getVar('username'))),
                        'level'     => $this->request->getVar('level'),
                        'active'    => $this->request->getVar('active'),
                    ];
                } else {
                    $update_data = [
                        'nama'      => strtoupper($this->request->getVar('nama')),
                        'username'  =>  str_replace(' ', '',strtolower($this->request->getVar('username'))),
                        'level'     => $this->request->getVar('level'),
                        'active'    => $this->request->getVar('active'),
                        'password'  => (password_hash($this->request->getVar('password'), PASSWORD_BCRYPT)),
                    ];
                }
                
                $this->user->update($user_id, $update_data);

                $aktivitas = 'Edit Data Akun Admin Username : ' .  $this->request->getVar('username');
                $this->logging('Admin', 'BERHASIL', $aktivitas);


                $msg = [
                    'sukses' => [
                        'link' => 'akun'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $user_id = $this->request->getVar('user_id');
            $user    = $this->user->find($user_id);
            $aktivitas = 'Hapus Data Akun Admin Username: ' .  $user['username'];

            $this->user->delete($user_id);

            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => 'akun'
                ]
            ];
            echo json_encode($msg);
        }
    }

}