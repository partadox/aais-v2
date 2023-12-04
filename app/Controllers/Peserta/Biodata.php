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