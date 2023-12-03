<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ProgramNonReg extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Manajemen Program Non-Reguler',
            'list'  => $this->program->list_non_reguler(),
            'user'  => $user,
        ];

        return view('panel_admin/program_nonreg/index', $data); 
    }

    public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Input Program Non-Reguler Baru',
                'tipe'    => $this->nonreg_tipe->findAll(),
            ];
            $msg = [
                'sukses' => view('panel_admin/program_nonreg/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $program_id = $this->request->getVar('program_id');
            $program    =  $this->program->find($program_id);
            $data = [
                'title'     => 'Ubah Data Program Non-Reguler',
                'program'    => $program,
                'tipe'    => $this->nonreg_tipe->findAll(),
            ];
            $msg = [
                'sukses' => view('panel_admin/program_nonreg/edit', $data)
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
                'nama_program' => [
                    'label' => 'nama_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenis_program' => [
                    'label' => 'jenis_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'biaya_program' => [
                //     'label' => 'biaya_program',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                'biaya_bulanan' => [
                    'label' => 'biaya_bulanan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'biaya_daftar' => [
                    'label' => 'biaya_daftar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'biaya_modul' => [
                    'label' => 'biaya_modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_program' => [
                    'label' => 'status_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_program'   => $validation->getError('nama_program'),
                        'jenis_program'  => $validation->getError('jenis_program'),
                        // 'biaya_program'  => $validation->getError('biaya_program'),
                        'biaya_bulanan'  => $validation->getError('biaya_bulanan'),
                        'biaya_daftar'   => $validation->getError('biaya_daftar'),
                        'biaya_modul'    => $validation->getError('biaya_modul'),
                        'status_program' => $validation->getError('status_program'),
                    ]
                ];
            } else {

                //Get data nominal rupiah
                // $get_biaya_program  = $this->request->getVar('biaya_program');
                $get_biaya_daftar   = $this->request->getVar('biaya_daftar');
                $get_biaya_bulanan  = $this->request->getVar('biaya_bulanan');
                $get_biaya_modul    = $this->request->getVar('biaya_modul');

                //Replace Rp. and thousand separtor from input
                // $biaya_program   = str_replace(str_split('Rp. .'), '', $get_biaya_program);
                $biaya_daftar    = str_replace(str_split('Rp. .'), '', $get_biaya_daftar);
                $biaya_bulanan   = str_replace(str_split('Rp. .'), '', $get_biaya_bulanan);
                $biaya_modul     = str_replace(str_split('Rp. .'), '', $get_biaya_modul);

                $simpandata = [
                    'nama_program'    => strtoupper($this->request->getVar('nama_program')),
                    'jenis_program'   => $this->request->getVar('jenis_program'),
                    'kategori_program'=> $this->request->getVar('kategori_program'),
                    'biaya_program'   => 0,
                    'biaya_bulanan'   => $biaya_bulanan,
                    'biaya_daftar'    => $biaya_daftar,
                    'biaya_modul'     => $biaya_modul, 
                    'status_program'  => $this->request->getVar('status_program'),
                ];

                $this->program->insert($simpandata);
                $aktivitas = 'Buat Data Program Nonreg Nama : ' .  $this->request->getVar('nama_program');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'program-nonreg'
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
                'nama_program' => [
                    'label' => 'nama_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jenis_program' => [
                    'label' => 'jenis_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'biaya_program' => [
                //     'label' => 'biaya_program',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                'biaya_bulanan' => [
                    'label' => 'biaya_bulanan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'biaya_daftar' => [
                    'label' => 'biaya_daftar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'biaya_modul' => [
                    'label' => 'biaya_modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_program' => [
                    'label' => 'status_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_program'   => $validation->getError('nama_program'),
                        'jenis_program'  => $validation->getError('jenis_program'),
                        // 'biaya_program'  => $validation->getError('biaya_program'),
                        'biaya_bulanan'  => $validation->getError('biaya_bulanan'),
                        'biaya_daftar'   => $validation->getError('biaya_daftar'),
                        'biaya_modul'    => $validation->getError('biaya_modul'),
                        'status_program' => $validation->getError('status_program'),
                    ]
                ];
            } else {

                //Get data nominal rupiah
                // $get_biaya_program  = $this->request->getVar('biaya_program');
                $get_biaya_daftar   = $this->request->getVar('biaya_daftar');
                $get_biaya_bulanan  = $this->request->getVar('biaya_bulanan');
                $get_biaya_modul    = $this->request->getVar('biaya_modul');

                //Replace Rp. and thousand separtor from input
                // $biaya_program   = str_replace(str_split('Rp. .'), '', $get_biaya_program);
                $biaya_daftar    = str_replace(str_split('Rp. .'), '', $get_biaya_daftar);
                $biaya_bulanan   = str_replace(str_split('Rp. .'), '', $get_biaya_bulanan);
                $biaya_modul     = str_replace(str_split('Rp. .'), '', $get_biaya_modul);

                $updatedata = [
                    'nama_program'    => strtoupper($this->request->getVar('nama_program')),
                    'jenis_program'   => $this->request->getVar('jenis_program'),
                    'kategori_program'=> $this->request->getVar('kategori_program'),
                    'biaya_program'   => 0,
                    'biaya_bulanan'   => $biaya_bulanan,
                    'biaya_daftar'    => $biaya_daftar,
                    'biaya_modul'     => $biaya_modul,
                    'status_program'  => $this->request->getVar('status_program'),
                ];

                $program_id = $this->request->getVar('program_id');
                $this->program->update($program_id, $updatedata);

                $aktivitas = 'Ubah Data Program Nonreg Nama : ' .  $this->request->getVar('nama_program');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'program-nonreg'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }
}