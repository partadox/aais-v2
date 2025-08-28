<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class TerimaPeserta extends BaseController
{
    public function index()
    {
        $user  = $this->userauth(); // Return Array

        $data = [
            'title'                 => 'Terima Transfer Peserta dari Cabang',
            'user'                  => $user,
        ];
        return view('panel_admin/terima_peserta/index', $data);
    }

    public function getdataAll()
    {
        $url = 'https://aais-alhaqq.or.id/api/transfer-peserta/list';
        $apiKey = getenv('WAG_KEY2');
        // $id = 1;

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => array(
                'X-API-KEY: ' . $apiKey,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        if (count(json_decode($response, true)) != 0) {
            $lists = json_decode($response, true);
            $no = 0;
            foreach ($lists as $list) {
                $row = [];

                // $id = $list['peserta_id'];
                $peserta = $list['peserta'];
                $cabang = $list['cabang'];
                $status = $list['status'];
                if ($status == 0) {
                    $status = "<span class=\"badge badge-secondary\">PENDING</span>";
                    $btnAccept = "<button type=\"button\" title=\"Terima Peserta\" class=\"btn btn-success btn-sm\" onclick=\"accept('" . $peserta . "')\"><i class=\"fa fa-check\"></i></button>";
                } else {
                    $status = "<span class=\"badge badge-success\">TERKONFIRMASI</span>";
                    $btnAccept = "";
                }
                $btnHistory = "<button type=\"button\" title=\"History Peserta\" class=\"btn btn-info btn-sm\" onclick=\"history('" . $peserta . "')\"><i class=\"fa fa-file\"></i></button>";
                $dt_transfer = $list['dt_transfer'];
                $dt_conf = $list['dt_conf'];
                $note = $list['note'];
                $type = $list['type'];
                $to = $list['to'];
                $name = $list['name'];
                $gender = $list['gender'];
                $level = $list['level'];
                $birthday = $list['birthday'];
                $phone = $list['phone'];

                $no++;
                $row[] = "<input type=\"checkbox\" name=\"id[]\" class=\"centangId\" value=\"$peserta\">" . " " . $no;
                $row[] = $name;
                $row[] = $level;
                $row[] = $gender;
                $row[] = umur($birthday);
                $row[] = $cabang;
                $row[] = $phone;
                $row[] = $status;
                $row[] = $dt_transfer;
                $row[] = $dt_conf;
                $row[] = $note;
                $row[] = $btnAccept . " " . $btnHistory;
                $data[] = $row;
            }
            $output = [
                "recordTotal"     => count($data),
                "recordsFiltered" => count($data),
                "data"            => $data,
            ];
            echo json_encode($output);
        } else {
            $output = [
                "recordTotal"     => 0,
                "recordsFiltered" => 0,
                "data"            => [],
            ];
            echo json_encode($output);
        }
    }

    public function modal()
    {
        if ($this->request->isAJAX()) {
            $peserta_id = $this->request->getVar('peserta_id');
            $modal = $this->request->getVar('modal');
            $apiKey = getenv('WAG_KEY');
            if ($modal == 'terima') {
                $url = 'https://aais-alhaqq.or.id/api/transfer-peserta/detail?id=' . $peserta_id;

                $ch = curl_init($url);
                curl_setopt_array($ch, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_HTTPHEADER => array(
                        'X-API-KEY: ' . $apiKey,
                        'Content-Type: application/json'
                    ),
                    CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                $response = curl_exec($ch);
                curl_close($ch);
                $peserta = json_decode($response, true);
                $data = [
                    'peserta' => $peserta[0],
                    'modal'   => $modal,
                    'title'   => 'Form Insert Peserta Baru',
                    'level'   => $this->level->list(),
                    'kantor'  => $this->kantor->list(),
                    'pekerjaan' => $this->pekerjaan->list(),
                ];
                $msg = [
                    'sukses' => view('panel_admin/terima_peserta/modal', $data)
                ];
                echo json_encode($msg);
            } else {
                $url = 'https://aais-alhaqq.or.id/api/transfer-peserta/history?id=' . $peserta_id;

                $ch = curl_init($url);
                curl_setopt_array($ch, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_HTTPHEADER => array(
                        'X-API-KEY: ' . $apiKey,
                        'Content-Type: application/json'
                    ),
                    CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                $response = curl_exec($ch);
                curl_close($ch);
                $history = json_decode($response, true);
                if ($history['status'] != 200) {
                    $history = null;
                }
                $data = [
                    'history' => $history,
                    'modal'   => $modal,
                    'title'   => 'History Kelas Peserta di Cabang'
                ];
                $msg = [
                    'sukses' => view('panel_admin/terima_peserta/modal', $data)
                ];
                echo json_encode($msg);
            }
        }
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nis' => [
                    'label' => 'nis',
                    'rules' => 'required|is_unique[peserta.nis]',
                    'errors' => [
                        'required' => 'nis tidak boleh kosong',
                        'is_unique' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'angkatan' => [
                    'label' => 'angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'angkatan tidak boleh kosong',
                    ]
                ],
                'asal_cabang_peserta' => [
                    'label' => 'asal_cabang_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'level_peserta' => [
                    'label' => 'level_peserta',
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
                'nik' => [
                    'label' => 'nik',
                    'rules' => 'required|is_unique[peserta.nik]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
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
                'status_peserta' => [
                    'label' => 'status_peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'                  => $validation->getError('nama'),
                        'asal_cabang_peserta'   => $validation->getError('asal_cabang_peserta'),
                        'nis'                   => $validation->getError('nis'),
                        'angkatan'              => $validation->getError('angkatan'),
                        'level_peserta'         => $validation->getError('level_peserta'),
                        'jenkel'                => $validation->getError('jenkel'),
                        'nik'                   => $validation->getError('nik'),
                        'tmp_lahir'             => $validation->getError('tmp_lahir'),
                        'tgl_lahir'             => $validation->getError('tgl_lahir'),
                        'pendidikan'            => $validation->getError('pendidikan'),
                        'jurusan'               => $validation->getError('jurusan'),
                        'status_kerja'          => $validation->getError('status_kerja'),
                        'pekerjaan'             => $validation->getError('pekerjaan'),
                        'hp'                    => $validation->getError('hp'),
                        'email'                 => $validation->getError('email'),
                        'domisili_peserta'      => $validation->getError('domisili_peserta'),
                        'alamat'                => $validation->getError('alamat'),
                        'status_peserta'        => $validation->getError('status_peserta'),
                    ]
                ];
            } else {
                $newUser    = [
                    'username'                 => $this->request->getVar('nis'),
                    'nama'                    => strtoupper($this->request->getVar('nama')),
                    'password'                => (password_hash(getenv('password_default'), PASSWORD_BCRYPT)),
                    'foto'                    => 'default.png',
                    'level'                    => 4,
                    'active'                => 1,
                ];

                $this->db->transStart();
                $state[] = $this->user->insert($newUser);
                $newpeserta = [
                    'nama_peserta'          => strtoupper($this->request->getVar('nama')),
                    'asal_cabang_peserta'   => $this->request->getVar('asal_cabang_peserta'),
                    'nis'                   => $this->request->getVar('nis'),
                    'angkatan'              => $this->request->getVar('angkatan'),
                    'level_peserta'         => $this->request->getVar('level_peserta'),
                    'jenkel'                => $this->request->getVar('jenkel'),
                    'nik'                   => $this->request->getVar('nik'),
                    'tmp_lahir'             => strtoupper($this->request->getVar('tmp_lahir')),
                    'tgl_lahir'             => $this->request->getVar('tgl_lahir'),
                    'pendidikan'            => $this->request->getVar('pendidikan'),
                    'jurusan'               => strtoupper($this->request->getVar('jurusan')),
                    'status_kerja'          => $this->request->getVar('status_kerja'),
                    'pekerjaan'             => $this->request->getVar('pekerjaan'),
                    'hp'                    => $this->request->getVar('hp'),
                    'email'                 => strtolower($this->request->getVar('email')),
                    'domisili_peserta'      => $this->request->getVar('domisili_peserta'),
                    'alamat'                => strtoupper($this->request->getVar('alamat')),
                    'status_peserta'        => $this->request->getVar('status_peserta'),
                    'user_id'               => $this->user->insertID(),
                    'tgl_gabung'            => date("Y-m-d"),
                    'peserta_note'          => str_replace(array("\r", "\n"), ' ', $this->request->getVar('peserta_note')),
                ];
                $state[] = $this->peserta->insert($newpeserta);
                $peserta_transfer_id = $this->request->getVar('peserta_transfer_id');
                $url = 'https://aais-alhaqq.or.id/api/transfer-peserta/update?id=' . $peserta_transfer_id;

                $ch = curl_init($url);
                $apiKey = getenv('WAG_KEY');
                curl_setopt_array($ch, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_HTTPHEADER => array(
                        'X-API-KEY: ' . $apiKey,
                        'Content-Type: application/json'
                    ),
                    CURLOPT_CUSTOMREQUEST => 'POST',
                ));

                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response, true);
                if ($response['status'] == 200) {
                    $status = true;
                } else {
                    $status = false;
                }
                $state[] = $status;
                $aktivitas = 'Terima Data Peserta dari Cabang ' . $this->request->getVar('nama');
                if (in_array(false, $state, true)) {
                    $this->db->transRollback();
                    /*--- Log ---*/
                    $this->logging('Admin', 'FAIL', $aktivitas);
                } else {
                    $this->db->transComplete();
                    /*--- Log ---*/
                    $this->logging('Admin', 'BERHASIL', $aktivitas);
                }


                $msg = [
                    'sukses' => [
                        'link' => 'terima-peserta'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }
}
