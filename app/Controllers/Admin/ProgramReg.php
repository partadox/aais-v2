<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ProgramReg extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Manajemen Program Reguler',
            'list'  => $this->program->list_reguler(),
            'user'  => $user,
        ];

        return view('panel_admin/program_regular/index', $data); 
    }

    public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Input Program Regular Baru',
            ];
            $msg = [
                'sukses' => view('panel_admin/program_regular/add', $data)
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
                'title'     => 'Ubah Data Program Regular',
                'program'    => $program,
            ];
            $msg = [
                'sukses' => view('panel_admin/program_regular/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function ujian_setting()
    {
        $user           = $this->userauth();
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('id', $params)) {
            $id   = $params['id'];
            if (ctype_digit($id)) {
                $program_id   = $params['id'];
            }else {
                return redirect()->to('/program-regular');
            }
        } else {
            return redirect()->to('/program-regular');
        }

        $program = $this->program->find($program_id);
        if ($program['ujian_custom_id'] != NULL) {
            $ujian_custom = $this->ujian_custom_config->find($program['ujian_custom_id']);
        } else {
            $ujian_custom = NULL;
        }

        if ($program['kategori_program'] == 'REGULER') {
            $back_url = '/program-regular';
        } else {
            $back_url = '/program-nonreg';
        }
        
        $data = [
            'title'         => 'Pengaturan Fitur Ujian Program Regular',
            'user'          => $user,
            'program'       => $program,
            'ujian_custom'  => $ujian_custom,
            'back_url'      => $back_url,
        ];

        return view('panel_admin/program_regular/ujian_setting', $data); 
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
                'biaya_program' => [
                    'label' => 'biaya_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'biaya_bulanan' => [
                //     'label' => 'biaya_bulanan',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
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
                        'biaya_program'  => $validation->getError('biaya_program'),
                        'biaya_bulanan'  => $validation->getError('biaya_bulanan'),
                        'biaya_daftar'   => $validation->getError('biaya_daftar'),
                        'biaya_modul'    => $validation->getError('biaya_modul'),
                        'status_program' => $validation->getError('status_program'),
                    ]
                ];
            } else {

                //Get data nominal rupiah
                $get_biaya_program  = $this->request->getVar('biaya_program');
                $get_biaya_daftar   = $this->request->getVar('biaya_daftar');
                // $get_biaya_bulanan  = $this->request->getVar('biaya_bulanan');
                $get_biaya_modul    = $this->request->getVar('biaya_modul');

                //Replace Rp. and thousand separtor from input
                $biaya_program   = str_replace(str_split('Rp. .'), '', $get_biaya_program);
                $biaya_daftar    = str_replace(str_split('Rp. .'), '', $get_biaya_daftar);
                $biaya_bulanan   = $biaya_program/4;
                $biaya_modul     = str_replace(str_split('Rp. .'), '', $get_biaya_modul);

                $simpandata = [
                    'nama_program'    => strtoupper($this->request->getVar('nama_program')),
                    'jenis_program'   => $this->request->getVar('jenis_program'),
                    'kategori_program'=> $this->request->getVar('kategori_program'),
                    'biaya_program'   => $biaya_program,
                    'biaya_bulanan'   => $biaya_bulanan,
                    'biaya_daftar'    => $biaya_daftar,
                    'biaya_modul'     => $biaya_modul, 
                    'status_program'  => $this->request->getVar('status_program'),
                ];

                $this->program->insert($simpandata);
                $aktivitas = 'Buat Data Program Nama : ' .  $this->request->getVar('nama_program');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'program-regular'
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
                'biaya_program' => [
                    'label' => 'biaya_program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'biaya_bulanan' => [
                //     'label' => 'biaya_bulanan',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
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
                        'biaya_program'  => $validation->getError('biaya_program'),
                        'biaya_bulanan'  => $validation->getError('biaya_bulanan'),
                        'biaya_daftar'   => $validation->getError('biaya_daftar'),
                        'biaya_modul'    => $validation->getError('biaya_modul'),
                        'status_program' => $validation->getError('status_program'),
                    ]
                ];
            } else {

                //Get data nominal rupiah
                $get_biaya_program  = $this->request->getVar('biaya_program');
                $get_biaya_daftar   = $this->request->getVar('biaya_daftar');
                // $get_biaya_bulanan  = $this->request->getVar('biaya_bulanan');
                $get_biaya_modul    = $this->request->getVar('biaya_modul');

                //Replace Rp. and thousand separtor from input
                $biaya_program   = str_replace(str_split('Rp. .'), '', $get_biaya_program);
                $biaya_daftar    = str_replace(str_split('Rp. .'), '', $get_biaya_daftar);
                $biaya_bulanan   = $biaya_program/4;
                $biaya_modul     = str_replace(str_split('Rp. .'), '', $get_biaya_modul);

                $updatedata = [
                    'nama_program'    => strtoupper($this->request->getVar('nama_program')),
                    'jenis_program'   => $this->request->getVar('jenis_program'),
                    'kategori_program'=> $this->request->getVar('kategori_program'),
                    'biaya_program'   => $biaya_program,
                    'biaya_bulanan'   => $biaya_bulanan,
                    'biaya_daftar'    => $biaya_daftar,
                    'biaya_modul'     => $biaya_modul,
                    'status_program'  => $this->request->getVar('status_program'),
                ];

                $program_id = $this->request->getVar('program_id');
                $this->program->update($program_id, $updatedata);

                $aktivitas = 'Ubah Data Program Nama : ' .  $this->request->getVar('nama_program');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'program-regular'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function save_ujian_setting()
    {
        $program_id          = $this->request->getVar('program_id');
        $ujian_custom_id     = $this->request->getVar('ujian_custom_id');
        $ujian_custom_status = $this->request->getVar('ujian_custom_status');
        $ujian_show          = $this->request->getVar('ujian_show');
        if ($ujian_show == '0') {
            $ujian_show = NULL;
        }

        if ($ujian_custom_status != 1) {
            $updateProgram = [
                'ujian_custom_status' => NULL,
                'ujian_show'          => $ujian_show
            ];
            $this->program->update($program_id, $updateProgram);

            $response = [
                    'status' => 'success',
                    'message' => 'BERHASIL! Fitur Absensi Program ini Diubah'
            ];
        
            echo json_encode($response);
            return;
        } else {
            if ($ujian_custom_id != "") {
                for ($i = 1; $i <= 10; $i++) {
                    $var_text_status = 'text' . $i . '_status';
                    $var_text_name = 'text' . $i . '_name';
                    $var_int_status = 'int' . $i . '_status';
                    $var_int_name = 'int' . $i . '_name';

                    $variabel[] = array(
                            $var_text_status => $this->request->getVar($var_text_status),
                            $var_text_name => $this->request->getVar($var_text_name),
                            $var_int_status => $this->request->getVar($var_int_status),
                            $var_int_name => $this->request->getVar($var_int_name),
                    );
                }

                $saveData = [];
                for ($i = 1; $i <= 10; $i++) {
                    $textStatusKey = "text{$i}_status";
                    $textNameKey = "text{$i}_name";
                    $intStatusKey = "int{$i}_status";
                    $intNameKey = "int{$i}_name";

                    $saveData[$textStatusKey] = $variabel[$i - 1][$textStatusKey] ?? null;
                    $saveData[$textNameKey] = $variabel[$i - 1][$textNameKey] ?? null;
                    $saveData[$intStatusKey] = $variabel[$i - 1][$intStatusKey] ?? null;
                    $saveData[$intNameKey] = $variabel[$i - 1][$intNameKey] ?? null;
                }

                $this->ujian_custom_config->update($ujian_custom_id, $saveData);

                $updateProgram = [
                    'ujian_custom_status' => $ujian_custom_status,
                    'ujian_show'          => $ujian_show
                ];
                $this->program->update($program_id, $updateProgram);

                $response = [
                    'status' => 'success',
                    'message' => 'BERHASIL! Fitur Ujian Program ini Diubah'
                ];
            
                echo json_encode($response);
                return;
                
            } else {
                for ($i = 1; $i <= 10; $i++) {
                    $var_text_status = 'text' . $i . '_status';
                    $var_text_name = 'text' . $i . '_name';
                    $var_int_status = 'int' . $i . '_status';
                    $var_int_name = 'int' . $i . '_name';

                    $variabel[] = array(
                            $var_text_status => $this->request->getVar($var_text_status),
                            $var_text_name => $this->request->getVar($var_text_name),
                            $var_int_status => $this->request->getVar($var_int_status),
                            $var_int_name => $this->request->getVar($var_int_name),
                    );
                }

                $saveData = [];
                for ($i = 1; $i <= 10; $i++) {
                    $textStatusKey = "text{$i}_status";
                    $textNameKey = "text{$i}_name";
                    $intStatusKey = "int{$i}_status";
                    $intNameKey = "int{$i}_name";

                    $saveData[$textStatusKey] = $variabel[$i - 1][$textStatusKey] ?? null;
                    $saveData[$textNameKey] = $variabel[$i - 1][$textNameKey] ?? null;
                    $saveData[$intStatusKey] = $variabel[$i - 1][$intStatusKey] ?? null;
                    $saveData[$intNameKey] = $variabel[$i - 1][$intNameKey] ?? null;
                }

                $this->ujian_custom_config->insert($saveData);

                $updateProgram = [
                    'ujian_custom_status' => $ujian_custom_status,
                    'ujian_custom_id'     => $this->ujian_custom_config->insertID(),
                    'ujian_show'          => $ujian_show
                ];
                $this->program->update($program_id, $updateProgram);

                $db = db_connect();
                $query = $db->query("
                    SELECT peserta_kelas.data_ujian, peserta_kelas.data_peserta_id, peserta_kelas.data_kelas_id
                    FROM peserta_kelas
                    JOIN program_kelas ON peserta_kelas.data_kelas_id = program_kelas.kelas_id
                    WHERE program_kelas.program_id = $program_id
                ");

                $result = $query->getResultArray();
                foreach ($result as $ujian) {
                    $saveData = [
                        'ucv_ujian_id'  => $ujian['data_ujian'],
                        'ucv_peserta_id'=> $ujian['data_peserta_id'],
                        'ucv_kelas_id'  => $ujian['data_kelas_id'],
                    ];
                    $this->ujian_custom_value->insert($saveData);
                }

                // $this->session->setFlashdata('pesan_sukses', 'BERHASIL! Fitur Absensi Program ini Diubah');
                // return redirect()->to('/program-regular-ujian-setting?id='.$program_id); 
                $response = [
                    'status' => 'success',
                    'message' => 'BERHASIL! Fitur Ujian Program ini Diubah'
                ];
            
                echo json_encode($response);
                return;
            }
        }
    }
}