<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Absensi extends BaseController
{
    /*--- ABSENSI REGULAR ---*/
    //frontend
    public function regular_peserta()
    {
        $user  = $this->userauth();
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }

        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_absensi       = $this->peserta_kelas->admin_rekap_absen_peserta($angkatan);

        $data = [
            'title'         => 'Data Absensi Peserta pada Angkatan Perkuliahan ' . $angkatan,
            'user'          => $user,
            'list'          => $list_absensi,
            'list_angkatan' => $list_angkatan,
            'angkatan_pilih' => $angkatan,
        ];
        return view('panel_admin/absensi/regular/peserta', $data);
    }

    public function regular_pengajar()
    {
        $user  = $this->userauth();
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_absensi       = $this->kelas->admin_rekap_absen_pengajar($angkatan);

        $data = [
            'title'         => 'Data Absensi Pengajar pada Angkatan Perkuliahan ' . $angkatan,
            'user'          => $user,
            'list'          => $list_absensi,
            'list_angkatan' => $list_angkatan,
            'angkatan_pilih' => $angkatan,
        ];
        return view('panel_admin/absensi/regular/pengajar', $data);
    }

    public function regular_pengajar_note()
    {
        if ($this->request->isAJAX()) {

            $absen_pengajar_id  = $this->request->getVar('absen_pengajar_id');
            $kelas_id           = $this->request->getVar('kelas_id');
            $data_kelas         = $this->kelas->find($kelas_id);
            $pengajar_id        = $data_kelas['pengajar_id'];
            $data_pengajar      = $this->pengajar->find($pengajar_id);
            $nama_pengajar      = $data_pengajar['nama_pengajar'];
            $nama_kelas         = $data_kelas['nama_kelas'];
            // Get data absen pengajar
            $absen_pengajar         = $this->absen_pengajar->find($absen_pengajar_id);

            $data = [
                'title'                  => 'Catatan Absen Pengajar Kelas ' . $nama_kelas,
                'pengajar'               => $nama_pengajar,
                'note_tm1'               => $absen_pengajar['note_tm1'],
                'note_tm2'               => $absen_pengajar['note_tm2'],
                'note_tm3'               => $absen_pengajar['note_tm3'],
                'note_tm4'               => $absen_pengajar['note_tm4'],
                'note_tm5'               => $absen_pengajar['note_tm5'],
                'note_tm6'               => $absen_pengajar['note_tm6'],
                'note_tm7'               => $absen_pengajar['note_tm7'],
                'note_tm8'               => $absen_pengajar['note_tm8'],
                'note_tm9'               => $absen_pengajar['note_tm9'],
                'note_tm10'              => $absen_pengajar['note_tm10'],
                'note_tm11'              => $absen_pengajar['note_tm11'],
                'note_tm12'              => $absen_pengajar['note_tm12'],
                'note_tm13'              => $absen_pengajar['note_tm13'],
                'note_tm14'              => $absen_pengajar['note_tm14'],
                'note_tm15'              => $absen_pengajar['note_tm15'],
                'note_tm16'              => $absen_pengajar['note_tm16'],

                'tgl_tm1'               => $absen_pengajar['tgl_tm1'],
                'tgl_tm2'               => $absen_pengajar['tgl_tm2'],
                'tgl_tm3'               => $absen_pengajar['tgl_tm3'],
                'tgl_tm4'               => $absen_pengajar['tgl_tm4'],
                'tgl_tm5'               => $absen_pengajar['tgl_tm5'],
                'tgl_tm6'               => $absen_pengajar['tgl_tm6'],
                'tgl_tm7'               => $absen_pengajar['tgl_tm7'],
                'tgl_tm8'               => $absen_pengajar['tgl_tm8'],
                'tgl_tm9'               => $absen_pengajar['tgl_tm9'],
                'tgl_tm10'              => $absen_pengajar['tgl_tm10'],
                'tgl_tm11'              => $absen_pengajar['tgl_tm11'],
                'tgl_tm12'              => $absen_pengajar['tgl_tm12'],
                'tgl_tm13'              => $absen_pengajar['tgl_tm13'],
                'tgl_tm14'              => $absen_pengajar['tgl_tm14'],
                'tgl_tm15'              => $absen_pengajar['tgl_tm15'],
                'tgl_tm16'              => $absen_pengajar['tgl_tm16'],

                'ts1'                   => $absen_pengajar['ts1'],
                'ts2'                   => $absen_pengajar['ts2'],
                'ts3'                   => $absen_pengajar['ts3'],
                'ts4'                   => $absen_pengajar['ts4'],
                'ts5'                   => $absen_pengajar['ts5'],
                'ts6'                   => $absen_pengajar['ts6'],
                'ts7'                   => $absen_pengajar['ts7'],
                'ts8'                   => $absen_pengajar['ts8'],
                'ts9'                   => $absen_pengajar['ts9'],
                'ts10'                  => $absen_pengajar['ts10'],
                'ts11'                  => $absen_pengajar['ts11'],
                'ts12'                  => $absen_pengajar['ts12'],
                'ts13'                  => $absen_pengajar['ts13'],
                'ts14'                  => $absen_pengajar['ts14'],
                'ts15'                  => $absen_pengajar['ts15'],
                'ts16'                  => $absen_pengajar['ts16'],

            ];
            $msg = [
                'sukses' => view('panel_admin/absensi/regular/pengajar_note', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function regular_penguji()
    {
        $user  = $this->userauth();
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_absensi       = $this->kelas->admin_rekap_absen_penguji($angkatan);

        $data = [
            'title'         => 'Data Absensi Penguji pada Angkatan Perkuliahan ' . $angkatan,
            'user'          => $user,
            'list'          => $list_absensi,
            'list_angkatan' => $list_angkatan,
            'angkatan_pilih' => $angkatan,
        ];
        return view('panel_admin/absensi/regular/penguji', $data);
    }

    public function bina_peserta()
    {
        $user  = $this->userauth();
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }

        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_absensi       = $this->bina_peserta->rekap_bina_absen($angkatan);
        // var_dump($list_absensi);

        $data = [
            'title'         => 'Data Absensi Peserta pada Angkatan Perkuliahan ' . $angkatan,
            'user'          => $user,
            'list'          => $list_absensi,
            'list_angkatan' => $list_angkatan,
            'angkatan_pilih' => $angkatan,
        ];
        return view('panel_admin/absensi/bina/peserta', $data);
    }

    public function nonreg_peserta()
    {
        $user          = $this->userauth();

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('tahun', $params)) {
            $tahun       = $params['tahun'];
        } else {
            $tahun       = date('Y');
        }
        $modul          = "list";
        $title          = "Data Absensi Peserta Non Reguler " . " Tahun " . $tahun;
        $list_kelas     = $this->nonreg_kelas->list($tahun);
        if (count($list_kelas) > 0) {
            $highest_tm_ambil = max(array_column($list_kelas, 'nk_tm_ambil'));
        } else {
            $highest_tm_ambil = 0;
        }
        $lists             = $this->nonreg_absen_peserta->list_rekap($tahun);
        // Process each record in the lists array
        $processed_lists = array_map(function ($record) {
            // Loop through each field in the record
            foreach ($record as $key => $value) {
                // Check if it's a napj field and not null
                if (preg_match('/^naps\d+$/', $key) && !is_null($value)) {
                    // Decode JSON string to array
                    $record[$key] = json_decode($value, true);
                }
            }
            return $record;
        }, $lists);

        $data = [
            'title'                => $title,
            'user'                => $user,
            'list_tahun'        => $this->nonreg_kelas->list_unik_tahun(),
            'tahun_pilih'       => $tahun,
            'modul'             => $modul,
            'highest_tm_ambil'  => $highest_tm_ambil,
            'processed_lists'   => $processed_lists,
        ];
        return view('panel_admin/absensi/nonreg/peserta', $data);
    }
    public function nonreg_pengajar()
    {
        $user          = $this->userauth();

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('tahun', $params)) {
            $tahun       = $params['tahun'];
        } else {
            $tahun       = date('Y');
        }
        $modul          = "list";
        $title          = "Data Absensi Pengajar Non Reguler " . " Tahun " . $tahun;
        $list_kelas     = $this->nonreg_kelas->list($tahun);
        if (count($list_kelas) > 0) {
            $highest_tm_ambil = max(array_column($list_kelas, 'nk_tm_ambil'));
        } else {
            $highest_tm_ambil = 0;
        }
        $lists             = $this->nonreg_absen_pengajar->list_rekap($tahun);
        // Process each record in the lists array
        $processed_lists = array_map(function ($record) {
            // Loop through each field in the record
            foreach ($record as $key => $value) {
                // Check if it's a napj field and not null
                if (preg_match('/^napj\d+$/', $key) && !is_null($value)) {
                    // Decode JSON string to array
                    $record[$key] = json_decode($value, true);
                }
            }
            return $record;
        }, $lists);

        $data = [
            'title'                => $title,
            'user'                => $user,
            'list_tahun'        => $this->nonreg_kelas->list_unik_tahun(),
            'tahun_pilih'       => $tahun,
            'modul'             => $modul,
            'highest_tm_ambil'  => $highest_tm_ambil,
            'processed_lists'   => $processed_lists,
        ];
        return view('panel_admin/absensi/nonreg/pengajar', $data);
    }

    public function nonreg_pengajar_note()
    {
        if ($this->request->isAJAX()) {

            $napj_id                = $this->request->getVar('napj_id');
            // Get data absen pengajar
            $absen_pengajar         = $this->nonreg_absen_pengajar->find($napj_id);
            $nonreg_pengajar        = $this->nonreg_pengajar->find($absen_pengajar['napj_pengajar']);
            $nonreg_kelas           = $this->nonreg_kelas->find($nonreg_pengajar['npj_kelas']);

            $absenTm = $this->nonreg_absen_pengajar
                ->join('nonreg_pengajar', 'nonreg_pengajar.npj_id = nonreg_absen_pengajar.napj_pengajar')
                ->where('npj_kelas', $nonreg_pengajar['npj_kelas'])
                // ->where('npj_pengajar', $pengajar_id)

                ->get()->getResultArray();

            if ($absenTm) {
                // Iterate through each key in the array
                foreach ($absenTm as $key => $value) {
                    // Check if the key matches the pattern 'tm' followed by a number and the value is not null
                    if (preg_match('/^napj\d+$/', $key) && !is_null($value)) {
                        // Decode the JSON string
                        $absenTm[$key] = json_decode($value, true);
                    }
                }
            }

            $absenTmNew = [];

            foreach ($absenTm as $record) {
                // Extract base information
                $baseInfo = [
                    'napj_id' => $record['napj_id'],
                    'napj_pengajar' => $record['napj_pengajar'],
                    'npj_id' => $record['npj_id'],
                    'npj_pengajar' => $record['npj_pengajar'],
                    'npj_kelas' => $record['npj_kelas']
                ];

                // Process napj1 through napj50
                for ($i = 1; $i <= 50; $i++) {
                    $napjKey = "napj{$i}";

                    if (!empty($record[$napjKey]) && $record[$napjKey] !== null) {
                        // Decode JSON data
                        $jsonData = json_decode($record[$napjKey], true);

                        if ($jsonData && is_array($jsonData)) {
                            // Create new row with base info + TM data
                            $newRow = array_merge($baseInfo, [
                                'tm_sequence' => $i, // Which napj field this came from
                                'tm' => $jsonData['tm'] ?? null,
                                'dt_tm' => $jsonData['dt_tm'] ?? null,
                                'dt_isi' => $jsonData['dt_isi'] ?? null,
                                'note' => $jsonData['note'] ?? null,
                                'by' => $jsonData['by'] ?? null
                            ]);

                            $absenTmNew[] = $newRow;
                        }
                    }
                }
            }

            $data = [
                'title'              => 'Catatan Absen Pengajar Kelas Nonreg ' . $nonreg_pengajar['npj_kelas'],
                'kelas'             => $nonreg_kelas,
                'absenTmNew'         => $absenTmNew
            ];
            $msg = [
                'sukses' => view('panel_admin/absensi/nonreg/pengajar_note', $data)
            ];
            echo json_encode($msg);
        }
    }

    //backend
    public function regular_peserta_export()
    {
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        $absen_peserta = $this->peserta_kelas->admin_rekap_absen_peserta($angkatan);
        $total_row     = count($absen_peserta) + 5;

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

        $judul = "DATA REKAP ABSEN PESERTA - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = "ANGKATAN PERKULIAHAN " . $angkatan . " - " . date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:AD1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:AD2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:AD4')->applyFromArray($style_up);

        $sheet->getStyle('A5:AD' . $total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NIS')
            ->setCellValue('B4', 'NAMA')
            ->setCellValue('C4', 'KELAS')
            ->setCellValue('D4', 'CABANG')
            ->setCellValue('E4', 'JENIS KELAMIN')
            ->setCellValue('F4', 'PROGRAM')
            ->setCellValue('G4', 'HARI')
            ->setCellValue('H4', 'WAKTU')
            ->setCellValue('I4', 'PENGAJAR')
            ->setCellValue('J4', 'LEVEL')
            ->setCellValue('K4', 'METODE TATAP MUKA')
            ->setCellValue('L4', 'ANGKATAN KULIAH')
            ->setCellValue('M4', 'STATUS PESERTA')
            ->setCellValue('N4', 'TM1')
            ->setCellValue('O4', 'TM2')
            ->setCellValue('P4', 'TM3')
            ->setCellValue('Q4', 'TM4')
            ->setCellValue('R4', 'TM5')
            ->setCellValue('S4', 'TM6')
            ->setCellValue('T4', 'TM7')
            ->setCellValue('U4', 'TM8')
            ->setCellValue('V4', 'TM9')
            ->setCellValue('W4', 'TM10')
            ->setCellValue('X4', 'TM11')
            ->setCellValue('Y4', 'TM12')
            ->setCellValue('Z4', 'TM13')
            ->setCellValue('AA4', 'TM14')
            ->setCellValue('AB4', 'TM15')
            ->setCellValue('AC4', 'TM16')
            ->setCellValue('AD4', 'TOTAL HADIR');

        // ->setCellValue('AE4', 'TGL TM1')
        // ->setCellValue('AF4', 'TGL TM2')
        // ->setCellValue('AG4', 'TGL TM3')
        // ->setCellValue('AH4', 'TGL TM4')
        // ->setCellValue('AI4', 'TGL TM5')
        // ->setCellValue('AJ4', 'TGL TM6')
        // ->setCellValue('AK4', 'TGL TM7')
        // ->setCellValue('AL4', 'TGL TM8')

        // ->setCellValue('AM4', 'TGL TM9')
        // ->setCellValue('AN4', 'TGL TM10')
        // ->setCellValue('AO4', 'TGL TM11')
        // ->setCellValue('AP4', 'TGL TM12')
        // ->setCellValue('AQ4', 'TGL TM13')
        // ->setCellValue('AR4', 'TGL TM14')
        // ->setCellValue('AS4', 'TGL TM15')
        // ->setCellValue('AT4', 'TGL TM16');

        $columns = range('A', 'Z');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);

        $row = 5;

        foreach ($absen_peserta as $absen) {
            $total = $absen['tm1'] + $absen['tm2'] + $absen['tm3'] + $absen['tm4'] + $absen['tm5'] + $absen['tm6'] + $absen['tm7'] + $absen['tm8'] + $absen['tm9'] + $absen['tm10'] + $absen['tm11'] + $absen['tm12'] + $absen['tm13'] + $absen['tm14'] + $absen['tm15'] + $absen['tm16'];

            if ($absen['tgl_tm1'] == '2022-01-01') {
                $tgl_tm1 = '';
            } else {
                $tgl_tm1 = $absen['tgl_tm1'];
            };
            if ($absen['tgl_tm2'] == '2022-01-01') {
                $tgl_tm2 = '';
            } else {
                $tgl_tm2 = $absen['tgl_tm2'];
            };
            if ($absen['tgl_tm3'] == '2022-01-01') {
                $tgl_tm3 = '';
            } else {
                $tgl_tm3 = $absen['tgl_tm3'];
            };
            if ($absen['tgl_tm4'] == '2022-01-01') {
                $tgl_tm4 = '';
            } else {
                $tgl_tm4 = $absen['tgl_tm4'];
            };
            if ($absen['tgl_tm5'] == '2022-01-01') {
                $tgl_tm5 = '';
            } else {
                $tgl_tm5 = $absen['tgl_tm5'];
            };
            if ($absen['tgl_tm6'] == '2022-01-01') {
                $tgl_tm6 = '';
            } else {
                $tgl_tm6 = $absen['tgl_tm6'];
            };
            if ($absen['tgl_tm7'] == '2022-01-01') {
                $tgl_tm7 = '';
            } else {
                $tgl_tm7 = $absen['tgl_tm7'];
            };
            if ($absen['tgl_tm8'] == '2022-01-01') {
                $tgl_tm8 = '';
            } else {
                $tgl_tm8 = $absen['tgl_tm8'];
            };
            if ($absen['tgl_tm9'] == '2022-01-01') {
                $tgl_tm9 = '';
            } else {
                $tgl_tm9 = $absen['tgl_tm9'];
            };
            if ($absen['tgl_tm10'] == '2022-01-01') {
                $tgl_tm10 = '';
            } else {
                $tgl_tm10 = $absen['tgl_tm10'];
            };
            if ($absen['tgl_tm11'] == '2022-01-01') {
                $tgl_tm11 = '';
            } else {
                $tgl_tm11 = $absen['tgl_tm11'];
            };
            if ($absen['tgl_tm12'] == '2022-01-01') {
                $tgl_tm12 = '';
            } else {
                $tgl_tm12 = $absen['tgl_tm12'];
            };
            if ($absen['tgl_tm13'] == '2022-01-01') {
                $tgl_tm13 = '';
            } else {
                $tgl_tm13 = $absen['tgl_tm13'];
            };
            if ($absen['tgl_tm14'] == '2022-01-01') {
                $tgl_tm14 = '';
            } else {
                $tgl_tm14 = $absen['tgl_tm14'];
            };
            if ($absen['tgl_tm15'] == '2022-01-01') {
                $tgl_tm15 = '';
            } else {
                $tgl_tm15 = $absen['tgl_tm15'];
            };
            if ($absen['tgl_tm16'] == '2022-01-01') {
                $tgl_tm16 = '';
            } else {
                $tgl_tm16 = $absen['tgl_tm16'];
            };
            //-----------------------------
            if ($absen['tm1'] == '1') {
                $absen_tm1 = $tgl_tm1;
            } elseif ($absen['tm1'] == '0') {
                $absen_tm1 = '--';
            } else {
                $absen_tm1 = '';
            };

            if ($absen['tm2'] == '1') {
                $absen_tm2 = $tgl_tm2;
            } elseif ($absen['tm2'] == '0') {
                $absen_tm2 = '--';
            } else {
                $absen_tm2 = '';
            };

            if ($absen['tm3'] == '1') {
                $absen_tm3 = $tgl_tm3;
            } elseif ($absen['tm3'] == '0') {
                $absen_tm3 = '--';
            } else {
                $absen_tm3 = '';
            };

            if ($absen['tm4'] == '1') {
                $absen_tm4 = $tgl_tm4;
            } elseif ($absen['tm4'] == '0') {
                $absen_tm4 = '--';
            } else {
                $absen_tm4 = '';
            };

            if ($absen['tm5'] == '1') {
                $absen_tm5 = $tgl_tm5;
            } elseif ($absen['tm5'] == '0') {
                $absen_tm5 = '--';
            } else {
                $absen_tm5 = '';
            };

            if ($absen['tm6'] == '1') {
                $absen_tm6 = $tgl_tm6;
            } elseif ($absen['tm6'] == '0') {
                $absen_tm6 = '--';
            } else {
                $absen_tm6 = '';
            };

            if ($absen['tm7'] == '1') {
                $absen_tm7 = $tgl_tm7;
            } elseif ($absen['tm7'] == '0') {
                $absen_tm7 = '--';
            } else {
                $absen_tm7 = '';
            };

            if ($absen['tm8'] == '1') {
                $absen_tm8 = $tgl_tm8;
            } elseif ($absen['tm8'] == '0') {
                $absen_tm8 = '--';
            } else {
                $absen_tm8 = '';
            };

            if ($absen['tm9'] == '1') {
                $absen_tm9 = $tgl_tm9;
            } elseif ($absen['tm9'] == '0') {
                $absen_tm9 = '--';
            } else {
                $absen_tm9 = '';
            };

            if ($absen['tm10'] == '1') {
                $absen_tm10 = $tgl_tm10;
            } elseif ($absen['tm10'] == '0') {
                $absen_tm10 = '--';
            } else {
                $absen_tm10 = '';
            };

            if ($absen['tm11'] == '1') {
                $absen_tm11 = $tgl_tm11;
            } elseif ($absen['tm11'] == '0') {
                $absen_tm11 = '--';
            } else {
                $absen_tm11 = '';
            };

            if ($absen['tm12'] == '1') {
                $absen_tm12 = $tgl_tm12;
            } elseif ($absen['tm12'] == '0') {
                $absen_tm12 = '--';
            } else {
                $absen_tm12 = '';
            };

            if ($absen['tm13'] == '1') {
                $absen_tm13 = $tgl_tm13;
            } elseif ($absen['tm13'] == '0') {
                $absen_tm13 = '--';
            } else {
                $absen_tm13 = '';
            };

            if ($absen['tm14'] == '1') {
                $absen_tm14 = $tgl_tm14;
            } elseif ($absen['tm14'] == '0') {
                $absen_tm14 = '--';
            } else {
                $absen_tm14 = '';
            };

            if ($absen['tm15'] == '1') {
                $absen_tm15 = $tgl_tm15;
            } elseif ($absen['tm15'] == '0') {
                $absen_tm15 = '--';
            } else {
                $absen_tm15 = '';
            };

            if ($absen['tm16'] == '1') {
                $absen_tm16 = $tgl_tm16;
            } elseif ($absen['tm16'] == '0') {
                $absen_tm16 = '--';
            } else {
                $absen_tm16 = '';
            };

            if ($absen['status_aktif_peserta'] == NULL) {
                $status_aktif_peserta = 'AKTIF';
            } else {
                $status_aktif_peserta = $absen['status_aktif_peserta'];
            }


            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $absen['nis'])
                ->setCellValue('B' . $row, $absen['nama_peserta'])
                ->setCellValue('C' . $row, $absen['nama_kelas'])

                ->setCellValue('D' . $row, 'LTTQ ALHAQQ PUSAT')
                ->setCellValue('E' . $row, $absen['jenkel'])
                ->setCellValue('F' . $row, $absen['nama_program'])
                ->setCellValue('G' . $row, $absen['hari_kelas'])
                ->setCellValue('H' . $row, $absen['waktu_kelas'] . ' ' . $absen['zona_waktu_kelas'])
                ->setCellValue('I' . $row, $absen['nama_pengajar'])
                ->setCellValue('J' . $row, $absen['nama_level'])
                ->setCellValue('K' . $row, $absen['metode_kelas'])

                ->setCellValue('L' . $row, $absen['angkatan_kelas'])
                ->setCellValue('M' . $row, $status_aktif_peserta)
                ->setCellValue('N' . $row, $absen_tm1)
                ->setCellValue('O' . $row, $absen_tm2)
                ->setCellValue('P' . $row, $absen_tm3)
                ->setCellValue('Q' . $row, $absen_tm4)
                ->setCellValue('R' . $row, $absen_tm5)
                ->setCellValue('S' . $row, $absen_tm6)
                ->setCellValue('T' . $row, $absen_tm7)
                ->setCellValue('U' . $row, $absen_tm8)
                ->setCellValue('V' . $row, $absen_tm9)
                ->setCellValue('W' . $row, $absen_tm10)
                ->setCellValue('X' . $row, $absen_tm11)
                ->setCellValue('Y' . $row, $absen_tm12)
                ->setCellValue('Z' . $row, $absen_tm13)
                ->setCellValue('AA' . $row, $absen_tm14)
                ->setCellValue('AB' . $row, $absen_tm15)
                ->setCellValue('AC' . $row, $absen_tm16)
                ->setCellValue('AD' . $row, $total);

            // ->setCellValue('AE' . $row, $tgl_tm1)
            // ->setCellValue('AF' . $row, $tgl_tm2)
            // ->setCellValue('AG' . $row, $tgl_tm3)
            // ->setCellValue('AH' . $row, $tgl_tm4)
            // ->setCellValue('AI' . $row, $tgl_tm5)
            // ->setCellValue('AJ' . $row, $tgl_tm6)
            // ->setCellValue('AK' . $row, $tgl_tm7)
            // ->setCellValue('AL' . $row, $tgl_tm8)

            // ->setCellValue('AM' . $row, $tgl_tm9)
            // ->setCellValue('AN' . $row, $tgl_tm10)
            // ->setCellValue('AO' . $row, $tgl_tm11)
            // ->setCellValue('AP' . $row, $tgl_tm12)
            // ->setCellValue('AQ' . $row, $tgl_tm13)
            // ->setCellValue('AR' . $row, $tgl_tm14)
            // ->setCellValue('AS' . $row, $tgl_tm15)
            // ->setCellValue('AT' . $row, $tgl_tm16);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Absen-Peserta-Angkatan' . $angkatan . '-' . date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Absen Peserta via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function regular_pengajar_export()
    {
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }

        $absen_pengajar =  $this->kelas->admin_rekap_absen_pengajar($angkatan);
        $judul = "DATA REKAP ABSEN PENGAJAR ANGKATAN PERKULIAHAN " . $angkatan;
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

        $border = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $borderall = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:BC1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', date("Y-m-d"));
        $sheet->mergeCells('A2:BC2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->mergeCells('X3:AM3');
        $sheet->mergeCells('AO3:BD3');
        // $sheet->mergeCells('BF3:BU3');
        $sheet->setCellValue('X3', 'TANGGAL TATAP MUKA');
        $sheet->setCellValue('AO3', 'CATATAN');

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'ID PENGAJAR')
            ->setCellValue('B4', 'NAMA PENGAJAR')
            ->setCellValue('C4', 'CABANG')
            ->setCellValue('D4', 'KELAS')
            ->setCellValue('E4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('F4', 'TM1')
            ->setCellValue('G4', 'TM2')
            ->setCellValue('H4', 'TM3')
            ->setCellValue('I4', 'TM4')
            ->setCellValue('J4', 'TM5')
            ->setCellValue('K4', 'TM6')
            ->setCellValue('L4', 'TM7')
            ->setCellValue('M4', 'TM8')
            ->setCellValue('N4', 'TM9')
            ->setCellValue('O4', 'TM10')
            ->setCellValue('P4', 'TM11')
            ->setCellValue('Q4', 'TM12')
            ->setCellValue('R4', 'TM13')
            ->setCellValue('S4', 'TM14')
            ->setCellValue('T4', 'TM15')
            ->setCellValue('U4', 'TM16')
            ->setCellValue('V4', 'TOTAL HADIR')

            // ->setCellValue('X4', 'TGL TM1')
            // ->setCellValue('Y4', 'TGL TM2')
            // ->setCellValue('Z4', 'TGL TM3')
            // ->setCellValue('AA4', 'TGL TM4')
            // ->setCellValue('AB4', 'TGL TM5')
            // ->setCellValue('AC4', 'TGL TM6')
            // ->setCellValue('AD4', 'TGL TM7')           
            // ->setCellValue('AE4', 'TGL TM8')
            // ->setCellValue('AF4', 'TGL TM9')
            // ->setCellValue('AG4', 'TGL TM10')
            // ->setCellValue('AH4', 'TGL TM11')
            // ->setCellValue('AI4', 'TGL TM12')
            // ->setCellValue('AJ4', 'TGL TM13')
            // ->setCellValue('AK4', 'TGL TM14')
            // ->setCellValue('AL4', 'TGL TM15')
            // ->setCellValue('AM4', 'TGL TM16')

            ->setCellValue('X4', 'TS TM1')
            ->setCellValue('Y4', 'TS TM2')
            ->setCellValue('Z4', 'TS TM3')
            ->setCellValue('AA4', 'TS TM4')
            ->setCellValue('AB4', 'TS TM5')
            ->setCellValue('AC4', 'TS TM6')
            ->setCellValue('AD4', 'TS TM7')
            ->setCellValue('AE4', 'TS TM8')
            ->setCellValue('AF4', 'TS TM9')
            ->setCellValue('AG4', 'TS TM10')
            ->setCellValue('AH4', 'TS TM11')
            ->setCellValue('AI4', 'TS TM12')
            ->setCellValue('AJ4', 'TS TM13')
            ->setCellValue('AK4', 'TS TM14')
            ->setCellValue('AL4', 'TS TM15')
            ->setCellValue('AM4', 'TS TM16')

            ->setCellValue('AO4', 'NOTE TM1')
            ->setCellValue('AP4', 'NOTE TM2')
            ->setCellValue('AQ4', 'NOTE TM3')
            ->setCellValue('AR4', 'NOTE TM4')
            ->setCellValue('AS4', 'NOTE TM5')
            ->setCellValue('AT4', 'NOTE TM6')
            ->setCellValue('AU4', 'NOTE TM7')
            ->setCellValue('AV4', 'NOTE TM8')
            ->setCellValue('AW4', 'NOTE TM9')
            ->setCellValue('AX4', 'NOTE TM10')
            ->setCellValue('AY4', 'NOTE TM11')
            ->setCellValue('AZ4', 'NOTE TM12')
            ->setCellValue('BA4', 'NOTE TM13')
            ->setCellValue('BB4', 'NOTE TM14')
            ->setCellValue('BC4', 'NOTE TM15')
            ->setCellValue('BD4', 'NOTE TM16');

        $sheet->getStyle('A4:V4')->applyFromArray($borderall);
        $sheet->getStyle('X4:AM4')->applyFromArray($borderall);
        $sheet->getStyle('AO4:BD4')->applyFromArray($borderall);
        // $sheet->getStyle('BF4:BU4')->applyFromArray($borderall);

        $sheet->getStyle('X3')->applyFromArray($borderall);
        $sheet->getStyle('AO3')->applyFromArray($borderall);
        $sheet->getStyle('BF3')->applyFromArray($borderall);

        $sheet->getStyle('BF5:BU500')->getAlignment()->setWrapText(true);
        $sheet->getStyle('E4')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(34);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(37);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12.5);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AF')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AG')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AH')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AI')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AJ')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AK')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AL')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AM')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getColumnDimension('AO')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AP')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AQ')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AR')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AS')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AT')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AU')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AV')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AW')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AX')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AY')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AZ')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('BA')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('BB')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('BC')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('BD')->setAutoSize(true);

        // $spreadsheet->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BG')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BH')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BI')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BJ')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BK')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BL')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BM')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BN')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BO')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BP')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BQ')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BR')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BS')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BT')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('BU')->setWidth(20);


        $row = 5;

        foreach ($absen_pengajar as $absen) {
            $total = $absen['tm1_pengajar'] + $absen['tm2_pengajar'] + $absen['tm3_pengajar'] + $absen['tm4_pengajar'] + $absen['tm5_pengajar'] + $absen['tm6_pengajar'] + $absen['tm7_pengajar'] + $absen['tm8_pengajar'] + $absen['tm9_pengajar'] + $absen['tm10_pengajar'] + $absen['tm11_pengajar'] + $absen['tm12_pengajar'] + $absen['tm13_pengajar'] + $absen['tm14_pengajar'] + $absen['tm15_pengajar'] + $absen['tm16_pengajar'];

            if ($absen['tgl_tm1'] == '2022-01-01') {
                $tgl_tm1 = '';
            } else {
                $tgl_tm1 = $absen['tgl_tm1'];
            };
            if ($absen['tgl_tm2'] == '2022-01-01') {
                $tgl_tm2 = '';
            } else {
                $tgl_tm2 = $absen['tgl_tm2'];
            };
            if ($absen['tgl_tm3'] == '2022-01-01') {
                $tgl_tm3 = '';
            } else {
                $tgl_tm3 = $absen['tgl_tm3'];
            };
            if ($absen['tgl_tm4'] == '2022-01-01') {
                $tgl_tm4 = '';
            } else {
                $tgl_tm4 = $absen['tgl_tm4'];
            };
            if ($absen['tgl_tm5'] == '2022-01-01') {
                $tgl_tm5 = '';
            } else {
                $tgl_tm5 = $absen['tgl_tm5'];
            };
            if ($absen['tgl_tm6'] == '2022-01-01') {
                $tgl_tm6 = '';
            } else {
                $tgl_tm6 = $absen['tgl_tm6'];
            };
            if ($absen['tgl_tm7'] == '2022-01-01') {
                $tgl_tm7 = '';
            } else {
                $tgl_tm7 = $absen['tgl_tm7'];
            };
            if ($absen['tgl_tm8'] == '2022-01-01') {
                $tgl_tm8 = '';
            } else {
                $tgl_tm8 = $absen['tgl_tm8'];
            };
            if ($absen['tgl_tm9'] == '2022-01-01') {
                $tgl_tm9 = '';
            } else {
                $tgl_tm9 = $absen['tgl_tm9'];
            };
            if ($absen['tgl_tm10'] == '2022-01-01') {
                $tgl_tm10 = '';
            } else {
                $tgl_tm10 = $absen['tgl_tm10'];
            };
            if ($absen['tgl_tm11'] == '2022-01-01') {
                $tgl_tm11 = '';
            } else {
                $tgl_tm11 = $absen['tgl_tm11'];
            };
            if ($absen['tgl_tm12'] == '2022-01-01') {
                $tgl_tm12 = '';
            } else {
                $tgl_tm12 = $absen['tgl_tm12'];
            };
            if ($absen['tgl_tm13'] == '2022-01-01') {
                $tgl_tm13 = '';
            } else {
                $tgl_tm13 = $absen['tgl_tm13'];
            };
            if ($absen['tgl_tm14'] == '2022-01-01') {
                $tgl_tm14 = '';
            } else {
                $tgl_tm14 = $absen['tgl_tm14'];
            };
            if ($absen['tgl_tm15'] == '2022-01-01') {
                $tgl_tm15 = '';
            } else {
                $tgl_tm15 = $absen['tgl_tm15'];
            };
            if ($absen['tgl_tm16'] == '2022-01-01') {
                $tgl_tm16 = '';
            } else {
                $tgl_tm16 = $absen['tgl_tm16'];
            };

            //-----------------------------
            if ($absen['tm1_pengajar'] == '1') {
                $absen_tm1 = $tgl_tm1;
            } elseif ($absen['tm1_pengajar'] == '0') {
                $absen_tm1 = '--';
            } else {
                $absen_tm1 = '';
            };

            if ($absen['tm2_pengajar'] == '1') {
                $absen_tm2 = $tgl_tm2;
            } elseif ($absen['tm2_pengajar'] == '0') {
                $absen_tm2 = '--';
            } else {
                $absen_tm2 = '';
            };

            if ($absen['tm3_pengajar'] == '1') {
                $absen_tm3 = $tgl_tm3;
            } elseif ($absen['tm3_pengajar'] == '0') {
                $absen_tm3 = '--';
            } else {
                $absen_tm3 = '';
            };

            if ($absen['tm4_pengajar'] == '1') {
                $absen_tm4 = $tgl_tm4;
            } elseif ($absen['tm4_pengajar'] == '0') {
                $absen_tm4 = '--';
            } else {
                $absen_tm4 = '';
            };

            if ($absen['tm5_pengajar'] == '1') {
                $absen_tm5 = $tgl_tm5;
            } elseif ($absen['tm5_pengajar'] == '0') {
                $absen_tm5 = '--';
            } else {
                $absen_tm5 = '';
            };

            if ($absen['tm6_pengajar'] == '1') {
                $absen_tm6 = $tgl_tm6;
            } elseif ($absen['tm6_pengajar'] == '0') {
                $absen_tm6 = '--';
            } else {
                $absen_tm6 = '';
            };

            if ($absen['tm7_pengajar'] == '1') {
                $absen_tm7 = $tgl_tm7;
            } elseif ($absen['tm7_pengajar'] == '0') {
                $absen_tm7 = '--';
            } else {
                $absen_tm7 = '';
            };

            if ($absen['tm8_pengajar'] == '1') {
                $absen_tm8 = $tgl_tm8;
            } elseif ($absen['tm8_pengajar'] == '0') {
                $absen_tm8 = '--';
            } else {
                $absen_tm8 = '';
            };

            if ($absen['tm9_pengajar'] == '1') {
                $absen_tm9 = $tgl_tm9;
            } elseif ($absen['tm9_pengajar'] == '0') {
                $absen_tm9 = '--';
            } else {
                $absen_tm9 = '';
            };

            if ($absen['tm10_pengajar'] == '1') {
                $absen_tm10 = $tgl_tm10;
            } elseif ($absen['tm10_pengajar'] == '0') {
                $absen_tm10 = '--';
            } else {
                $absen_tm10 = '';
            };

            if ($absen['tm11_pengajar'] == '1') {
                $absen_tm11 = $tgl_tm11;
            } elseif ($absen['tm11_pengajar'] == '0') {
                $absen_tm11 = '--';
            } else {
                $absen_tm11 = '';
            };

            if ($absen['tm12_pengajar'] == '1') {
                $absen_tm12 = $tgl_tm12;
            } elseif ($absen['tm12_pengajar'] == '0') {
                $absen_tm12 = '--';
            } else {
                $absen_tm12 = '';
            };

            if ($absen['tm13_pengajar'] == '1') {
                $absen_tm13 = $tgl_tm13;
            } elseif ($absen['tm13_pengajar'] == '0') {
                $absen_tm13 = '--';
            } else {
                $absen_tm13 = '';
            };

            if ($absen['tm14_pengajar'] == '1') {
                $absen_tm14 = $tgl_tm14;
            } elseif ($absen['tm14_pengajar'] == '0') {
                $absen_tm14 = '--';
            } else {
                $absen_tm14 = '';
            };

            if ($absen['tm15_pengajar'] == '1') {
                $absen_tm15 = $tgl_tm15;
            } elseif ($absen['tm15_pengajar'] == '0') {
                $absen_tm15 = '--';
            } else {
                $absen_tm15 = '';
            };

            if ($absen['tm16_pengajar'] == '1') {
                $absen_tm16 = $tgl_tm16;
            } elseif ($absen['tm16_pengajar'] == '0') {
                $absen_tm16 = '--';
            } else {
                $absen_tm16 = '';
            };

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $absen['pengajar_id'])
                ->setCellValue('B' . $row, $absen['nama_pengajar'])
                ->setCellValue('C' . $row, $absen['nama_kantor'])
                ->setCellValue('D' . $row, $absen['nama_kelas'])
                ->setCellValue('E' . $row, $absen['angkatan_kelas'])
                ->setCellValue('F' . $row, $absen_tm1)
                ->setCellValue('G' . $row, $absen_tm2)
                ->setCellValue('H' . $row, $absen_tm3)
                ->setCellValue('I' . $row, $absen_tm4)
                ->setCellValue('J' . $row, $absen_tm5)
                ->setCellValue('K' . $row, $absen_tm6)
                ->setCellValue('L' . $row, $absen_tm7)
                ->setCellValue('M' . $row, $absen_tm8)
                ->setCellValue('N' . $row, $absen_tm9)
                ->setCellValue('O' . $row, $absen_tm10)
                ->setCellValue('P' . $row, $absen_tm11)
                ->setCellValue('Q' . $row, $absen_tm12)
                ->setCellValue('R' . $row, $absen_tm13)
                ->setCellValue('S' . $row, $absen_tm14)
                ->setCellValue('T' . $row, $absen_tm15)
                ->setCellValue('U' . $row, $absen_tm16)
                ->setCellValue('V' . $row, $total)

                // ->setCellValue('X' . $row, $tgl_tm1)  
                // ->setCellValue('Y' . $row, $tgl_tm2)    
                // ->setCellValue('Z' . $row, $tgl_tm3) 
                // ->setCellValue('AA' . $row, $tgl_tm4)
                // ->setCellValue('AB' . $row, $tgl_tm5)
                // ->setCellValue('AC' . $row, $tgl_tm6)
                // ->setCellValue('AD' . $row, $tgl_tm7)
                // ->setCellValue('AE' . $row, $tgl_tm8)
                // ->setCellValue('AF' . $row, $tgl_tm9)
                // ->setCellValue('AG' . $row, $tgl_tm10)
                // ->setCellValue('AH' . $row, $tgl_tm11)
                // ->setCellValue('AI' . $row, $tgl_tm12)
                // ->setCellValue('AJ' . $row, $tgl_tm13)
                // ->setCellValue('AK' . $row, $tgl_tm14)
                // ->setCellValue('AL' . $row, $tgl_tm15)
                // ->setCellValue('AM' . $row, $tgl_tm16)

                ->setCellValue('X' . $row,  $absen['ts1'])
                ->setCellValue('Y' . $row,  $absen['ts2'])
                ->setCellValue('Z' . $row, $absen['ts3'])
                ->setCellValue('AA' . $row, $absen['ts4'])
                ->setCellValue('AB' . $row, $absen['ts5'])
                ->setCellValue('AC' . $row, $absen['ts6'])
                ->setCellValue('AD' . $row, $absen['ts7'])
                ->setCellValue('AE' . $row, $absen['ts8'])
                ->setCellValue('AF' . $row, $absen['ts9'])
                ->setCellValue('AG' . $row, $absen['ts10'])
                ->setCellValue('AH' . $row, $absen['ts11'])
                ->setCellValue('AI' . $row, $absen['ts12'])
                ->setCellValue('AJ' . $row, $absen['ts13'])
                ->setCellValue('AK' . $row, $absen['ts14'])
                ->setCellValue('AL' . $row, $absen['ts15'])
                ->setCellValue('AM' . $row, $absen['ts16'])

                ->setCellValue('AO' . $row, $absen['note_tm1'])
                ->setCellValue('AP' . $row, $absen['note_tm2'])
                ->setCellValue('AQ' . $row, $absen['note_tm3'])
                ->setCellValue('AR' . $row, $absen['note_tm4'])
                ->setCellValue('AS' . $row, $absen['note_tm5'])
                ->setCellValue('AT' . $row, $absen['note_tm6'])
                ->setCellValue('AU' . $row, $absen['note_tm7'])
                ->setCellValue('AV' . $row, $absen['note_tm8'])
                ->setCellValue('AW' . $row, $absen['note_tm9'])
                ->setCellValue('AX' . $row, $absen['note_tm10'])
                ->setCellValue('AY' . $row, $absen['note_tm11'])
                ->setCellValue('AZ' . $row, $absen['note_tm12'])
                ->setCellValue('BA' . $row, $absen['note_tm13'])
                ->setCellValue('BB' . $row, $absen['note_tm14'])
                ->setCellValue('BC' . $row, $absen['note_tm15'])
                ->setCellValue('BD' . $row, $absen['note_tm16']);

            $sheet->getStyle('A' . $row)->applyFromArray($border);
            $sheet->getStyle('B' . $row)->applyFromArray($border);
            $sheet->getStyle('C' . $row)->applyFromArray($border);
            $sheet->getStyle('D' . $row)->applyFromArray($border);
            $sheet->getStyle('E' . $row)->applyFromArray($border);
            $sheet->getStyle('F' . $row)->applyFromArray($border);
            $sheet->getStyle('G' . $row)->applyFromArray($border);
            $sheet->getStyle('H' . $row)->applyFromArray($border);
            $sheet->getStyle('I' . $row)->applyFromArray($border);
            $sheet->getStyle('J' . $row)->applyFromArray($border);
            $sheet->getStyle('K' . $row)->applyFromArray($border);
            $sheet->getStyle('L' . $row)->applyFromArray($border);
            $sheet->getStyle('M' . $row)->applyFromArray($border);
            $sheet->getStyle('N' . $row)->applyFromArray($border);
            $sheet->getStyle('O' . $row)->applyFromArray($border);
            $sheet->getStyle('P' . $row)->applyFromArray($border);
            $sheet->getStyle('Q' . $row)->applyFromArray($border);
            $sheet->getStyle('R' . $row)->applyFromArray($border);
            $sheet->getStyle('S' . $row)->applyFromArray($border);
            $sheet->getStyle('T' . $row)->applyFromArray($border);
            $sheet->getStyle('U' . $row)->applyFromArray($border);
            $sheet->getStyle('V' . $row)->applyFromArray($border);

            $sheet->getStyle('X' . $row)->applyFromArray($border);
            $sheet->getStyle('Y' . $row)->applyFromArray($border);
            $sheet->getStyle('Z' . $row)->applyFromArray($border);
            $sheet->getStyle('AA' . $row)->applyFromArray($border);
            $sheet->getStyle('AB' . $row)->applyFromArray($border);
            $sheet->getStyle('AC' . $row)->applyFromArray($border);
            $sheet->getStyle('AD' . $row)->applyFromArray($border);
            $sheet->getStyle('AE' . $row)->applyFromArray($border);
            $sheet->getStyle('AF' . $row)->applyFromArray($border);
            $sheet->getStyle('AG' . $row)->applyFromArray($border);
            $sheet->getStyle('AH' . $row)->applyFromArray($border);
            $sheet->getStyle('AI' . $row)->applyFromArray($border);
            $sheet->getStyle('AJ' . $row)->applyFromArray($border);
            $sheet->getStyle('AK' . $row)->applyFromArray($border);
            $sheet->getStyle('AL' . $row)->applyFromArray($border);
            $sheet->getStyle('AM' . $row)->applyFromArray($border);

            $sheet->getStyle('AO' . $row)->applyFromArray($border);
            $sheet->getStyle('AP' . $row)->applyFromArray($border);
            $sheet->getStyle('AQ' . $row)->applyFromArray($border);
            $sheet->getStyle('AR' . $row)->applyFromArray($border);
            $sheet->getStyle('AS' . $row)->applyFromArray($border);
            $sheet->getStyle('AT' . $row)->applyFromArray($border);
            $sheet->getStyle('AU' . $row)->applyFromArray($border);
            $sheet->getStyle('AV' . $row)->applyFromArray($border);
            $sheet->getStyle('AW' . $row)->applyFromArray($border);
            $sheet->getStyle('AX' . $row)->applyFromArray($border);
            $sheet->getStyle('AY' . $row)->applyFromArray($border);
            $sheet->getStyle('AZ' . $row)->applyFromArray($border);
            $sheet->getStyle('BA' . $row)->applyFromArray($border);
            $sheet->getStyle('BB' . $row)->applyFromArray($border);
            $sheet->getStyle('BC' . $row)->applyFromArray($border);
            $sheet->getStyle('BD' . $row)->applyFromArray($border);

            // $sheet->getStyle('BF'. $row)->applyFromArray($border);
            // $sheet->getStyle('BG'. $row)->applyFromArray($border);
            // $sheet->getStyle('BH'. $row)->applyFromArray($border);
            // $sheet->getStyle('BI'. $row)->applyFromArray($border);
            // $sheet->getStyle('BJ'. $row)->applyFromArray($border);
            // $sheet->getStyle('BK'. $row)->applyFromArray($border);
            // $sheet->getStyle('BL'. $row)->applyFromArray($border);
            // $sheet->getStyle('BM'. $row)->applyFromArray($border);
            // $sheet->getStyle('BN'. $row)->applyFromArray($border);
            // $sheet->getStyle('BO'. $row)->applyFromArray($border);
            // $sheet->getStyle('BP'. $row)->applyFromArray($border);
            // $sheet->getStyle('BQ'. $row)->applyFromArray($border);
            // $sheet->getStyle('BR'. $row)->applyFromArray($border);
            // $sheet->getStyle('BS'. $row)->applyFromArray($border);
            // $sheet->getStyle('BT'. $row)->applyFromArray($border);
            // $sheet->getStyle('BU'. $row)->applyFromArray($border);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Absen-Pengajar-' . date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Absen Pengajar via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function regular_penguji_export()
    {
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }

        $absen_penguji =  $this->kelas->admin_rekap_absen_penguji($angkatan);
        $judul = "DATA REKAP ABSEN PENGUJI ANGKATAN PERKULIAHAN " . $angkatan;
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

        $border = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $borderall = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', date("Y-m-d"));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'ID PENGAJAR')
            ->setCellValue('B4', 'NAMA PENGUJI')
            ->setCellValue('C4', 'CABANG')
            ->setCellValue('D4', 'KELAS')
            ->setCellValue('E4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('F4', 'WAKTU ABSEN');

        $sheet->getStyle('A4:F4')->applyFromArray($borderall);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(34);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(37);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12.5);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);


        $row = 5;

        foreach ($absen_penguji as $absen) {

            if ($absen['absen_penguji'] != NULL) {
                $waktu_absen = $absen['absen_penguji'];
            } else {
                $waktu_absen = '';
            };

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $absen['pengajar_id'])
                ->setCellValue('B' . $row, $absen['nama_pengajar'])
                ->setCellValue('C' . $row, $absen['nama_kantor'])
                ->setCellValue('D' . $row, $absen['nama_kelas'])
                ->setCellValue('E' . $row, $absen['angkatan_kelas'])
                ->setCellValue('F' . $row, $waktu_absen);

            $sheet->getStyle('A' . $row)->applyFromArray($border);
            $sheet->getStyle('B' . $row)->applyFromArray($border);
            $sheet->getStyle('C' . $row)->applyFromArray($border);
            $sheet->getStyle('D' . $row)->applyFromArray($border);
            $sheet->getStyle('E' . $row)->applyFromArray($border);
            $sheet->getStyle('F' . $row)->applyFromArray($border);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Absen-Penguji-' . date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Absen Penguji via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function bina_peserta_export()
    {
        //Angkatan
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            } else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        $absen_peserta = $this->bina_peserta->rekap_bina_absen_export($angkatan);
        $total_row     = count($absen_peserta) + 5;

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

        $judul = "DATA REKAP ABSEN PESERTA KELAS PEMBINAAN - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = "ANGKATAN PERKULIAHAN " . $angkatan . " - " . date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:X1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:X2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:X4')->applyFromArray($style_up);

        $sheet->getStyle('A5:X' . $total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NIS')
            ->setCellValue('B4', 'NAMA')
            ->setCellValue('C4', 'JENIS KELAMIN')
            ->setCellValue('D4', 'KELAS')
            ->setCellValue('E4', 'HARI')
            ->setCellValue('F4', 'WAKTU')
            ->setCellValue('G4', 'METODE TATAP MUKA')
            ->setCellValue('H4', 'ANGKATAN KULIAH')
            ->setCellValue('I4', 'TM1')
            ->setCellValue('J4', 'TM2')
            ->setCellValue('K4', 'TM3')
            ->setCellValue('L4', 'TM4')
            ->setCellValue('M4', 'TM5')
            ->setCellValue('N4', 'TM6')
            ->setCellValue('O4', 'TM7')
            ->setCellValue('P4', 'TM8')
            ->setCellValue('Q4', 'TM9')
            ->setCellValue('R4', 'TM10')
            ->setCellValue('S4', 'TM11')
            ->setCellValue('T4', 'TM12')
            ->setCellValue('U4', 'TM13')
            ->setCellValue('V4', 'TM14')
            ->setCellValue('W4', 'TM15')
            ->setCellValue('X4', 'TOTAL HADIR');

        $columns = range('A', 'X');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
        // $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);

        $row = 5;

        foreach ($absen_peserta as $absen) {

            //-----------------------------
            for ($i = 1; $i <= 15; $i++) {
                $tmKey = 'tm' . $i;
                $tmDtKey = $tmKey . '_dt';

                if ($absen[$tmKey] == '1') {
                    ${'absen_' . $tmKey} = substr($absen[$tmDtKey], 0, 10);
                    ${'count_' . $tmKey} = 1;
                } elseif ($absen[$tmKey] == '0') {
                    ${'absen_' . $tmKey} = '--';
                    ${'count_' . $tmKey} = 0;
                } else {
                    ${'absen_' . $tmKey} = '';
                    ${'count_' . $tmKey} = 0;
                }
            }

            $total = 0;
            for ($i = 1; $i <= 15; $i++) {
                $total += ${'count_tm' . $i};
            }

            // if($absen['status_aktif_peserta'] == NULL) {
            //     $status_aktif_peserta = 'AKTIF';
            // }else {
            //     $status_aktif_peserta = $absen['status_aktif_peserta'];
            // }


            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $absen['nis'])
                ->setCellValue('B' . $row, $absen['nama_peserta'])
                ->setCellValue('C' . $row, $absen['jenkel'])
                ->setCellValue('D' . $row, $absen['bk_name'])
                ->setCellValue('E' . $row, $absen['bk_hari'])
                ->setCellValue('F' . $row, $absen['bk_waktu'] . ' ' . $absen['bk_timezone'])
                ->setCellValue('G' . $row, $absen['bk_tm_methode'])
                ->setCellValue('H' . $row, $absen['bk_angkatan'])

                ->setCellValue('I' . $row, $absen_tm1)
                ->setCellValue('J' . $row, $absen_tm2)
                ->setCellValue('K' . $row, $absen_tm3)
                ->setCellValue('L' . $row, $absen_tm4)
                ->setCellValue('M' . $row, $absen_tm5)
                ->setCellValue('N' . $row, $absen_tm6)
                ->setCellValue('O' . $row, $absen_tm7)
                ->setCellValue('P' . $row, $absen_tm8)
                ->setCellValue('Q' . $row, $absen_tm9)
                ->setCellValue('R' . $row, $absen_tm10)
                ->setCellValue('S' . $row, $absen_tm11)
                ->setCellValue('T' . $row, $absen_tm12)
                ->setCellValue('U' . $row, $absen_tm13)
                ->setCellValue('V' . $row, $absen_tm14)
                ->setCellValue('W' . $row, $absen_tm15)
                ->setCellValue('X' . $row, $total);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Absen-Peserta-Pembinaan-Angkatan' . $angkatan . '-' . date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Absen Peserta Kelas Pembinaan via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // public function nonreg_peserta_export()
    // {
    //     $user          = $this->userauth();

    //     $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
    //     $queryString    = $uri->getQuery();
    //     $params         = [];
    //     parse_str($queryString, $params);

    //     if (count($params) == 1 && array_key_exists('tahun', $params)) {
    //         $tahun       = $params['tahun'];
    //     } else {
    //         $tahun      = date('Y');
    //     }
    //     $list_kelas     = $this->nonreg_kelas->list($tahun);
    //     if (count($list_kelas) > 0) {
    //         $highest_tm_ambil = max(array_column($list_kelas, 'nk_tm_ambil'));
    //     } else {
    //         $highest_tm_ambil = 0;
    //     }
    //     $lists             = $this->nonreg_absen_peserta->list_rekap($tahun);
    //     // Process each record in the lists array
    //     $lists = array_map(function ($record) {
    //         // Loop through each field in the record
    //         foreach ($record as $key => $value) {
    //             // Check if it's a napj field and not null
    //             if (preg_match('/^naps\d+$/', $key) && !is_null($value)) {
    //                 // Decode JSON string to array
    //                 $record[$key] = json_decode($value, true);
    //             }
    //         }
    //         return $record;
    //     }, $lists);

    //     $total_row  = count($lists) + 5;
    //     $col_isi    = 0;

    //     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $styleColumn = [
    //         'font' => [
    //             'bold' => true,
    //             'size' => 14,
    //         ],
    //         'alignment' => [
    //             'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //             'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //         ]
    //     ];

    //     $style_up = [
    //         'font' => [
    //             'bold' => true,
    //             'size' => 11,
    //         ],
    //         'alignment' => [
    //             'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //             'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //         ],
    //         'fill' => [
    //             'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //             'startColor' => [
    //                 'argb' => 'D9D9D9',
    //             ],
    //             'endColor' => [
    //                 'argb' => 'D9D9D9',
    //             ],
    //         ],
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ],
    //         ],
    //     ];

    //     $isi_tengah = [
    //         'alignment' => [
    //             'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //             'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //         ],
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ],
    //         ],
    //     ];

    //     $judul = "DATA REKAP ABSENSI PESERTA PROGRAM NON-REGULER";
    //     $tgl   =  "Tahun " . $tahun . ' - ' . date("d-m-Y");

    //     $sheet->setCellValue('A1', $judul);
    //     $sheet->mergeCells('A1:G1');
    //     $sheet->getStyle('A1')->applyFromArray($styleColumn);

    //     $sheet->setCellValue('A2', $tgl);
    //     $sheet->mergeCells('A2:G2');
    //     $sheet->getStyle('A2')->applyFromArray($styleColumn);


    //     $spreadsheet->setActiveSheetIndex(0)
    //         ->setCellValue('A4', 'PESERTA')
    //         ->setCellValue('B4', 'KELAS')
    //         ->setCellValue('C4', 'ANGKATAN KELAS')
    //         ->setCellValue('D4', 'TOTAL HADIR');

    //     $lastW      = 'D';
    //     $step       = 0;

    //     for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //         $step       = $step + 1;
    //         $newAsci    = $this->incrementAlphaSequence($lastW, $step);
    //         $spreadsheet->getActiveSheet()->setCellValue($newAsci . '4', 'TM' . $i);

    //         $spreadsheet->getActiveSheet()->getColumnDimension($newAsci)->setAutoSize(true);
    //     }
    //     $sheet->getStyle('A4:' . $newAsci . '4')->applyFromArray($style_up);
    //     $sheet->getStyle('A5:' . $newAsci . $total_row)->applyFromArray($isi_tengah);

    //     $columns = range('A', 'D');
    //     foreach ($columns as $column) {
    //         $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
    //     }

    //     $row = 5;

    //     foreach ($lists as $data) {

    //         $totHadir = 0;
    //         for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //             if (isset($data['naps' . $i])) {
    //                 if ($data['naps' . $i]['tm'] == '1') {
    //                     $totHadir = $totHadir + 1;
    //                 }
    //             }
    //         }

    //         $spreadsheet->setActiveSheetIndex(0)

    //             ->setCellValue('A' . $row, $data['np_nama'])
    //             ->setCellValue('B' . $row, $data['nk_nama'])
    //             ->setCellValue('C' . $row, $data['nk_tahun'])
    //             ->setCellValue('D' . $row, $totHadir);

    //         $lastW      = 'D';
    //         $step       = 0;

    //         for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //             $step = $step + 1;
    //             $var = 'naps' . $i;
    //             $col_letter = $this->incrementAlphaSequence($lastW, $step);

    //             if (isset($data[$var]['tm'])) {
    //                 if ($data[$var]['tm'] == '1') {
    //                     $cell = $col_letter . $row;
    //                     $spreadsheet->getActiveSheet()
    //                         ->setCellValue($cell, $data[$var]['dt_tm']);
    //                 } elseif ($data[$var]['tm'] == '0') {
    //                     $cell = $col_letter . $row;
    //                     $spreadsheet->getActiveSheet()
    //                         ->setCellValue($cell, '--');
    //                 } else {
    //                     $cell = $col_letter . $row;
    //                     $spreadsheet->getActiveSheet()
    //                         ->setCellValue($cell, '');
    //                 }
    //             } else {
    //                 $cell = $col_letter . $row;
    //                 $spreadsheet->getActiveSheet()
    //                     ->setCellValue($cell, '');
    //             };
    //         }

    //         $row++;
    //     }

    //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
    //     $filename =  'Data-Rekap-Absensi-Peserta-NonReguler-Tahun' . $tahun . '-' . date('Y-m-d-His');

    //     /*--- Log ---*/
    //     $this->logging('Admin', 'BERHASIL', 'Donwload rekap absensi peserta program Non-Reguler Tahun ' . $tahun);

    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename=' . $filename . '.xls');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }
    // public function nonreg_pengajar_export()
    // {
    //     $user          = $this->userauth();

    //     $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
    //     $queryString    = $uri->getQuery();
    //     $params         = [];
    //     parse_str($queryString, $params);

    //     if (count($params) == 1 && array_key_exists('tahun', $params)) {
    //         $tahun       = $params['tahun'];
    //     } else {
    //         $tahun      = date('Y');
    //     }
    //     $list_kelas     = $this->nonreg_kelas->list($tahun);
    //     if (count($list_kelas) > 0) {
    //         $highest_tm_ambil = max(array_column($list_kelas, 'nk_tm_ambil'));
    //     } else {
    //         $highest_tm_ambil = 0;
    //     }
    //     $lists             = $this->nonreg_absen_pengajar->list_rekap($tahun);
    //     // Process each record in the lists array
    //     $lists = array_map(function ($record) {
    //         // Loop through each field in the record
    //         foreach ($record as $key => $value) {
    //             // Check if it's a napj field and not null
    //             if (preg_match('/^napj\d+$/', $key) && !is_null($value)) {
    //                 // Decode JSON string to array
    //                 $record[$key] = json_decode($value, true);
    //             }
    //         }
    //         return $record;
    //     }, $lists);
    //     $total_row  = count($lists) + 5;
    //     $col_isi    = 0;

    //     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $styleColumn = [
    //         'font' => [
    //             'bold' => true,
    //             'size' => 14,
    //         ],
    //         'alignment' => [
    //             'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //             'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //         ]
    //     ];

    //     $style_up = [
    //         'font' => [
    //             'bold' => true,
    //             'size' => 11,
    //         ],
    //         'alignment' => [
    //             'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //             'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //         ],
    //         'fill' => [
    //             'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
    //             'startColor' => [
    //                 'argb' => 'D9D9D9',
    //             ],
    //             'endColor' => [
    //                 'argb' => 'D9D9D9',
    //             ],
    //         ],
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ],
    //         ],
    //     ];

    //     $isi_tengah = [
    //         'alignment' => [
    //             'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //             'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    //         ],
    //         'borders' => [
    //             'allBorders' => [
    //                 'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //             ],
    //         ],
    //     ];

    //     $judul = "DATA REKAP ABSENSI PENGAJAR PROGRAM NON-REGULER";
    //     $tgl   =  "TAHUN " . $tahun . ' - ' . date("d-m-Y");

    //     $sheet->setCellValue('A1', $judul);
    //     $sheet->mergeCells('A1:G1');
    //     $sheet->getStyle('A1')->applyFromArray($styleColumn);

    //     $sheet->setCellValue('A2', $tgl);
    //     $sheet->mergeCells('A2:G2');
    //     $sheet->getStyle('A2')->applyFromArray($styleColumn);


    //     $spreadsheet->setActiveSheetIndex(0)
    //         ->setCellValue('A4', 'NAMA')
    //         ->setCellValue('B4', 'TIPE')
    //         ->setCellValue('C4', 'KELAS')
    //         ->setCellValue('D4', 'PROGRAM KELAS')
    //         ->setCellValue('E4', 'ANGKATAN KELAS')
    //         ->setCellValue('F4', 'TOTAL HADIR');

    //     $lastW      = 'F';
    //     $step       = 0;
    //     // $newAsci = 'D0';

    //     for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //         $step       = $step + 1;
    //         $newAsci    = $this->incrementAlphaSequence($lastW, $step);
    //         $spreadsheet->getActiveSheet()->setCellValue($newAsci . '4', 'TM' . $i);

    //         $spreadsheet->getActiveSheet()->getColumnDimension($newAsci)->setAutoSize(true);
    //     }
    //     $step       = $step + 1;
    //     for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //         $step       = $step + 1;
    //         $newAsci    = $this->incrementAlphaSequence($lastW, $step);
    //         $spreadsheet->getActiveSheet()->setCellValue($newAsci . '4', 'MTD TTM' . $i);

    //         $spreadsheet->getActiveSheet()->getColumnDimension($newAsci)->setAutoSize(true);
    //     }
    //     $step       = $step + 1;
    //     for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //         $step       = $step + 1;
    //         $newAsci    = $this->incrementAlphaSequence($lastW, $step);
    //         $spreadsheet->getActiveSheet()->setCellValue($newAsci . '4', 'ISI ABS TM-' . $i);

    //         $spreadsheet->getActiveSheet()->getColumnDimension($newAsci)->setAutoSize(true);
    //     }
    //     $sheet->getStyle('A4:' . $newAsci . '4')->applyFromArray($style_up);
    //     $sheet->getStyle('A5:' . $newAsci . $total_row)->applyFromArray($isi_tengah);

    //     $columns = range('A', 'F');
    //     foreach ($columns as $column) {
    //         $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
    //     }

    //     $row = 5;

    //     foreach ($lists as $data) {

    //         $totHadir = 0;
    //         for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //             if (isset($data['napj' . $i])) {
    //                 if ($data['napj' . $i]['tm'] == '1') {
    //                     $totHadir = $totHadir + 1;
    //                 }
    //             }
    //         }

    //         $spreadsheet->setActiveSheetIndex(0)

    //             ->setCellValue('A' . $row, $data['nama_pengajar'])
    //             ->setCellValue('B' . $row, $data['kategori_pengajar'])
    //             ->setCellValue('C' . $row, $data['nk_nama'])
    //             ->setCellValue('D' . $row, $data['nama_program'])
    //             ->setCellValue('E' . $row, $data['nk_tahun'])
    //             ->setCellValue('F' . $row, $totHadir);

    //         $lastW      = 'F';
    //         $step       = 0;

    //         for ($i = 1; $i <= $highest_tm_ambil; $i++) {
    //             $step = $step + 1;
    //             $var = 'napj' . $i;
    //             $col_letter = $this->incrementAlphaSequence($lastW, $step);

    //             if (isset($data[$var]['tm'])) {
    //                 if ($data[$var]['tm'] == '1') {
    //                     $cell = $col_letter . $row;
    //                     $spreadsheet->getActiveSheet()
    //                         ->setCellValue($cell, $data[$var]['dt_tm']);
    //                 } elseif ($data[$var]['tm'] == '0') {
    //                     $cell = $col_letter . $row;
    //                     $spreadsheet->getActiveSheet()
    //                         ->setCellValue($cell, '--');
    //                 } else {
    //                     $cell = $col_letter . $row;
    //                     $spreadsheet->getActiveSheet()
    //                         ->setCellValue($cell, '');
    //                 }
    //             } else {
    //                 $cell = $col_letter . $row;
    //                 $spreadsheet->getActiveSheet()
    //                     ->setCellValue($cell, '');
    //             };
    //         }
    //         $step       = $step + 1;
    //         for ($ii = 1; $ii <= $highest_tm_ambil; $ii++) {
    //             $step = $step + 1;
    //             $var = 'napj' . $ii;
    //             $col_letter = $this->incrementAlphaSequence($lastW, $step);

    //             if (isset($data[$var]['tm'])) {
    //                 $cell = $col_letter . $row;
    //                 if (isset($data[$var]['metode_ttm'])) {
    //                     $spreadsheet->getActiveSheet()
    //                         ->setCellValue($cell, $data[$var]['metode_ttm']);
    //                 }
    //             } else {
    //                 $cell = $col_letter . $row;
    //                 $spreadsheet->getActiveSheet()
    //                     ->setCellValue($cell, '');
    //             };
    //         }
    //         $step       = $step + 1;
    //         for ($ii = 1; $ii <= $highest_tm_ambil; $ii++) {
    //             $step = $step + 1;
    //             $var = 'napj' . $ii;
    //             $col_letter = $this->incrementAlphaSequence($lastW, $step);

    //             if (isset($data[$var]['tm'])) {
    //                 $cell = $col_letter . $row;
    //                 $spreadsheet->getActiveSheet()
    //                     ->setCellValue($cell, $data[$var]['dt_isi']);
    //             } else {
    //                 $cell = $col_letter . $row;
    //                 $spreadsheet->getActiveSheet()
    //                     ->setCellValue($cell, '');
    //             };
    //         }

    //         $row++;
    //     }

    //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
    //     $filename =  'Data-Rekap-Absensi-Pengajar-NonReguler-' . $tahun . '-' . date('Y-m-d-His');

    //     /*--- Log ---*/
    //     $this->logging('Admin', 'BERHASIL', 'Donwload rekap absensi pengajar program Non-Reguler ' . $tahun);

    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename=' . $filename . '.xls');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

    public function nonreg_absensi()
    {
        $user = $this->userauth(); // Return Array

        //Angkatan
        $uri = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString = $uri->getQuery();
        $params = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('kelas', $params) && array_key_exists('npj', $params)) {
            $kelas_id = $params['kelas'];
            $npjId = $params['npj'];
        } else {
            return redirect()->to('/kelas-nonreg');
        }

        // $peserta_onkelas = $this->peserta_kelas->peserta_onkelas_absen($kelas_id);
        // $absen_pengajar_id = $this->kelas->get_data_absen_pengajar_id($kelas_id)->data_absen_pengajar;
        // $absen_pengajar = $this->absen_pengajar->find($absen_pengajar_id);

        // $get_pengajar_id    = $this->pengajar->get_pengajar_id($user['user_id']);
        // $pengajar_id        = $get_pengajar_id->pengajar_id;
        $npj = $this->nonreg_pengajar->find($npjId);
        $pengajar = $this->pengajar->find($npj['npj_pengajar']);

        $absenTm = $this->nonreg_absen_pengajar
            ->join('nonreg_pengajar', 'nonreg_pengajar.npj_id = nonreg_absen_pengajar.napj_pengajar')
            ->where('npj_kelas', $kelas_id)
            // ->where('npj_pengajar', $pengajar_id)

            ->get()->getResultArray();

        if ($absenTm) {
            // Iterate through each key in the array
            foreach ($absenTm as $key => $value) {
                // Check if the key matches the pattern 'tm' followed by a number and the value is not null
                if (preg_match('/^napj\d+$/', $key) && !is_null($value)) {
                    // Decode the JSON string
                    $absenTm[$key] = json_decode($value, true);
                }
            }
        }

        $getAbsensi = $this->nonreg_absen_peserta
            ->join('nonreg_peserta', 'nonreg_peserta.np_id = nonreg_absen_peserta.naps_peserta')
            ->where('np_kelas', $kelas_id)
            ->orderBy('np_id', 'ASC')
            ->findAll();

        $kelas           = $this->nonreg_kelas->find($kelas_id);

        foreach ($getAbsensi as $record) {
            if ($record['np_level'] == null || $record['np_level'] == "0" || $record['np_level'] == "") {
                $levelPeserta = "-";
            } else {
                $findLevel = $this->level->find($record['np_level']);
                $levelPeserta = $findLevel['nama_level'];
            }

            $entry = [
                'naps_id' => $record['naps_id'],
                'nama' => $record['np_nama'],
                'level' => $levelPeserta
            ];

            // Dynamically add tm1 to tm30
            for ($i = 1; $i <= $kelas['nk_tm_ambil']; $i++) {
                $tmKey = 'naps' . $i;
                if (isset($record[$tmKey])) {
                    $entry[$tmKey] = json_decode($record[$tmKey], true);
                } else {
                    $entry[$tmKey] = null; // or any default value if tmKey doesn't exist
                }
            }

            $peserta_onkelas[] = $entry;
        }

        // $data = [
        //     'title'             => 'Peserta Kelas',
        //     'list'              => $this->kelas->list(),
        //     'user'              => $user,
        //     'peserta_onkelas'   => $peserta_onkelas,
        //     'kelas'             => $kelas,
        // ];

        // for ($i = 1; $i <= 16; $i++) {
        //     $tmData = [
        //         'name' => "Tatap Muka ke-$i",
        //         'absensi' => $absen_pengajar["tm{$i}_pengajar"],
        //         'note' => $absen_pengajar["note_tm$i"],
        //         'tanggal' => $absen_pengajar["tgl_tm$i"],
        //     ];
        //     $data['tatapMukaData'][] = $tmData;
        // }

        $absenTmNew = [];

        foreach ($absenTm as $record) {
            // Extract base information
            $baseInfo = [
                'napj_id' => $record['napj_id'],
                'napj_pengajar' => $record['napj_pengajar'],
                'npj_id' => $record['npj_id'],
                'npj_pengajar' => $record['npj_pengajar'],
                'npj_kelas' => $record['npj_kelas']
            ];

            // Process napj1 through napj50
            for ($i = 1; $i <= 50; $i++) {
                $napjKey = "napj{$i}";

                if (!empty($record[$napjKey]) && $record[$napjKey] !== null) {
                    // Decode JSON data
                    $jsonData = json_decode($record[$napjKey], true);

                    if ($jsonData && is_array($jsonData)) {
                        // Create new row with base info + TM data
                        $newRow = array_merge($baseInfo, [
                            'tm_sequence' => $i, // Which napj field this came from
                            'tm' => $jsonData['tm'] ?? null,
                            'dt_tm' => $jsonData['dt_tm'] ?? null,
                            'dt_isi' => $jsonData['dt_isi'] ?? null,
                            'note' => $jsonData['note'] ?? null,
                            'by' => $jsonData['by'] ?? null,
                            'metode_ttm' => $jsonData['metode_ttm'] ?? null,
                        ]);

                        $absenTmNew[] = $newRow;
                    }
                }
            }
        }

        $data = [
            'title'            => 'Absensi Kelas Non-Reguler ' . $kelas['nk_nama'],
            'user'            => $user,
            'kelas'         => $kelas,
            // 'absenTm'       => $absenTm,
            'pengajar'      => $pengajar,
            'npjId'         => $npjId,
            'absenTmNew'   => $absenTmNew,
            'peserta_onkelas' => $peserta_onkelas
        ];
        //var_dump($absenTmNew);
        return view('panel_admin/absensi/nonreg/absensi', $data);
    }

    public function nonreg_input_absensi()
    {
        if ($this->request->isAJAX()) {

            $user = $this->userauth();

            $tm         = $this->request->getVar('tm');
            $nk_id      = $this->request->getVar('nk_id');
            $npj_id     = $this->request->getVar('npj_id');

            $npj = $this->nonreg_pengajar->find($npj_id);
            $pengajar = $this->pengajar->find($npj['npj_pengajar']);

            // $get_pengajar_id    = $this->pengajar->get_pengajar_id($user['user_id']);
            // $pengajar_id        = $get_pengajar_id->pengajar_id;

            $absenKelas = $this->nonreg_absen_pengajar
                ->join('nonreg_pengajar', 'nonreg_pengajar.npj_id = nonreg_absen_pengajar.napj_pengajar')
                ->where('npj_kelas', $nk_id)
                ->where('napj_pengajar', $npj_id)
                ->first();
            $absenTm    = json_decode($absenKelas['napj' . $tm], true);

            $title      = 'FORM ISI ABSENSI TM-' . $tm;
            $kelas      = $this->nonreg_kelas->find($nk_id);
            $pengajar   = $this->pengajar->find($npj['npj_pengajar']);

            $getAbsensi = $this->nonreg_absen_peserta
                ->join('nonreg_peserta', 'nonreg_peserta.np_id = nonreg_absen_peserta.naps_peserta')
                ->where('np_kelas', $nk_id)
                ->orderBy('np_id', 'ASC')
                ->findAll();

            $listAbsensi = [];

            foreach ($getAbsensi as $index => $record) {
                if ($record['np_level'] == null || $record['np_level'] == "0" || $record['np_level'] == "") {
                    $levelPeserta = "-";
                } else {
                    $findLevel = $this->level->find($record['np_level']);
                    $levelPeserta = $findLevel['nama_level'];
                }
                $listAbsensi[] = [
                    'naps_id' => $record['naps_id'],
                    'np_id' => $record['np_id'],
                    'nama' => $record['np_nama'],
                    'level' => $levelPeserta,
                    'naps' . $tm => json_decode($record['naps' . $tm], true)
                ];
            }

            // Extract all existing dt_tm values from the dataset
            $existing_dates = [];

            foreach ($listAbsensi as $peserta) {
                // Determine how many naps entries exist by finding keys that match the pattern
                $naps_keys = array_filter(array_keys($peserta), function ($key) {
                    return preg_match('/^naps\d+$/', $key);
                });

                // Loop through each naps entry that actually exists
                foreach ($naps_keys as $naps_key) {
                    // Make sure the naps entry exists and has a dt_tm value
                    if (!empty($peserta[$naps_key]) && !empty($peserta[$naps_key]['dt_tm'])) {
                        $existing_dates[] = $peserta[$naps_key]['dt_tm'];
                    }
                }
            }

            // Remove duplicates to get unique dates
            $unique_dates = array_unique($existing_dates);

            $data = [
                'title'         => $title,
                'kelas'         => $kelas,
                'pengajar'      => $pengajar,
                'tm'            => $tm,
                'absenTm'       => $absenTm,
                'absenKelas'    => $absenKelas,
                'listAbsensi'   => $listAbsensi,
                'existing_dates'   => $unique_dates,
                'pengajar'      => $pengajar,
                'npjId'        => $npj_id,
            ];

            // $absen_tm   = $this->peserta_kelas->peserta_onkelas_absen_tm($tm, $kelas_id);
            // $data_absen_pengajar   = $this->request->getVar('data_absen_pengajar');

            // //Data Kelas
            // $data_kelas         = $this->kelas->list_detail_kelas($kelas_id);
            // $nama_pengajar      = $data_kelas[0]['nama_pengajar'];
            // $absen_pengajar_id  = $data_kelas[0]['data_absen_pengajar'];

            // //Data absen pengajar
            // $absen_pengajar  = $this->absen_pengajar->find($data_absen_pengajar);
            // $tgl_tm          = "tgl_" . $tm;
            // $tgl_absen       = $absen_pengajar["$tgl_tm"];

            // if ($tgl_absen == NULL || $tgl_absen == "2022-01-01") {
            //     $tgl_absen  = date("Y-m-d");
            // }

            // $data = [
            //     'title'         => 'Absensi Pengajar & Peserta',
            //     'tm'            => $tm,
            //     'kelas_id'      => $kelas_id,
            //     'tm_upper'      => $tm_upper,
            //     'nama_pengajar' => $nama_pengajar,
            //     'absen_tm'      => $absen_tm,
            //     'tgl_absen'     => $tgl_absen,
            //     'absen_pengajar' => $absen_pengajar,
            //     'absen_pengajar_id' => $absen_pengajar_id,
            // ];
            //var_dump($existing_dates);
            $msg = [
                'sukses' => view('panel_admin/absensi/nonreg/input_absensi', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function nonreg_save_absensi()
    {
        $user = $this->userauth();

        $tm      = $this->request->getVar('tm');
        $kelasId = $this->request->getVar('kelasId');
        $napjId  = $this->request->getVar('napjId');
        $npjId   = $this->request->getVar('npjId');

        $dt_tm   = $this->request->getVar('dt_tm');
        $note    = str_replace(array("\r", "\n", "\r\n"), ' ', $this->request->getVar('note'));

        $arNp    = $this->request->getVar('arNp');
        $arNaps  = $this->request->getVar('arNaps');
        $metode_ttm  = $this->request->getVar('metode_ttm');
        // $aktivitas  = $this->request->getVar('aktivitas');

        $npj = $this->nonreg_pengajar->find($npjId);
        $pengajar = $this->pengajar->find($npj['npj_pengajar']);

        $kelas = $this->nonreg_kelas->find($kelasId);

        foreach ($arNaps as $naps) {
            $cek = $this->request->getVar('cek' . $naps);
            $ab  = json_encode([
                'tm'    => $cek,
                'dt_tm' => $dt_tm,
                'dt_isi' => date('Y-m-d H:i:s'),
                'note'  => '',
                'by'    => $pengajar['nama_pengajar']
            ]);
            $abData = [
                'naps' . $tm => $ab,
            ];
            $this->nonreg_absen_peserta->update($naps, $abData);
        }

        $abpj  = json_encode([
            'tm'      => '1',
            'dt_tm'   => $dt_tm,
            'dt_isi'  => date('Y-m-d H:i:s'),
            'note'    => $note,
            'by'      => $pengajar['nama_pengajar'],
            'metode_ttm' => $metode_ttm,
            // 'aktivitas' => $aktivitas
        ]);
        $abpjData = [
            'napj' . $tm => $abpj,
        ];
        $this->nonreg_absen_pengajar->update($napjId, $abpjData);
        $this->logging('Admin', 'BERHASIL', 'Mengisi absensi kelas ' . $kelas['nk_nama'] . ' TM-' . $tm . ' atas nama pengajar ' . $pengajar['nama_pengajar']);

        return $this->response->setJSON(
            [
                'success' => true,
                'code'    => '200',
                'data'    => [
                    'title' => 'Berhasil',
                    'link'  => '/absensi-nonreg/absen?kelas=' . $kelasId . '&npj=' . $napjId,
                    'icon'  => 'success',
                ],
                'message' => 'Pengisian Form Berhasil.',
            ]
        );
    }

    public function nonreg_peserta_export()
    {
        $user           = $this->userauth();

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        // Get tahun parameter
        $tahun = isset($params['tahun']) && !empty($params['tahun']) ? $params['tahun'] : date('Y');

        // Get bulan parameter
        $bulan = isset($params['bulan']) ? $params['bulan'] : 'all';

        $list_kelas     = $this->nonreg_kelas->list($tahun);
        if (count($list_kelas) > 0) {
            $highest_tm_ambil = max(array_column($list_kelas, 'nk_tm_ambil'));
        } else {
            $highest_tm_ambil = 0;
        }

        $lists          = $this->nonreg_absen_peserta->list_rekap_export();

        // Proses setiap record di dalam array $lists
        $lists = array_map(function ($record) use ($tahun, $bulan) {
            // Loop melalui setiap field di dalam record
            foreach ($record as $key => &$value) { // Gunakan '&' untuk modifikasi langsung
                // Cek apakah ini field naps (contoh: naps1, naps2, dst.) dan tidak null
                if (preg_match('/^naps\d+$/', $key) && !is_null($value)) {

                    $decoded_value = json_decode($value, true);

                    // MODIFIKASI: Filter berdasarkan bulan dan tahun jika bulan dipilih (bukan 'all')
                    if ($bulan != 'all' && is_numeric($bulan) && isset($decoded_value['dt_tm'])) {
                        $record_year = substr($decoded_value['dt_tm'], 0, 4);
                        $record_month = substr($decoded_value['dt_tm'], 5, 2);

                        // Jika tahun atau bulan tidak cocok, buat data absensi ini menjadi NULL
                        if ($record_year != $tahun || $record_month != $bulan) {
                            $value = null;
                        } else {
                            // Jika cocok, gunakan data yang sudah di-decode
                            $value = $decoded_value;
                        }
                    } else {
                        // Jika tidak ada filter bulan, cukup decode JSON-nya
                        $value = $decoded_value;
                    }
                }
            }
            unset($value); // Hapus referensi setelah loop selesai
            return $record;
        }, $lists);


        $total_row   = count($lists) + 5;

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

        $judul = "DATA REKAP ABSENSI PESERTA PROGRAM NON-REGULER";

        // MODIFIKASI: Tambahkan informasi bulan pada sub-judul jika dipilih
        $nama_bulan_id = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        $periode = "Tahun " . $tahun;
        if ($bulan != 'all' && is_numeric($bulan)) {
            $periode = "Periode " . ($nama_bulan_id[$bulan] ?? '') . " " . $tahun;
        }
        $tgl = $periode . ' - ' . date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:F1'); // Disesuaikan agar merge tidak terlalu jauh
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:F2'); // Disesuaikan agar merge tidak terlalu jauh
        $sheet->getStyle('A2')->applyFromArray($styleColumn);


        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'PESERTA')
            ->setCellValue('C4', 'NIK')
            ->setCellValue('D4', 'KELAS')
            ->setCellValue('E4', 'ANGKATAN KELAS')
            ->setCellValue('F4', 'TOTAL HADIR (Bulan Terpilih)'); // MODIFIKASI: Judul kolom lebih deskriptif

        $lastW      = 'F'; // MODIFIKASI: Kolom terakhir sebelum TM adalah F
        $step       = 0;

        for ($i = 1; $i <= $highest_tm_ambil; $i++) {
            $step      = $step + 1;
            $newAsci   = $this->incrementAlphaSequence($lastW, $step);
            $spreadsheet->getActiveSheet()->setCellValue($newAsci . '4', 'TM' . $i);
            $spreadsheet->getActiveSheet()->getColumnDimension($newAsci)->setAutoSize(true);
        }

        // Perbaikan untuk merge header
        $lastColumnForMerge = $this->incrementAlphaSequence('D', $highest_tm_ambil + 1); // E + highest_tm_ambil
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A1:' . $lastColumnForMerge . '1');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A2:' . $lastColumnForMerge . '2');

        $sheet->getStyle('A4:' . $newAsci . '4')->applyFromArray($style_up);
        $sheet->getStyle('A5:' . $newAsci . $total_row)->applyFromArray($isi_tengah);

        $columns = range('A', 'F'); // MODIFIKASI: Kolom yang di-autosize sampai F
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;
        $no = 1;
        foreach ($lists as $data) {
            $no++;
            // Kalkulasi totHadir sekarang secara otomatis hanya menghitung data yang tidak di-set menjadi NULL (sudah terfilter)
            $totHadir = 0;
            for ($i = 1; $i <= $highest_tm_ambil; $i++) {
                if (isset($data['naps' . $i]) && $data['naps' . $i]['tm'] == '1') {
                    $totHadir++;
                }
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $no)
                ->setCellValue('B' . $row, $data['np_nama'])
                ->setCellValue('C' . $row, $data['nk_id'])
                ->setCellValue('D' . $row, $data['nk_nama'])
                ->setCellValue('E' . $row, $data['nk_tahun'])
                ->setCellValue('F' . $row, $totHadir);

            $lastW      = 'F';
            $step       = 0;

            for ($i = 1; $i <= $highest_tm_ambil; $i++) {
                $step = $step + 1;
                $var = 'naps' . $i;
                $col_letter = $this->incrementAlphaSequence($lastW, $step);

                // Kode di bawah ini tidak perlu diubah karena sudah menangani nilai NULL dari proses filter di atas
                if (isset($data[$var]['tm'])) {
                    if ($data[$var]['tm'] == '1') {
                        $cell = $col_letter . $row;
                        $spreadsheet->getActiveSheet()->setCellValue($cell, $data[$var]['dt_tm']);
                    } elseif ($data[$var]['tm'] == '0') {
                        $cell = $col_letter . $row;
                        $spreadsheet->getActiveSheet()->setCellValue($cell, '--');
                    } else {
                        $cell = $col_letter . $row;
                        $spreadsheet->getActiveSheet()->setCellValue($cell, '');
                    }
                } else {
                    $cell = $col_letter . $row;
                    $spreadsheet->getActiveSheet()->setCellValue($cell, '');
                };
            }

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);
        $filename =  'Data-Rekap-Absensi-Peserta-NonReguler-Tahun' . $tahun . '-' . date('Y-m-d-His');

        $this->logging('Admin', 'BERHASIL', 'Download rekap absensi peserta program Non-Reguler Tahun ' . $tahun);

        header('Content-Type: application/vnd.ms-excel'); // Koreksi content type untuk .xls
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"'); // Tambahkan kutip untuk nama file
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function nonreg_pengajar_export()
    {
        $user = $this->userauth();

        $uri = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString = $uri->getQuery();
        $params = [];
        parse_str($queryString, $params);

        // Get tahun parameter
        if (count($params) >= 2 && array_key_exists('tahun', $params) && array_key_exists('bulan', $params)) {
            $tahun = $params['tahun'];
        } else {
            $tahun = date('Y');
        }

        // Get bulan parameter
        $bulan = isset($params['bulan']) ? $params['bulan'] : 'all';
        $jenis_data = isset($params['jenis-data']) ? $params['jenis-data'] : 'tm';

        $list_kelas = $this->nonreg_kelas->list($tahun);
        if (count($list_kelas) > 0) {
            $highest_tm_ambil = max(array_column($list_kelas, 'nk_tm_ambil'));
        } else {
            $highest_tm_ambil = 0;
        }

        // Get all data for the year
        $lists = $this->nonreg_absen_pengajar->list_rekap_export();
        // Process each record - decode JSON napj fields
        $lists = array_map(function ($record) {
            foreach ($record as $key => $value) {
                if (preg_match('/^napj\d+$/', $key) && !is_null($value)) {
                    $record[$key] = json_decode($value, true);
                }
            }
            return $record;
        }, $lists);

        // Filter by month if not 'all'
        if ($bulan !== 'all') {
            $lists = $this->filterDataByMonthAndYear($lists, $bulan, $tahun, $highest_tm_ambil, $jenis_data);
        }

        // Transform data structure - convert horizontal TM data to vertical rows
        $transformed_data = [];
        foreach ($lists as $data) {
            // Calculate total hadir
            $totHadir = 0;
            for ($i = 1; $i <= $highest_tm_ambil; $i++) {
                if (isset($data['napj' . $i]) && $data['napj' . $i]['tm'] == '1') {
                    // Check if this TM date falls within the selected month
                    if ($bulan === 'all' || $this->isDateInMonthAndYear($data['napj' . $i]['dt_tm'], $bulan, $tahun)) {
                        $totHadir++;
                    }
                }
            }

            // Create rows for each TM
            for ($i = 1; $i <= $highest_tm_ambil; $i++) {
                // Initialize TM data
                $tm_data = [
                    'nama_pengajar' => $data['nama_pengajar'],
                    'kategori_pengajar' => $data['kategori_pengajar'],
                    'nk_id' => $data['nk_id'],
                    'nk_nama' => $data['nk_nama'],
                    'nama_program' => $data['nama_program'],
                    'nk_tahun' => $data['nk_tahun'],
                    'total_hadir' => $totHadir,
                    'tm_number' => 'TM' . $i,
                    'tgl_hadir' => '',
                    'metode_ttm' => '',
                    'dt_isi' => '',
                    'status_hadir' => 'Tidak Hadir',
                    'note' => isset($data['napj' . $i]['note']) ? $data['napj' . $i]['note'] : '',
                ];

                // Check if this TM data exists
                if (isset($data['napj' . $i]) && !is_null($data['napj' . $i])) {
                    $napj = $data['napj' . $i];

                    // Skip this TM if it's not in the selected month (when month filter is applied)
                    if ($bulan !== 'all' && !$this->isDateInMonthAndYear($napj['dt_tm'], $bulan, $tahun)) {
                        continue;
                    }

                    if ($napj['tm'] == '1') {
                        $tm_data['tgl_hadir'] = $napj['dt_tm'];
                        $tm_data['status_hadir'] = 'Hadir';
                        $tm_data['dt_isi'] = $napj['dt_isi'];
                        if (isset($napj['metode_ttm'])) {
                            $tm_data['metode_ttm'] = $napj['metode_ttm'];
                        }
                    } elseif ($napj['tm'] == '0') {
                        $tm_data['status_hadir'] = 'Tidak Hadir';
                        $tm_data['tgl_hadir'] = '--';
                    }
                } else {
                    // If no data for this TM and month filter is applied, skip empty rows
                    if ($bulan !== 'all') {
                        continue;
                    }
                }

                $transformed_data[] = $tm_data;
            }
        }

        // If no data found for the selected month, create a message
        if (empty($transformed_data) && $bulan !== 'all') {
            $bulan_name = $this->getMonthName($bulan);
            $transformed_data[] = [
                'nama_pengajar' => 'TIDAK ADA DATA',
                'kategori_pengajar' => '-',
                'nk_id' => '-',
                'nk_nama' => '-',
                'nama_program' => '-',
                'nk_tahun' => $tahun,
                'total_hadir' => 0,
                'tm_number' => '-',
                'tgl_hadir' => '-',
                'metode_ttm' => '-',
                'dt_isi' => '-',
                'status_hadir' => 'Tidak ada data untuk bulan ' . $bulan_name,
                'note' => '-',
            ];
        }

        $total_row = count($transformed_data) + 5;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $styleColumn = [
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ];

        $style_up = [
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
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
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        // Dynamic title based on filter
        $period_text = $bulan === 'all' ? 'TAHUN ' . $tahun : 'BULAN ' . $this->getMonthName($bulan) . ' TAHUN ' . $tahun;
        $judul = "DATA REKAP ABSENSI PENGAJAR PROGRAM NON-REGULER";
        $tgl = $period_text . ' - ' . date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:L2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        // Set headers for vertical format
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NO')
            ->setCellValue('B4', 'NAMA')
            ->setCellValue('C4', 'TIPE')
            ->setCellValue('D4', 'NIK KELAS')
            ->setCellValue('E4', 'KELAS')
            ->setCellValue('F4', 'PROGRAM KELAS')
            ->setCellValue('G4', 'ANGKATAN KELAS')
            ->setCellValue('H4', 'TM')
            ->setCellValue('I4', 'TGL HADIR')
            ->setCellValue('J4', 'METODE TTM')
            ->setCellValue('K4', 'WAKTU ISI')
            ->setCellValue('L4', 'CATATAN');

        $sheet->getStyle('A4:L4')->applyFromArray($style_up);
        $sheet->getStyle('A5:L' . $total_row)->applyFromArray($isi_tengah);

        // Auto-size columns
        $columns = range('A', 'L');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;
        $no = 1;
        // Fill data in vertical format
        foreach ($transformed_data as $data) {
            // Set row number
            $data['no'] = $no++;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['no'])
                ->setCellValue('B' . $row, $data['nama_pengajar'])
                ->setCellValue('C' . $row, $data['kategori_pengajar'])
                ->setCellValue('D' . $row, $data['nk_id'])
                ->setCellValue('E' . $row, $data['nk_nama'])
                ->setCellValue('F' . $row, $data['nama_program'])
                ->setCellValue('G' . $row, $data['nk_tahun'])
                ->setCellValue('H' . $row, $data['tm_number'])
                ->setCellValue('I' . $row, $data['tgl_hadir'])
                ->setCellValue('J' . $row, $data['metode_ttm'])
                ->setCellValue('K' . $row, $data['dt_isi'])
                ->setCellValue('L' . $row, $data['note']);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xls($spreadsheet);

        // Dynamic filename based on filter
        $filename_suffix = $bulan === 'all' ? $tahun : $tahun . '-' . $this->getMonthName($bulan);
        $filename = 'Data-Rekap-Absensi-Pengajar-NonReguler-Vertical-' . $filename_suffix . '-' . date('Y-m-d-His');

        /*--- Log ---*/
        $log_message = $bulan === 'all'
            ? 'Download rekap absensi pengajar program Non-Reguler (Format Vertikal) tahun ' . $tahun
            : 'Download rekap absensi pengajar program Non-Reguler (Format Vertikal) bulan ' . $this->getMonthName($bulan) . ' tahun ' . $tahun;

        $this->logging('Admin', 'BERHASIL', $log_message);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xls');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    /**
     * Helper function to filter data by month
     */
    private function filterDataByMonthAndYear($lists, $bulan, $tahun, $highest_tm_ambil, $jenis_data) // Renamed and added $tahun
    {
        $filtered_lists = [];
        if ($jenis_data == 'tm') {
            foreach ($lists as $data) {
                $has_data_in_period = false;

                // Check if any TM has data in the selected month and year
                for ($i = 1; $i <= $highest_tm_ambil; $i++) {
                    if (isset($data['napj' . $i]) && !is_null($data['napj' . $i])) {
                        // Pass $tahun to the checking function
                        if (isset($data['napj' . $i]['dt_tm']) && $this->isDateInMonthAndYear($data['napj' . $i]['dt_tm'], $bulan, $tahun)) {
                            $has_data_in_period = true;
                            break;
                        }
                    }
                }

                if ($has_data_in_period) {
                    $filtered_lists[] = $data;
                }
            }

            return $filtered_lists;
        } elseif ($jenis_data == 'input') {
            foreach ($lists as $data) {
                $has_data_in_period = false;

                // Check if any TM has data in the selected month and year
                for ($i = 1; $i <= $highest_tm_ambil; $i++) {
                    if (isset($data['napj' . $i]) && !is_null($data['napj' . $i])) {
                        // Pass $tahun to the checking function
                        if (isset($data['napj' . $i]['dt_isi']) && $this->isDateInMonthAndYear($data['napj' . $i]['dt_isi'], $bulan, $tahun)) {
                            $has_data_in_period = true;
                            break;
                        }
                    }
                }

                if ($has_data_in_period) {
                    $filtered_lists[] = $data;
                }
            }
            return $filtered_lists;
        }
    }

    /**
     * Helper function to check if a date falls within a specific month and year
     */
    private function isDateInMonthAndYear($date, $month, $year) // Renamed and added $year
    {
        // If date is empty, it can't be filtered
        if (empty($date)) {
            return false;
        }

        // If both are 'all', no filtering is needed
        if ($month === 'all' && $year === 'all') {
            return true;
        }

        $date_obj = strtotime($date);
        $date_month = date('m', $date_obj);
        $date_year = date('Y', $date_obj);

        $month_matches = ($month === 'all' || $date_month === $month);
        $year_matches = ($year === 'all' || $date_year === $year);

        return $month_matches && $year_matches;
    }

    /**
     * Helper function to get month name in Indonesian
     */
    private function getMonthName($month)
    {
        $months = [
            '01' => 'JANUARI',
            '02' => 'FEBRUARI',
            '03' => 'MARET',
            '04' => 'APRIL',
            '05' => 'MEI',
            '06' => 'JUNI',
            '07' => 'JULI',
            '08' => 'AGUSTUS',
            '09' => 'SEPTEMBER',
            '10' => 'OKTOBER',
            '11' => 'NOVEMBER',
            '12' => 'DESEMBER'
        ];

        return isset($months[$month]) ? $months[$month] : 'Semua';
    }
}
