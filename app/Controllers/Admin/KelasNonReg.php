<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class KelasNonReg extends BaseController
{
    public function index()
    {
        $user           = $this->userauth();

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('tahun', $params)) {
            $tahun           = $params['tahun'];
        } else {
            $tahun           = date('Y');
        }

        $list_tahun      = $this->nonreg_kelas->list_unik_tahun();
        $list_kelas         = $this->nonreg_kelas->list($tahun);
        $data = [
            'title'             => 'Manajamen Kelas Non-Reguler Tahun ' . $tahun,
            'list'              => $list_kelas,
            'list_tahun'        => $list_tahun,
            'tahun_pilih'       => $tahun,
            'user'              => $user,
        ];
        return view('panel_admin/kelas_nonreg/index', $data);
    }

    public function input()
    {
        if ($this->request->isAJAX()) {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;

            $data = [
                'title'     => 'Form Input Kelas Baru Non-Reguler',
                'program'   => $this->program->list_aktif_nonreg(),
                'pengajar'  => $this->pengajar->list(),
                'level'     => $this->level->list(),
                'usaha'     => $this->nonreg_usaha->findAll(),
                'angkatan'  => $angkatan,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_nonreg/add', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $nk_id      = $this->request->getVar('nk_id');
            $nonreg     =  $this->nonreg_kelas->find($nk_id);
            $data = [
                'title'     => 'Ubah Data Kelas Non-Reguler ' . $nonreg['nk_nama'],
                'program'   => $this->program->list_aktif_nonreg(),
                'pengajar'  => $this->pengajar->list(),
                'level'     => $this->level->list(),
                'usaha'     => $this->nonreg_usaha->findAll(),
                'nonreg'    => $nonreg,
            ];
            $msg = [
                'sukses' => view('panel_admin/kelas_nonreg/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function detail()
    {
        $user           = $this->userauth();
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('id', $params)) {
            $nk_id              = $params['id'];
            $peserta_onkelas    = $this->nonreg_peserta->peserta_onkelas($nk_id);
            $kelas              = $this->nonreg_kelas->find($nk_id);

            $data = [
                'title'             => 'Al-Haqq - Detail Kelas Non-Reguler',
                'user'              => $user,
                'peserta_onkelas'   => $peserta_onkelas,
                'detail_kelas'      => $kelas,
                'pengajar'          => $this->nonreg_pengajar->list($kelas['nk_id']),
                'all_level'         => $this->level->list(),
                'level'             => $this->nonreg_kelas_level->list($nk_id),
                'jumlah_peserta'    => count($peserta_onkelas),
            ];
            return view('panel_admin/kelas_nonreg/detail', $data);
        } else {
            return redirect()->to('kelas-nonreg');
        }
    }

    public function edit_level()
    {
        if ($this->request->isAJAX()) {

            $modul      = $this->request->getVar('modul');

            $nk_id      = $this->request->getVar('nk_id');
            $nk         = $this->nonreg_kelas->find($nk_id);

            if ($modul == 'level') {
                $nkl        = $this->nonreg_kelas_level->list($nk_id);
                $level      = $this->level->list();

                $selectedIds = array_map(function ($selected) {
                    return $selected['peserta_level_id'];
                }, $nkl);

                $filteredLevel = array_filter($level, function ($item) use ($selectedIds) {
                    return !in_array($item['peserta_level_id'], $selectedIds);
                });

                $data = [
                    'title'     => 'Ubah Data Level Kelas Non-Reguler ' . $nk['nk_nama'],
                    'nk_id'     => $nk_id,
                    'level'     => $filteredLevel,
                    'pengajar'  => null,
                    'modul'     => $modul,
                    'modulText' => "Daftar Level"
                ];
            } elseif ($modul == 'pengajar') {
                $nkp        = $this->nonreg_pengajar->list($nk_id);
                $pengajar   = $this->pengajar->list();

                $selectedIds = array_map(function ($selected) {
                    return $selected['pengajar_id'];
                }, $nkp);

                $filteredPengajar = array_filter($pengajar, function ($item) use ($selectedIds) {
                    return !in_array($item['pengajar_id'], $selectedIds);
                });

                $data = [
                    'title'     => 'Tambah Pengajar Kelas Non-Reguler ' . $nk['nk_nama'],
                    'nk_id'     => $nk_id,
                    'level'     => null,
                    'pengajar'  => $filteredPengajar,
                    'modul'     => $modul,
                    'modulText' => "Daftar Pengajar"
                ];
            }


            $msg = [
                'sukses' => view('panel_admin/kelas_nonreg/edit_level', $data)
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
                'nk_nama' => [
                    'label' => 'nk_nama',
                    'rules' => 'is_unique[nonreg_kelas.nk_nama]',
                    'errors' => [
                        'is_unique' => 'nama kelas non-reguler harus unik, sudah ada yang menggunakan nama kelas non-reguler ini',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nk_nama'        => $validation->getError('nk_nama'),
                    ]
                ];
            } else {

                //Get Value
                $program_id     = strtoupper($this->request->getVar('program_id'));
                $program        = $this->program->find($program_id);
                // $nk_program     = $program['nama_program'];
                $nk_tipe        = $program['jenis_program'];
                $nonreg_tipe    = $this->nonreg_tipe->find($nk_tipe);
                $tipe_code      = $nonreg_tipe['nrt_code'];

                $nk_program     = $this->request->getVar('program_id');
                $nk_nama        = strtoupper($this->request->getVar('nk_nama'));
                $nk_angkatan    = $this->request->getVar('nk_angkatan');
                $nk_usaha       = strtoupper($this->request->getVar('nk_usaha'));
                $nk_hari        = strtoupper($this->request->getVar('nk_hari'));
                $nk_waktu       = $this->request->getVar('nk_waktu');
                $nk_timezone    = strtoupper($this->request->getVar('nk_timezone'));
                $nk_tm_total    = $this->request->getVar('nk_tm_total');
                $nk_tm_ambil    = $this->request->getVar('nk_tm_ambil');
                $nk_level       = $this->request->getVar('nk_level');
                $nk_kuota       = $this->request->getVar('nk_kuota');
                // $nk_absen_metode= $this->request->getVar('nk_absen_metode');
                $nk_absen_metode = NULL;
                $nk_keterangan  = str_replace(array("\r", "\n"), ' ', $this->request->getVar('nk_keterangan'));
                $nk_status      = $this->request->getVar('nk_status');
                $nk_pic_name    = strtoupper($this->request->getVar('nk_pic_name'));
                $nk_pic_hp      = $this->request->getVar('nk_pic_hp');
                $nk_lokasi      = str_replace(array("\r", "\n"), ' ', strtoupper($this->request->getVar('nk_lokasi')));
                $nk_tahun       = $this->request->getVar('nk_tahun');

                //Create NIK
                if (date('m') >= 1 && date('m') <= 3) {
                    $Q = 'Q1';
                } elseif (date('m') >= 4 && date('m') <= 6) {
                    $Q = 'Q2';
                } elseif (date('m') >= 7 && date('m') <= 9) {
                    $Q = 'Q3';
                } elseif (date('m') >= 10 && date('m') <= 12) {
                    $Q = 'Q4';
                }
                $last           = $this->nonreg_kelas->orderBy('nk_created', 'desc')->first();

                if ($last != NULL) {
                    $last_part      = explode("-", $last['nk_id']);
                    if (isset($last_part[1])) {
                        $quarter    = substr($last_part[1], 1, 3);
                        $last_year  = substr($quarter, 1);
                    }
                }

                $year_code      = substr(date('Y'), -2);

                if ($last == NULL || $last_year != substr(date('Y'), -2)) {
                    $last_id        = '0001';
                } else {
                    $code0          = end($last_part);
                    $last_id        = str_pad(($code0 + 1), 4, "0", STR_PAD_LEFT);
                }
                $nk_id          = $tipe_code . '-' . $Q . $year_code . '-' . $last_id;

                $this->db->transStart();
                for ($i = 1; $i <= $nk_kuota; $i++) {
                    $pstData = ['np_kelas' => $nk_id];
                    $np_id = $this->nonreg_peserta->insert($pstData);
                    $ApstData = [
                        'naps_peserta' => $np_id,
                    ];
                    $this->nonreg_absen_peserta->insert($ApstData);
                }
                $newUser    = [
                    'username'                 => strtoupper($nk_id),
                    'nama'                    => strtoupper($nk_pic_name),
                    'password'                => (password_hash(getenv('password_default'), PASSWORD_BCRYPT)),
                    'foto'                    => 'default.png',
                    'level'                    => 8,
                    'active'                => 1,
                ];
                $this->user->insert($newUser);
                $simpandata = [
                    'nk_id'             => $nk_id,
                    'nk_nama'           => $nk_nama,
                    'nk_angkatan'       => $nk_angkatan,
                    'nk_tahun'          => $nk_tahun,
                    'nk_program'        => $nk_program,
                    'nk_tipe'           => $nk_tipe,
                    'nk_usaha'          => $nk_usaha,
                    // 'nk_pengajar'       => $nk_pengajar,
                    'nk_hari'           => $nk_hari,
                    'nk_waktu'          => $nk_waktu,
                    'nk_timezone'       => $nk_timezone,
                    'nk_tm_total'       => $nk_tm_total,
                    'nk_tm_ambil'       => $nk_tm_ambil,
                    // 'nk_level'          => $nk_level,
                    'nk_kuota'          => $nk_kuota,
                    'nk_absen_metode'   => $nk_absen_metode,
                    'nk_status'         => $nk_status,
                    'nk_status_daftar'  => "0",
                    'nk_status_bayar'   => NULL,
                    'nk_pic_name'       => $nk_pic_name,
                    'nk_pic_hp'         => $nk_pic_hp,
                    'nk_pic_otoritas'   => "1",
                    'nk_keterangan'     => $nk_keterangan,
                    'nk_lokasi'         => $nk_lokasi,
                    'nk_created'        => date('Y-m-d H:i:s'),
                ];
                $this->nonreg_kelas->insert($simpandata);
                foreach ($nk_level as $item) {
                    $nk_kelas_level_NEW = [
                        'nkl_nkid' => $nk_id,
                        'nkl_level' => $item,
                    ];
                    $this->nonreg_kelas_level->insert($nk_kelas_level_NEW);
                    $new_nkl        = $this->nonreg_kelas_level->insertID();
                    $new_nkl_array[] = $new_nkl;
                }
                $var_nk_level   = json_encode($new_nkl_array);
                $updateNKL = [
                    'nk_level'  => $var_nk_level
                ];
                $this->nonreg_kelas->update($nk_id, $updateNKL);
                $nk_pengajar    = $this->request->getPost('nk_pengajar');
                foreach ($nk_pengajar as $item) {
                    $nonreg_pengajar_NEW = [
                        'npj_pengajar' => $item,
                        'npj_kelas'    => $nk_id,
                    ];
                    $napj_pengajar = $this->nonreg_pengajar->insert($nonreg_pengajar_NEW);
                    $nonreg_absen_pengajar_NEW = [
                        'napj_pengajar' => $napj_pengajar,
                    ];
                    $this->nonreg_absen_pengajar->insert($nonreg_absen_pengajar_NEW);
                }
                $this->db->transComplete();

                $aktivitas = 'Buat Data Kelas Non-Reguler Nama : ' .  $this->request->getVar('nk_nama');

                if ($this->db->transStatus() === FALSE) {
                    /*--- Log ---*/
                    $this->logging('Admin', 'FAIL', $aktivitas);
                } else {
                    /*--- Log ---*/
                    $this->logging('Admin', 'BERHASIL', $aktivitas);
                }

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-nonreg'
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
                'nk_nama' => [
                    'label' => 'nk_nama',
                    'rules' => 'is_unique_except[nonreg_kelas.nk_nama.nk_id.' . $this->request->getVar('nk_id') . ']',
                    'errors' => [
                        'is_unique_except' => 'nama kelas non-reguler harus unik, sudah ada yang menggunakan nama kelas non-reguler ini',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nk_nama'        => $validation->getError('nk_nama'),
                    ]
                ];
            } else {

                //Get Value
                $nk_id = $this->request->getVar('nk_id');

                $program_id     = strtoupper($this->request->getVar('program_id'));
                $program        = $this->program->find($program_id);
                // $nk_program     = $program['nama_program'];
                $nk_program     = $this->request->getVar('program_id');
                $nk_tipe        = $program['jenis_program'];
                $nonreg_tipe    = $this->nonreg_tipe->find($nk_tipe);
                $tipe_code      = $nonreg_tipe['nrt_code'];

                $nk_nama        = strtoupper($this->request->getVar('nk_nama'));
                $nk_angkatan    = $this->request->getVar('nk_angkatan');
                $nk_usaha       = strtoupper($this->request->getVar('nk_usaha'));
                // $nk_pengajar    = $this->request->getVar('nk_pengajar');
                $nk_hari        = strtoupper($this->request->getVar('nk_hari'));
                $nk_waktu       = $this->request->getVar('nk_waktu');
                $nk_timezone    = strtoupper($this->request->getVar('nk_timezone'));
                $nk_tm_total    = $this->request->getVar('nk_tm_total');
                $nk_tm_ambil    = $this->request->getVar('nk_tm_ambil');
                // $nk_level       = $this->request->getVar('nk_level');
                $nk_kuota       = $this->request->getVar('nk_kuota');
                // $nk_absen_metode= $this->request->getVar('nk_absen_metode');
                $nk_absen_metode = NULL;
                $nk_status      = $this->request->getVar('nk_status');
                $nk_pic_name    = strtoupper($this->request->getVar('nk_pic_name'));
                $nk_pic_hp      = $this->request->getVar('nk_pic_hp');
                $nk_pic_otoritas = $this->request->getVar('nk_pic_otoritas');
                $nk_keterangan  = str_replace(array("\r", "\n"), ' ', $this->request->getVar('nk_keterangan'));
                $nk_lokasi      = str_replace(array("\r", "\n"), ' ', strtoupper($this->request->getVar('nk_lokasi')));
                $nk_tm_bayar    = $this->request->getVar('nk_tm_bayar');
                $nk_tahun       = $this->request->getVar('nk_tahun');

                $updatedata = [
                    'nk_nama'           => $nk_nama,
                    'nk_angkatan'       => $nk_angkatan,
                    'nk_tahun'          => $nk_tahun,
                    'nk_program'        => $nk_program,
                    'nk_tipe'           => $nk_tipe,
                    'nk_usaha'          => $nk_usaha,
                    // 'nk_pengajar'       => $nk_pengajar,
                    'nk_hari'           => $nk_hari,
                    'nk_waktu'          => $nk_waktu,
                    'nk_timezone'       => $nk_timezone,
                    'nk_tm_total'       => $nk_tm_total,
                    'nk_tm_ambil'       => $nk_tm_ambil,
                    // 'nk_level'          => $var_nk_level,
                    'nk_kuota'          => $nk_kuota,
                    'nk_absen_metode'   => $nk_absen_metode,
                    'nk_status'         => $nk_status,
                    'nk_pic_name'       => $nk_pic_name,
                    'nk_pic_hp'         => $nk_pic_hp,
                    'nk_pic_otoritas'   => $nk_pic_otoritas,
                    'nk_keterangan'     => $nk_keterangan,
                    'nk_lokasi'         => $nk_lokasi,
                    'nk_tm_bayar'       => $nk_tm_bayar,
                ];

                $this->nonreg_kelas->update($nk_id, $updatedata);

                // Data Log END
                $aktivitas = 'Ubah Data Kelas Non-Reguler Nama : ' .  $this->request->getVar('nk_nama');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'kelas-nonreg'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update_level()
    {
        if ($this->request->isAJAX()) {
            //Get Value
            $modul          = $this->request->getVar('modul');

            $nk_id          = $this->request->getVar('nk_id');
            $nk             = $this->nonreg_kelas->find($nk_id);

            if ($modul == 'level') {
                $new_nkl_array  = [$nk['nk_level']];
                $nk_level       = $this->request->getVar('nk_level');

                foreach ($nk_level as $item) {
                    $nk_kelas_level_NEW = [
                        'nkl_nkid' => $nk_id,
                        'nkl_level' => $item,
                    ];
                    $this->nonreg_kelas_level->insert($nk_kelas_level_NEW);
                    $new_nkl        = $this->nonreg_kelas_level->insertID();
                    $new_nkl_array[] = $new_nkl;
                }
                $var_nk_level   = json_encode($new_nkl_array);
                $updateNKL = [
                    'nk_level'  => $var_nk_level
                ];
                $this->nonreg_kelas->update($nk_id, $updateNKL);
            } elseif ($modul == 'pengajar') {
                $np_pengajar       = $this->request->getVar('np_pengajar');

                foreach ($np_pengajar as $item) {
                    $np_pengajar_NEW = [
                        'npj_pengajar' => $item,
                        'npj_kelas'    => $nk['nk_id'],
                    ];
                    $napj_pengajar = $this->nonreg_pengajar->insert($np_pengajar_NEW);
                    $nonreg_absen_pengajar_NEW = [
                        'napj_pengajar' => $napj_pengajar,
                    ];
                    $this->nonreg_absen_pengajar->insert($nonreg_absen_pengajar_NEW);
                }
            }

            // Data Log END
            $aktivitas = 'Ubah Data ' . $modul . ' pada Kelas Non-Reguler : ' . $nk['nk_nama'];
            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => '/kelas-nonreg/detail?id=' . $nk_id
                ]
            ];

            echo json_encode($msg);
        }
    }

    public function export()
    {
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('tahun', $params)) {
            $tahun           = $params['tahun'];
        } else {
            $tahun           = date('Y');
        }

        $kelas      =  $this->nonreg_kelas->list($tahun);
        $total_row  = count($kelas) + 5;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $styleColumn = [
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ];

        $style_up = [
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'D9D9D9',
                ],
                'endColor' => [
                    'argb' => 'D9D9D9',
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $isi_tengah = [
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $judul = "DATA KELAS NON-REGULER ALHAQQ TAHUN " . $tahun . " - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:Q1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:Q2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:Q4')->applyFromArray($style_up);

        $sheet->getStyle('A5:Q' . $total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NAMA KELAS')
            ->setCellValue('B4', 'TAHUN PERKULIAHAN')
            ->setCellValue('C4', 'PROGRAM')
            ->setCellValue('D4', 'TIPE')
            ->setCellValue('E4', 'BIDANG USAHA')
            ->setCellValue('F4', 'HARI')
            ->setCellValue('G4', 'JAM')
            ->setCellValue('H4', 'PENGAJAR')
            ->setCellValue('I4', 'LEVEL')
            ->setCellValue('J4', 'JUMLAH PESERTA')
            ->setCellValue('K4', 'JUMLAH PERTEMUAN AMBIL')
            ->setCellValue('L4', 'JUMLAH PERTEMUAN MAKS.')
            ->setCellValue('M4', 'STATUS KELAS')
            ->setCellValue('N4', 'METODE ABSEN')
            ->setCellValue('O4', 'NAMA PIC')
            ->setCellValue('P4', 'NO. HP PIC')
            ->setCellValue('Q4', 'LOKASI KELAS');

        $columns = range('A', 'Q');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;

        foreach ($kelas as $data) {

            if ($data['nk_status'] == 1) {
                $status = 'Aktif';
            } elseif ($data['nk_status'] == 0) {
                $status = 'Nonaktif';
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['nk_nama'])
                ->setCellValue('B' . $row, $data['nk_tahun'])
                ->setCellValue('C' . $row, $data['nk_program'])
                ->setCellValue('D' . $row, $data['nk_tipe'])
                ->setCellValue('E' . $row, $data['nk_usaha'])
                ->setCellValue('F' . $row, $data['nk_hari'])
                ->setCellValue('G' . $row, $data['nk_waktu'] . ' ' . $data['nk_timezone'])
                ->setCellValue('H' . $row, $data['nama_pengajar'])
                ->setCellValue('I' . $row, "") #$data['nk_level'])
                ->setCellValue('J' . $row, $data['nk_kuota'])
                ->setCellValue('K' . $row, $data['nk_tm_ambil'])
                ->setCellValue('L' . $row, $data['nk_tm_total'])
                ->setCellValue('M' . $row, $status)
                ->setCellValue('N' . $row, $data['nk_absen_metode'])
                ->setCellValue('O' . $row, $data['nk_pic_name'])
                ->setCellValue('P' . $row, $data['nk_pic_hp'])
                ->setCellValue('Q' . $row, $data['nk_lokasi']);

            $row++;
        }

        $writer     = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename   =  'Data-Kelas-Nonreguler-' . date('Y-m-d-His');
        $aktivitas  = 'Download Data Kelas Non-Reguler via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');
        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function save_peserta()
    {
        $this->db->transBegin();

        $requestData    = $this->request->getVar('data');
        $data           = json_decode($requestData, true);
        $pst            = $this->nonreg_peserta->find($data[0]['column_2']);
        $nk_id          = $pst['np_kelas'];

        $errors = [];

        foreach ($data as $row) {

            $np_nama = $row['column_1'];
            $np_id   = $row['column_2'];
            $np_level = $row['column_3'];

            $dataUpdate = [
                'np_nama' => str_replace(array("\r", "\n"), ' ', strtoupper($np_nama)),
                'np_level' => $np_level,
            ];

            $store = $this->nonreg_peserta->update($np_id, $dataUpdate);

            if ($store === false) {
                $errors[] = $row['column_2'] . ', ';
            }
        }

        if (!empty($errors)) {
            $aktivitas = 'Ubah Data Peserta Pada Kelas Non-Reguler: ' . $nk_id;
            $this->logging('Admin', 'FAIL', $aktivitas);
            $this->db->transRollback();
            $response = [
                'success' => false,
                'code'    => '400',
                'message' => 'Data Peserta Gagal Diubah',
                'redirect' => '/kelas-nonreg/detail?id=' . $nk_id
            ];
        } else {
            $aktivitas = 'Ubah Data Peserta Pada Kelas Non-Reguler: ' . $nk_id;
            $this->logging('Admin', 'BERHASIL', $aktivitas);
            $this->db->transCommit();
            $response = [
                'success' => true,
                'code'    => '200',
                'message' => 'Data Peserta Berhasil Diubah',
                'redirect' => '/kelas-nonreg/detail?id=' . $nk_id
            ];
        }

        return $this->response->setJSON($response);
    }

    public function add_kuota()
    {
        if ($this->request->isAJAX()) {

            $nk_id          = $this->request->getVar('nk_id');
            $nk_peserta_add = $this->request->getVar('nk_peserta_add');
            $kelas          = $this->nonreg_kelas->find($nk_id);

            $update  = [
                'nk_kuota' => $kelas['nk_kuota'] + $nk_peserta_add,
            ];
            $this->nonreg_kelas->update($nk_id, $update);
            for ($i = 1; $i <= $nk_peserta_add; $i++) {
                $pstData = ['np_kelas' => $nk_id];
                $np_id = $this->nonreg_peserta->insert($pstData);
                $ApstData = [
                    'naps_peserta' => $np_id,
                ];
                $this->nonreg_absen_peserta->insert($ApstData);
            }

            $aktivitas = 'Tambah kuota ' . $nk_peserta_add . ' pada kelas non-reguler ' .  $nk_id;

            if ($this->db->transStatus() === FALSE) {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            } else {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => '/kelas-nonreg/detail?id=' . $nk_id
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function delete_peserta()
    {
        if ($this->request->isAJAX()) {

            $np_id   = $this->request->getVar('np_id');
            $pst     = $this->nonreg_peserta->find($np_id);
            $nk_id   = $pst['np_kelas'];
            $kelas   = $this->nonreg_kelas->find($nk_id);

            $update  = [
                'nk_kuota' => $kelas['nk_kuota'] - 1,
            ];
            $this->nonreg_kelas->update($nk_id, $update);
            $this->nonreg_peserta->delete($np_id);

            $aktivitas = 'Kurangi kuota' . ' pada kelas non-reguler ' .  $nk_id;

            if ($this->db->transStatus() === FALSE) {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            } else {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => '/kelas-nonreg/detail?id=' . $nk_id
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function delete_level()
    {
        if ($this->request->isAJAX()) {

            $nkl_id     = $this->request->getVar('nkl_id');
            $level      = $this->nonreg_kelas_level->find($nkl_id);
            $level_data = $this->level->find($level['nkl_level']);

            $this->nonreg_kelas_level->delete($nkl_id);

            $aktivitas = 'Hapus level' . $level_data['nama_level'] . ' pada kelas non-reguler ' .  $level['nkl_nkid'];

            if ($this->db->transStatus() === FALSE) {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            } else {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => '/kelas-nonreg/detail?id=' . $level['nkl_nkid']
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function delete_pengajar()
    {
        if ($this->request->isAJAX()) {

            $npj_id               = $this->request->getVar('npj_id');
            $nonreg_pengajar      = $this->nonreg_pengajar->find($npj_id);
            $nonreg_kelas         = $this->nonreg_kelas->find($nonreg_pengajar['npj_kelas']);
            $pengajar             = $this->pengajar->find($nonreg_pengajar['npj_pengajar']);

            $this->nonreg_absen_pengajar->where('napj_pengajar', $npj_id)->delete();
            $this->nonreg_pengajar->delete($npj_id);

            $aktivitas = 'Hapus pengajar ' . $pengajar['nama_pengajar'] . ' pada kelas non-reguler ' .  $nonreg_kelas['nk_nama'];

            if ($this->db->transStatus() === FALSE) {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            } else {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => '/kelas-nonreg/detail?id=' . $nonreg_kelas['nk_id']
                ]
            ];
            echo json_encode($msg);
        }
    }
}
