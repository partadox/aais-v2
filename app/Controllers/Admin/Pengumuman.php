<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pengumuman extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Management Pengumuman',
            'list'  => $this->pengumuman->list(),
            'user'  => $user,
        ];
        return view('panel_admin/pengumuman/index', $data);
    }

    public function input()
    {
        if ($this->request->isAJAX()) {
            $user  = $this->userauth();
            $data = [
                'title' => 'Form Input Pengumuman Baru',
                'user'  => $user,
            ];
            $msg = [
                'sukses' => view('panel_admin/pengumuman/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $pengumuman_id = $this->request->getVar('pengumuman_id');
            $pengumuman    =  $this->pengumuman->find($pengumuman_id);
            $data = [
                'title'      => 'Ubah Data Pengumuman',
                'pengumuman' => $pengumuman,
            ];
            $msg = [
                'sukses' => view('panel_admin/pengumuman/edit', $data)
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
                'title' => [
                    'label' => 'Judul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status' => [
                    'label' => 'Status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'type' => [
                    'label' => 'Kepada',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'title'  => $validation->getError('title'),
                        'status' => $validation->getError('status'),
                        'type'   => $validation->getError('type'),
                    ]
                ];
            } else {
                $simpandata = [
                    'pengumuman_title'       => $this->request->getVar('title'),
                    'pengumuman_status'      => $this->request->getVar('status'),
                    'pengumuman_type'        => $this->request->getVar('type'),
                    'pengumuman_content'     => $this->request->getVar('content'),
                    'pengumuman_create'      => date('Y-m-d H:i:s'),
                    'pengumuman_by'          => $this->request->getVar('by'),
                ];

                $this->pengumuman->insert($simpandata);

                $aktivitas = 'Buat Data Pengumuman, Judul : ' . $this->request->getVar('title');

                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'pengumuman'
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
            $pengumuman_id    = $this->request->getVar('pengumuman_id');

            $valid  = $this->validate([
                'title' => [
                    'label' => 'Judul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status' => [
                    'label' => 'Status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'type' => [
                    'label' => 'Kepada',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'title'    => $validation->getError('title'),
                        'status'   => $validation->getError('status'),
                        'type'     => $validation->getError('type'),
                    ]
                ];
            } else {

                $update_data = [
                    'pengumuman_title'       => $this->request->getVar('title'),
                    'pengumuman_status'      => $this->request->getVar('status'),
                    'pengumuman_type'        => $this->request->getVar('type'),
                    'pengumuman_content'     => $this->request->getVar('content'),
                ];
                
                $this->pengumuman->update($pengumuman_id, $update_data);

                $aktivitas = 'Edit Data Pengumuman, Judul : ' .  $this->request->getVar('username');
                $this->logging('Admin', 'BERHASIL', $aktivitas);


                $msg = [
                    'sukses' => [
                        'link' => 'pengumuman'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $pengumuman_id = $this->request->getVar('pengumuman_id');
            $pengumuman    = $this->pengumuman->find($pengumuman_id);
            $aktivitas = 'Hapus Data Pengumuman, Judul: ' .  $pengumuman['pengumuman_title'];

            $this->pengumuman->delete($pengumuman_id);

            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => 'pengumuman'
                ]
            ];
            echo json_encode($msg);
        }
    }
}