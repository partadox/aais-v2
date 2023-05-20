<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Bank extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Pengaturan Rekening Bank',
            'list'  => $this->bank->list(),
            'user'  => $user,
        ];

        return view('panel_admin/bank/index', $data); 
    }

    public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Input Data Rekening Bank Baru',
            ];
            $msg = [
                'sukses' => view('panel_admin/bank/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $bank_id = $this->request->getVar('bank_id');
            $bank    =  $this->bank->find($bank_id);
            $data = [
                'title' => 'Ubah Rekening Bank',
                'bank'  => $bank
            ];
            $msg = [
                'sukses' => view('panel_admin/bank/edit', $data)
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
                'nama_bank' => [
                    'label' => 'nama_bank',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'rekening_bank' => [
                    'label' => 'rekening_bank',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'atas_nama_bank' => [
                    'label' => 'atas_nama_bank',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_bank'      => $validation->getError('nama_bank'),
                        'rekening_bank'  => $validation->getError('rekening_bank'),
                        'atas_nama_bank' => $validation->getError('atas_nama_bank'),
                    ]
                ];
            } else {
                $simpandata = [
                    'nama_bank'      => strtoupper($this->request->getVar('nama_bank')),
                    'rekening_bank'  => $this->request->getVar('rekening_bank'),
                    'atas_nama_bank' => strtoupper($this->request->getVar('atas_nama_bank')),
                ];

                $this->bank->insert($simpandata);
                $aktivitas = 'Buat Data Bank Rek. : ' .  $this->request->getVar('rekening_bank');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'bank'
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
                'nama_bank' => [
                    'label' => 'nama_bank',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'rekening_bank' => [
                    'label' => 'rekening_bank',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'atas_nama_bank' => [
                    'label' => 'atas_nama_bank',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_bank'      => $validation->getError('nama_bank'),
                        'rekening_bank'  => $validation->getError('rekening_bank'),
                        'atas_nama_bank' => $validation->getError('atas_nama_bank'),
                    ]
                ];
            } else {
                $update_data = [
                    'nama_bank'      => strtoupper($this->request->getVar('nama_bank')),
                    'rekening_bank'  => $this->request->getVar('rekening_bank'),
                    'atas_nama_bank' => strtoupper($this->request->getVar('atas_nama_bank')),
                ];

                $bank_id = $this->request->getVar('bank_id');
                $this->bank->update($bank_id, $update_data);
                $aktivitas = 'Ubah Data Bank Rek. : ' .  $this->request->getVar('rekening_bank');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'bank'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $bank_id = $this->request->getVar('bank_id');
            $bank    = $this->bank->find($bank_id);

            $aktivitas = 'Hapus Data Bank : ' .  $bank['nama_bank'] .'-'.$bank['rekening_bank'];

            $this->bank->delete($bank_id);

            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => 'bank'
                ]
            ];
            echo json_encode($msg);
        }
    }
}