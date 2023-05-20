<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Level extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Manajemen Level',
            'list'  => $this->level->list(),
            'user'  => $user,
        ];

        return view('panel_admin/level/index', $data); 
    }

    public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Input Level Baru',
            ];
            $msg = [
                'sukses' => view('panel_admin/level/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $peserta_level_id   = $this->request->getVar('peserta_level_id');
            $peserta_level      = $this->level->find($peserta_level_id);
            $data = [
                'title'         => 'Ubah Data Level',
                'peserta_level' => $peserta_level
            ];
            $msg = [
                'sukses' => view('panel_admin/level/edit', $data)
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
                'nama_level' => [
                    'label' => 'nama_level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'urutan_level' => [
                //     'label' => 'urutan_level',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                'tampil_ondaftar' => [
                    'label' => 'tampil_ondaftar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_level'        => $validation->getError('nama_level'),
                        // 'urutan_level'      => $validation->getError('urutan_level'),
                        'tampil_ondaftar'   => $validation->getError('tampil_ondaftar'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_level'        => strtoupper($this->request->getVar('nama_level')),
                    // 'urutan_level'      => $this->request->getVar('urutan_level'),
                    'tampil_ondaftar'   => $this->request->getVar('tampil_ondaftar'),
                ];

                $this->level->insert($simpandata);
                $aktivitas = 'Buat Data Level Nama : ' .  $this->request->getVar('nama_level');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'level'
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
                'nama_level' => [
                    'label' => 'nama_level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'urutan_level' => [
                //     'label' => 'urutan_level',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                'tampil_ondaftar' => [
                    'label' => 'tampil_ondaftar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_level'        => $validation->getError('nama_level'),
                        // 'urutan_level'      => $validation->getError('urutan_level'),
                        'tampil_ondaftar'   => $validation->getError('tampil_ondaftar'),
                    ]
                ];
            } else {

                $updatedata = [
                    'nama_level'        => strtoupper($this->request->getVar('nama_level')),
                    // 'urutan_level'      => $this->request->getVar('urutan_level'),
                    'tampil_ondaftar'   => $this->request->getVar('tampil_ondaftar'),
                ];

                $peserta_level_id = $this->request->getVar('peserta_level_id');
                $this->level->update($peserta_level_id, $updatedata);
                $aktivitas = 'Ubah Data Level Nama : ' .  $this->request->getVar('nama_level');
                $this->logging('Admin', 'BERHASIL', $aktivitas);
                

                $msg = [
                    'sukses' => [
                        'link' => 'level'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }
}