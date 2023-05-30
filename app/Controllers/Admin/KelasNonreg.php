<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class KelasNonreg extends BaseController
{
    public function index()
    {
        $user           = $this->userauth();

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        
        $list_angkatan      = $this->nonreg_kelas->list_unik_angkatan();
        $list_kelas         = $this->nonreg_kelas->list($angkatan);
        $data = [
            'title'             => 'Manajamen Kelas Non-Regular Angkatan ' . $angkatan,
            'list'              => $list_kelas,
            'list_angkatan'     => $list_angkatan,
            'angkatan_pilih'    => $angkatan,
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
                'title'     => 'Form Input Kelas Non-Regular Baru',
                'pengajar'  => $this->pengajar->list(),
                'peserta'   => $this->peserta->list(),
                'level'     => $this->level->list(),
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

            $nk_id          = $this->request->getVar('nk_id');
            $nonreg_kelas   =  $this->nonreg_kelas->find($nk_id);
            $data = [
                'title'     => 'Ubah Data Kelas Non-Regular '.$nonreg_kelas['nk_name'],
                'pengajar'  => $this->pengajar->list(),
                'nonreg'    => $nonreg_kelas,
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
                'title'             => 'Al-Haqq - Detail Kelas Non-Regular',
                'user'              => $user,
                'peserta_onkelas'   => $peserta_onkelas,
                'detail_kelas'      => $kelas,
                'pengajar'          => $this->nonreg_pengajar->pengajar_onkelas($nk_id),
                'jumlah_peserta'    => count($peserta_onkelas),
            ];
            return view('panel_admin/kelas_nonreg/detail', $data);
        } else {
            return redirect()->to('kelas-nonreg');
        }
    }

    /*--- BACKEND ---*/
    public function create()
    {
        
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nk_name' => [
                    'label' => 'nk_name',
                    'rules' => 'required|is_unique[nonreg_kelas.nk_name]',
                    'errors' => [
                        'required' => 'Nama Kelas tidak boleh kosong',
                        'is_unique' => 'Nama Kelas harus unik, sudah ada yang menggunakan Nama Kelas ini',
                    ]
                ],
                'nk_angkatan' => [
                    'label' => 'nk_angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angakatan tidak boleh kosong',
                    ]
                ],
                'nj_pengajar' => [
                    'label' => 'nj_pengajar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Pengajar tidak boleh kosong',
                    ]
                ],
                'nk_hari' => [
                    'label' => 'nk_hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari tidak boleh kosong',
                    ]
                ],
                'nk_waktu' => [
                    'label' => 'nk_waktu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Waktu tidak boleh kosong',
                    ]
                ],
                'nk_timezone' => [
                    'label' => 'nk_timezone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Zona Waktu tidak boleh kosong',
                    ]
                ],
                'nk_jenkel' => [
                    'label' => 'nk_jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin tidak boleh kosong',
                    ]
                ],
                'nk_tm_total' => [
                    'label' => 'nk_tm_total',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'TM Total tidak boleh kosong',
                    ]
                ],
                'nk_tm_methode' => [
                    'label' => 'nk_tm_methode',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Metode TM tidak boleh kosong',
                    ]
                ],
                'nk_status' => [
                    'label' => 'nk_status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status Kelas tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nk_name'      => $validation->getError('nk_name'),
                        'nk_angkatan'  => $validation->getError('nk_angkatan'),
                        'nj_pengajar'  => $validation->getError('nj_pengajar'),
                        'nk_hari'      => $validation->getError('nk_hari'),
                        'nk_waktu'     => $validation->getError('nk_waktu'),
                        'nk_timezone'  => $validation->getError('nk_timezone'),
                        'nk_jenkel'    => $validation->getError('nk_jenkel'),
                        'nk_tm_total'  => $validation->getError('nk_tm_total'),
                        'nk_tm_methode'=> $validation->getError('nk_tm_methode'),
                        'nk_status'    => $validation->getError('nk_status'),
                    ]
                ];
            } else {
                
                
                $this->db->transStart();
                $nonreg_kelas_New = [
                    'nk_name'          => strtoupper($this->request->getVar('nk_name')),
                    'nk_angkatan'      => $this->request->getVar('nk_angkatan'),
                    'nk_hari'          => $this->request->getVar('nk_hari'),
                    'nk_waktu'         => $this->request->getVar('nk_waktu'),
                    'nk_timezone'      => $this->request->getVar('nk_timezone'),
                    'nk_jenkel'        => $this->request->getVar('nk_jenkel'),
                    'nk_tm_total'      => $this->request->getVar('nk_tm_total'),
                    'nk_tm_methode'    => $this->request->getVar('nk_tm_methode'),
                    'nk_created'       => date('Y-m-d H:i:s'),
                    'nk_status'        => $this->request->getVar('nk_status'),
                ];
                $this->nonreg_kelas->insert($nonreg_kelas_New);
                $nj_kelas = $this->nonreg_kelas->insertID();
                $pengajar     = $this->request->getPost('nj_pengajar');
                foreach ($pengajar as $item) {
                    $nonreg_pengajar_NEW = [
                        'nj_pengajar' => $item,
                        'nj_kelas'    => $nj_kelas,
                    ];
                    $this->nonreg_pengajar->insert($nonreg_pengajar_NEW);
                }
                $this->db->transComplete();
                
                $aktivitas = 'Buat Data Kelas Non-Regular Nama : ' .  $this->request->getVar('nama_kelas');

                if ($this->db->transStatus() === FALSE)
                {
                    /*--- Log ---*/
				    $this->logging('Admin', 'FAIL', $aktivitas);
                }
                else
                {
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
                
                'nk_name' => [
                    'label' => 'nk_name',
                    'rules' => 'required|is_unique_except[nonreg_kelas.nk_name.nk_id.'. $this->request->getVar('nk_id').']',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique_except' => '{field} harus unik, sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'nk_angkatan' => [
                    'label' => 'nk_angkatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Angakatan tidak boleh kosong',
                    ]
                ],
                'nk_hari' => [
                    'label' => 'nk_hari',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Hari tidak boleh kosong',
                    ]
                ],
                'nk_waktu' => [
                    'label' => 'nk_waktu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Waktu tidak boleh kosong',
                    ]
                ],
                'nk_timezone' => [
                    'label' => 'nk_timezone',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Zona Waktu tidak boleh kosong',
                    ]
                ],
                'nk_jenkel' => [
                    'label' => 'nk_jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis Kelamin tidak boleh kosong',
                    ]
                ],
                'nk_tm_total' => [
                    'label' => 'nk_tm_total',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'TM Total tidak boleh kosong',
                    ]
                ],
                'nk_tm_methode' => [
                    'label' => 'nk_tm_methode',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Metode TM tidak boleh kosong',
                    ]
                ],
                'nk_status' => [
                    'label' => 'nk_status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status Kelas tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nk_name'      => $validation->getError('nk_name'),
                        'nk_angkatan'  => $validation->getError('nk_angkatan'),
                        'nk_hari'      => $validation->getError('nk_hari'),
                        'nk_waktu'     => $validation->getError('nk_waktu'),
                        'nk_timezone'  => $validation->getError('nk_timezone'),
                        'nk_jenkel'    => $validation->getError('nk_jenkel'),
                        'nk_tm_total'  => $validation->getError('nk_tm_total'),
                        'nk_tm_methode'=> $validation->getError('nk_tm_methode'),
                        'nk_status'    => $validation->getError('nk_status'),
                    ]
                ];
            } else {

                $updatedata = [
                    'nk_name'          => strtoupper($this->request->getVar('nk_name')),
                    'nk_angkatan'      => $this->request->getVar('nk_angkatan'),
                    'nk_hari'          => $this->request->getVar('nk_hari'),
                    'nk_waktu'         => $this->request->getVar('nk_waktu'),
                    'nk_timezone'      => $this->request->getVar('nk_timezone'),
                    'nk_jenkel'        => $this->request->getVar('nk_jenkel'),
                    'nk_tm_total'      => $this->request->getVar('nk_tm_total'),
                    'nk_tm_methode'    => $this->request->getVar('nk_tm_methode'),
                    'nk_status'        => $this->request->getVar('nk_status'),
                ];

                $nk_id = $this->request->getVar('nk_id');
                $this->nonreg_kelas->update($nk_id, $updatedata);

                // Data Log END
                $aktivitas = 'Ubah Data Kelas Non-Regular Nama : ' .  $this->request->getVar('nama_kelas');
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

    public function delete_peserta()
    {
        if ($this->request->isAJAX()) {

            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');

            //get data kelas peserta
            $get_kelas_peserta  = $this->peserta_kelas->get_kelas_peserta($peserta_kelas_id);
            $kelas_id           = $get_kelas_peserta->data_kelas_id;

            //Data Peserta Kelas - untuk delete data ujian dan data absen
            $peserta_kelas_data = $this->peserta_kelas->find($peserta_kelas_id);
            $data_absen         = $peserta_kelas_data['data_absen'];
            $data_ujian         = $peserta_kelas_data['data_ujian'];

            //Untuk penulisan di log
            $get_peserta_id    = $this->peserta_kelas->get_peserta_id($peserta_kelas_id);
            $peserta_id        = $get_peserta_id->data_peserta_id;
            $data_peserta      = $this->peserta->find($peserta_id);
            $data_kelas        = $this->kelas->find($kelas_id);
            $nama_peserta      = $data_peserta['nama_peserta'];
            $nama_kelas        = $data_kelas['nama_kelas'];

            //hapus data peserta_kelas, ujian dan absen
            $this->db->transStart();
            $this->peserta_kelas->delete($peserta_kelas_id);
            $this->absen_peserta->delete($data_absen);
            $this->ujian->delete($data_ujian);
            $this->db->transComplete();

            $aktivitas = 'Hapus Peserta Kelas, Nama Peserta : ' .  $nama_peserta . ' Pada Kelas ' .  $nama_kelas;

            if ($this->db->transStatus() === FALSE)
            {
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            }
            else
            {
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => 'detail?id='. $kelas_id 
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

        if (count($params) == 1 && array_key_exists('angkatan', $params)) {
            $angkatan           = $params['angkatan'];
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }

        $kelas      =  $this->kelas->list_2nd($angkatan);
        $total_row  = count($kelas)+5;

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

        $judul = "DATA KELAS ALHAQQ ANGAKATAN ".$angkatan." - ACADEMIC ALHAQQ INFORMATION SYSTEM";
        $tgl   = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:M1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:M2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:M4')->applyFromArray($style_up);

        $sheet->getStyle('A5:M'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NAMA KELAS')
            ->setCellValue('B4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('C4', 'PROGRAM')
            ->setCellValue('D4', 'HARI')
            ->setCellValue('E4', 'JAM')
            ->setCellValue('F4', 'PENGAJAR')
            ->setCellValue('G4', 'METODE TATAP MUKA')
            ->setCellValue('H4', 'LEVEL')
            ->setCellValue('I4', 'JENKEL')
            ->setCellValue('J4', 'KUOTA DAFTAR')
            ->setCellValue('K4', 'SISA KUOTA')
            ->setCellValue('L4', 'JUMLAH PESERTA')
            ->setCellValue('M4', 'STATUS KELAS');

            $columns = range('A', 'M');
            foreach ($columns as $column) {
                $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

        $row = 5;

        foreach ($kelas as $data) {

            $sheet->getStyle('F' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $sheet->getStyle('S' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['nama_kelas'])
                ->setCellValue('B' . $row, $data['angkatan_kelas'])
                ->setCellValue('C' . $row, $data['nama_program'])
                ->setCellValue('D' . $row, $data['hari_kelas'])
                ->setCellValue('E' . $row, $data['waktu_kelas'] . ' ' . $data['zona_waktu_kelas'])
                ->setCellValue('F' . $row, $data['nama_pengajar'])
                ->setCellValue('G' . $row, $data['metode_kelas'])
                ->setCellValue('H' . $row, $data['nama_level'])
                ->setCellValue('I' . $row, $data['jenkel'])
                ->setCellValue('J' . $row, $data['kouta'])
                ->setCellValue('K' . $row, $data['kouta']-$data['peserta_kelas_count'])
                ->setCellValue('L' . $row, $data['peserta_kelas_count'])
                ->setCellValue('M' . $row, $data['status_kelas']);

            $row++;
        }

        $writer     = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename   =  'Data-Kelas-'. date('Y-m-d-His');
        $aktivitas  = 'Download Data Kelas via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');
        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    
}