<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Kantor extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Kantor & Cabang',
            'list'  => $this->kantor->list(),
            'user'  => $user,
        ];

        return view('panel_admin/kantor/index', $data); 
    }

    public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Input Data Kantor / Cabang Baru',
            ];
            $msg = [
                'sukses' => view('panel_admin/kantor/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $kantor_id = $this->request->getVar('kantor_id');
            $kantor    =  $this->kantor->find($kantor_id);
            $data = [
                'title'     => 'Ubah Data Kantor / Cabang',
                'kantor'    => $kantor,
            ];
            $msg = [
                'sukses' => view('panel_admin/kantor/edit', $data)
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
                'nama_kantor' => [
                    'label' => 'nama_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kota_kantor' => [
                    'label' => 'kota_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat_kantor' => [
                    'label' => 'alamat_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kontak_kantor' => [
                    'label' => 'kontak_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kantor'   => $validation->getError('nama_kantor'),
                        'kota_kantor'   => $validation->getError('kota_kantor'),
                        'alamat_kantor' => $validation->getError('alamat_kantor'),
                        'kontak_kantor' => $validation->getError('kontak_kantor'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_kantor'   => strtoupper($this->request->getVar('nama_kantor')),
                    'kota_kantor'   => strtoupper($this->request->getVar('kota_kantor')),
                    'alamat_kantor' => strtoupper($this->request->getVar('alamat_kantor')),
                    'kontak_kantor' => $this->request->getVar('kontak_kantor'),
                ];

                $this->kantor->insert($simpandata);
                $aktivitas = 'Buat Data Kantor / Cabang Nama : ' .  $this->request->getVar('nama_kantor');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'kantor'
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
                'nama_kantor' => [
                    'label' => 'nama_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kota_kantor' => [
                    'label' => 'kota_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat_kantor' => [
                    'label' => 'alamat_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kontak_kantor' => [
                    'label' => 'kontak_kantor',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kantor'   => $validation->getError('nama_kantor'),
                        'kota_kantor'   => $validation->getError('kota_kantor'),
                        'alamat_kantor' => $validation->getError('alamat_kantor'),
                        'kontak_kantor' => $validation->getError('kontak_kantor'),
                    ]
                ];
            } else {
                $update_data = [
                    'nama_kantor'   => strtoupper($this->request->getVar('nama_kantor')),
                    'kota_kantor'   => strtoupper($this->request->getVar('kota_kantor')),
                    'alamat_kantor' => strtoupper($this->request->getVar('alamat_kantor')),
                    'kontak_kantor' => $this->request->getVar('kontak_kantor'),
                ];

                $kantor_id = $this->request->getVar('kantor_id');
                $this->kantor->update($kantor_id, $update_data);
                $aktivitas = 'Ubah Data Kantor / Cabang Nama : ' .  $this->request->getVar('nama_kantor');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'kantor'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

}