<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Ujian extends BaseController
{
    public function index()
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
            }else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }
        
        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_ujian         = $this->peserta_kelas->admin_rekap_ujian($angkatan);

        $data = [
            'title'         => 'Data Ujian Peserta pada Angkatan Perkuliahan ' . $angkatan,
            'user'          => $user,
            'list'          => $list_ujian,
            'list_angkatan' => $list_angkatan,
            'angkatan_pilih'=> $angkatan,
        ];
        return view('panel_admin/ujian/index', $data);
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $ujian_id           = $this->request->getVar('ujian_id');
            $peserta_id         = $this->request->getVar('peserta_id');
            $kelas_id           = $this->request->getVar('kelas_id');
            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');

            $ujian          =  $this->ujian->find($ujian_id);
            $peserta        =  $this->peserta->find($peserta_id);
            $kelas          =  $this->kelas->find($kelas_id);
            $peserta_kelas  = $this->peserta_kelas->find($peserta_kelas_id);

            $data = [
                'title'             => 'Edit Data Ujian Peserta Atas Nama : ' . $peserta['nis'] . ' - ' . $peserta['nama_peserta'],
                'ujian'             => $ujian,
                'peserta'           => $peserta,
                'kelas'             => $kelas,
                'peserta_kelas_id'  => $peserta_kelas_id,
                'peserta_kelas'     => $peserta_kelas,
                'peserta_id'        => $peserta_id,
                'level'             => $this->level->list()
            ];
            $msg = [
                'sukses' => view('panel_admin/ujian/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- BACKEND ---*/

    public function update()
    {
        if ($this->request->isAJAX()) {
            
            $update_data_ujian = [
                'tgl_ujian'             => $this->request->getVar('tgl_ujian'),
                'waktu_ujian'           => $this->request->getVar('waktu_ujian'),
                'nilai_ujian'           => $this->request->getVar('nilai_ujian'),
                'nilai_akhir'           => $this->request->getVar('nilai_akhir'),
                'next_level'            => $this->request->getVar('next_level'),
                'ujian_note'            => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('ujian_note'))),
            ];

            $update_status= [
                'status_peserta_kelas'   => $this->request->getVar('status_peserta_kelas'),
            ];

            $ujian_id           = $this->request->getVar('ujian_id');
            $this->ujian->update($ujian_id, $update_data_ujian);

            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');
            $this->peserta_kelas->update($peserta_kelas_id, $update_status);

            $peserta_id     = $this->request->getVar('peserta_id');
            $peserta        =  $this->peserta->find($peserta_id);

            $aktivitas = 'Ubah Data Ujian, NIS : ' .   $peserta['nis'] .  ' Nama : '. $peserta['nama_peserta'];
            $this->logging('Admin', 'BERHASIL', $aktivitas);
             
            $msg = [
                'sukses' => [
                    'link' => '/ujian'
                ]
            ];
            
            echo json_encode($msg);
        }
    }

    public function import()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'file_excel' => [
                'rules' => 'uploaded[file_excel]|ext_in[file_excel,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Harap Upload',
                    'ext_in' => 'Harus File Excel!'
                ]
            ]
        ]);

        if (!$valid) {
            $this->session->setFlashdata('pesan_error', 'ERROR! Untuk Import Harap Upload File Berjenis Excel!');
            return redirect()->to('/ujian');
        } else {
            $file   = $this->request->getFile('file_excel');
            $ext    = $file->getClientExtension();

            if ($ext == 'xls') {
                $render     = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else{
                $render     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $render->load($file);
            $sheet       = $spreadsheet->getActiveSheet()->toArray();

            $jumlaherror   = 0;
            $jumlahsukses  = 0;

            foreach ($sheet as $x => $excel) {

                //Skip row pertama - keempat (judul tabel)
                if ($x == 0) {
                    continue;
                }
                if ($x == 1) {
                    continue;
                }
                if ($x == 2) {
                    continue;
                }
                if ($x == 3) {
                    continue;
                }

                //Skip data akun username duplikat
                $ujian    = $this->ujian->cek_ujian($excel['0']);
                if ($ujian != 1 ) {
                    $jumlaherror++;
                } elseif($ujian == 1) {

                    $jumlahsukses++;

                    $id_ujian = $excel['0'];
                    $get_id_peserta_kelas = $this->peserta_kelas->get_peserta_kelas_id_ujian($id_ujian);
                    $peserta_kelas_id = $get_id_peserta_kelas-> peserta_kelas_id;

                    $this->db->transStart();
                    $data1   = [
                        'tgl_ujian'                => $excel['9'],
                        'waktu_ujian'              => $excel['10'],
                        'nilai_ujian'              => $excel['11'],
                        'nilai_akhir'              => $excel['12'],
                        'next_level'               => $excel['13'],
                        'ujian_note'               => trim(preg_replace('/\s\s+/', ' ', $excel['15'])),
                    ];
                    $this->ujian->update($id_ujian, $data1);

                    $data2   = [
                        'status_peserta_kelas'                => strtoupper($excel['14']),
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $data2);
                    $this->db->transComplete();
                    $aktivitas = 'Ubah Data Ujian via Import Excel, NIS : ' .   $excel['1'] .  ' Nama : '. $excel['2'];
                    
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

                        }
                    }

            $this->session->setFlashdata('pesan_sukses', "Data Excel Berhasil Import = $jumlahsukses <br> Data Gagal Import = $jumlaherror");
            return redirect()->to('/ujian');
        }
    }

    public function export()
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
            }else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
        }

        $ujian      = $this->peserta_kelas->admin_rekap_ujian($angkatan);
        $total_row  = count($ujian) + 4;
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

        $judul = "DATA REKAP HASIL UJIAN PESERTA  - ACADEMIC ALHAQQ INFORMATION SYSTEM";
        $tgl   = "ANGKATAN PERKULIAHAN " . $angkatan . " - " . date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:P1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:P2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:P4')->applyFromArray($style_up);

        $sheet->getStyle('A5:P'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'ID UJIAN')
            ->setCellValue('B4', 'NIS')
            ->setCellValue('C4', 'NAMA')
            ->setCellValue('D4', 'JENIS KELAMIN')
            ->setCellValue('E4', 'KELAS')
            ->setCellValue('F4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('G4', 'PENGAJAR')
            ->setCellValue('H4', 'HARI KELAS')
            ->setCellValue('I4', 'WAKTU KELAS')
            ->setCellValue('J4', 'TGL UJIAN')
            ->setCellValue('K4', 'WAKTU UJIAN')
            ->setCellValue('L4', 'NILAI UJIAN')
            ->setCellValue('M4', 'NILAI AKHIR')
            ->setCellValue('N4', 'LEVEL SELANJUTNYA')
            ->setCellValue('O4', 'KELULUSAN')
            ->setCellValue('P4', 'KESAN PENGAJAR');
        
        $columns = range('A', 'P');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;

        foreach ($ujian as $data) {

                $waktu = $data['waktu_kelas'] . ' ' . $data['zona_waktu_kelas'];

                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['ujian_id'])
                ->setCellValue('B' . $row, $data['nis'])
                ->setCellValue('C' . $row, $data['nama_peserta'])
                ->setCellValue('D' . $row, $data['jenkel'])
                ->setCellValue('E' . $row, $data['nama_kelas'])
                ->setCellValue('F' . $row, $data['angkatan_kelas'])
                ->setCellValue('G' . $row, $data['nama_pengajar'])
                ->setCellValue('H' . $row, $data['hari_kelas'])
                ->setCellValue('I' . $row, $waktu)
                ->setCellValue('J' . $row, $data['tgl_ujian'])
                ->setCellValue('K' . $row, $data['waktu_ujian'])
                ->setCellValue('L' . $row, $data['nilai_ujian'])
                ->setCellValue('M' . $row, $data['nilai_akhir'])
                ->setCellValue('N' . $row, $data['next_level'])
                ->setCellValue('O' . $row, $data['status_peserta_kelas'])
                ->setCellValue('P' . $row, $data['ujian_note']);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Ujian-Reguler-Angkata'.$angkatan.'-'. date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Ujian Peserta via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');
        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}