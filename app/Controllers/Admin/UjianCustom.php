<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UjianCustom extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('program', $params) && array_key_exists('angkatan', $params) ) {
            $modul              = 'Filter';
            $program_id         = $params['program'];
            $angkatan           = $params['angkatan'];
        } else {
            $modul              = '';
            $program_id         = NULL;
            $angkatan           = NULL;
        }
        
        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_program_uc    = $this->program->list_ujian_custom();

        if ($angkatan != NULL) {
            $angkatan_title     = ' Angkatan Perkuliahan '. $angkatan;
        } else {
            $angkatan_title     = '';
        }
        
        $data = [
            'title'             => 'Data Ujian Custom' . $angkatan_title,
            'user'              => $user,
            'modul'             => $modul,
            'list_angkatan'     => $list_angkatan,
            'angkatan'          => $angkatan,
            'program_id'        => $program_id,
            'list_program_uc'   => $list_program_uc,
        ];
        return view('panel_admin/ujian_custom/index', $data);
    }

    public function modal()
    {
        if ($this->request->isAJAX()) {

            $ucv_id        = $this->request->getVar('ucv_id');
            $program_id    = $this->request->getVar('program_id');
            $peserta_kelas_id= $this->request->getVar('peserta_kelas_id');
            $kelasId       = $this->request->getVar('kelas_id');

            $ucv           = $this->ujian_custom_value->find($ucv_id);
            $peserta       = $this->peserta->find($ucv['ucv_peserta_id']);
            $kelas         = $this->kelas->find($ucv['ucv_kelas_id']);

            $program       = $this->program->find($program_id);
            $ucc           = $this->ujian_custom_config->find($program['ujian_custom_id']);

            $peserta_kelas = $this->peserta_kelas->find($peserta_kelas_id);
            $kelulusan     = $peserta_kelas['status_peserta_kelas'];

            $data = [
                'title'     => 'Data Ujian',
                'ucv'       => $ucv,
                'ucc'       => $ucc,
                'peserta_kelas_id' => $peserta_kelas_id,
                'kelulusan' => $kelulusan,
                'peserta'   => $peserta,
                'kelas'     => $kelas,
                'kelasId'   => $kelasId
            ];
            $msg = [
                'sukses' => view('panel_admin/ujian_custom/modal', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function modal_import()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'     => 'Data Ujian Custom Import',
            ];
            $msg = [
                'sukses' => view('panel_admin/ujian_custom/modal_import', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- BACKEND ---*/

    public function filter()
    {
        $angkatan      = $this->request->getVar('angkatan'); 
        $program       = $this->request->getVar('program');

        $queryParam = 'angkatan=' . $angkatan . '&program=' . $program;

        $newUrl = '/ujian-custom?' . $queryParam; 

        return redirect()->to($newUrl);
    }

    public function list()
    {
        if ($this->request->isAJAX()) {
            $angkatan      = $this->request->getVar('angkatan'); 
            $program_id    = $this->request->getVar('program');

            $program       = $this->program->find($program_id);
            $nama_program  = $program['nama_program'];

            $data = [
                'title'         => 'Data Kedatangan',
                'modul'	        => 'Filter',
                'angkatan'      => $angkatan,
                'program_id'    => $program_id,
                'nama_program'  => $nama_program
            ];
            $msg = [
                'data' => view('panel_admin/ujian_custom/list', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function fetch()
    {
        if ($this->request->isAJAX()) {
            $angkatan      = $this->request->getVar('angkatan'); 
            $program_id    = $this->request->getVar('program');

            $lists 		= $this->peserta_kelas->get_datatables($angkatan, $program_id);
            $data 		= [];
            $no 		= $this->request->getPost('start');


            foreach ($lists as $list) {
                $no++;

                $btn_info = "<button type=\"button\" class=\"btn btn-sm btn-info mb-2 mr-2\" onclick=\"info('$list->ucv_id', '$list->program_id', '$list->peserta_kelas_id')\" ><i class=\" fa fa-arrow-circle-right\"></i> Data Ujian</button>";

                $kelulusan = $list->status_peserta_kelas;
                if ($kelulusan == 'BELUM LULUS') {
                    $btn_lulus= "<button type=\"button\" class=\"btn btn-secondary mb-2 mr-2\" disabled> $kelulusan</button>";
                } elseif($kelulusan == 'LULUS') {
                    $btn_lulus= "<button type=\"button\" class=\"btn btn-success mb-2 mr-2\" disabled> $kelulusan</button>";
                } elseif($kelulusan == 'MENGULANG') {
                    $btn_lulus= "<button type=\"button\" class=\"btn btn-warning mb-2 mr-2\" disabled> $kelulusan</button>";
                }
                
                $row_action = $btn_info;

                $row = [];

                $row[] = $no;
				$row[] = $list->nis;
                $row[] = $list->nama_peserta;
                $row[] = $list->jenkel;
                $row[] = $list->nama_kelas;
                $row[] = $list->angkatan_kelas;
                $row[] = $list->nama_pengajar;
                $row[] = $list->hari_kelas;
                $row[] = $list->waktu_kelas . ' ' . $list->zona_waktu_kelas;
                $row[] = $btn_lulus;
                $row[] = $row_action;

                $data[] = $row;
            }
            $output = [
                "recordTotal"     => $this->peserta_kelas->count_all(),
                "recordsFiltered" => $this->peserta_kelas->count_filtered(),
                "data"            => $data,
            ];
            echo json_encode($output);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {

            $ucv_id = $this->request->getVar('ucv_id');

            for ($i = 1; $i <= 10; $i++) {
                $var_text = 'ucv_text' . $i;
                $var_int = 'ucv_int' . $i;

                $variabel[] = array(
                        $var_text => str_replace(array("\r", "\n"), ' ',$this->request->getVar($var_text)),
                        $var_int => $this->request->getVar($var_int),
                );
            }

            $saveData = [];
            for ($i = 1; $i <= 10; $i++) {
                $textStatusKey = "ucv_text{$i}";
                $intStatusKey = "ucv_int{$i}";

                $saveData[$textStatusKey] = $variabel[$i - 1][$textStatusKey] ?? null;
                $saveData[$intStatusKey] = $variabel[$i - 1][$intStatusKey] ?? null;
            }

            $this->ujian_custom_value->update($ucv_id, $saveData);

            $update_status= [
                'status_peserta_kelas'   => $this->request->getVar('status_peserta_kelas'),
            ];
            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');
            $kelasId            = $this->request->getVar('kelasId');
            $this->peserta_kelas->update($peserta_kelas_id, $update_status);

            $peserta_id     = $this->request->getVar('peserta_id');
            $peserta        = $this->peserta->find($peserta_id);
            $ucv            = $this->ujian_custom_value->find($ucv_id);
            $kelas_id       = $ucv['ucv_kelas_id'];

            $user           = $this->userauth();

            if ($user['level'] == '5' || $user['level'] == '6') {
                $link = '/pengajar/ujian-custom?kelas='.$kelasId;
            } else {
                $aktivitas = 'Ubah Data Ujian Custom, NIS : ' .   $peserta['nis'] .  ' Nama : '. $peserta['nama_peserta'];
                $this->logging('Admin', 'BERHASIL', $aktivitas);
                $link = '/ujian-custom?angkatan='.$this->request->getVar('angkatan').'&program='.$this->request->getVar('program');
            }
            

            $msg = [
                'sukses' => [
                    'link' => $link
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
            $response = [
                'status' => 'error',
                'message' => 'Harap Upload File Berformat Excel!'
            ];
        
            echo json_encode($response);
            return;
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
                $ujian    = $this->ujian_custom_value->cek_ujian($excel['0']);
                if ($ujian != 1 ) {
                    $jumlaherror++;
                } elseif($ujian == 1) {

                    $jumlahsukses++;

                    $ucv_id           = $excel['0'];
                    $peserta_kelas_id = $excel['1'];

                    $ucv              = $this->ujian_custom_value->find($ucv_id);
                    $kelas            = $this->kelas->find($ucv['ucv_kelas_id']);
                    $program_id       = $kelas['program_id'];
                    $program          = $this->program->find($program_id);
                    $ucc              = $this->ujian_custom_config->find($program['ujian_custom_id']);
                    $col_isi          = 10;
                    
                    $angkatan         = $kelas['angkatan_kelas'];
                    $url              = 'angkatan='.$angkatan.'&program='.$program_id;

                    $this->db->transStart();

                    $saveData = [];
                    for ($i=1; $i <= 10; $i++){
                        $col_status     = 'text'.$i.'_status';
                        if($ucc[$col_status] == 1) {
                            $col_isi        = $col_isi+$i;
                            $textStatusKey  = "ucv_text{$i}";
                            $saveData[$textStatusKey] = $excel[$col_isi] ?? null;
                        }
                    }
                    for ($i=1; $i <= 10; $i++){
                        $col_status     = 'int'.$i.'_status';
                        if($ucc[$col_status] == 1) {
                            $col_isi        = $col_isi+$i;
                            $textStatusKey  = "ucv_int{$i}";
                            $saveData[$textStatusKey] = $excel[$col_isi] ?? null;
                        }
                    }

                    $this->ujian_custom_value->update($ucv_id, $saveData);

                    $data2   = [
                        'status_peserta_kelas'                => strtoupper($excel['10']),
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $data2);
                    $this->db->transComplete();
                    $aktivitas = 'Ubah Data Ujian Custom via Import Excel, NIS : ' .   $excel['2'] .  ' Nama : '. $excel['3'];
                    
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

            $response = [
                'status' => 'success',
                'message' => 'Data Excel Berhasil Import ='. $jumlahsukses . ' <br> Data Gagal Import =' . $jumlaherror,
                'url'    => '/ujian-custom?'.$url,
            ];
        
            echo json_encode($response);
            return;
        }
    }

    public function export()
    {
        //Angkatan
		$angkatan           = $this->request->getVar('angkatan'); 
        $program_id         = $this->request->getVar('program'); 

        $ujian      = $this->peserta_kelas->admin_rekap_ujian_custom($angkatan, $program_id);
        $program    = $this->program->find($program_id);
        $ucc        = $this->ujian_custom_config->find($program['ujian_custom_id']);
        $total_row  = count($ujian) + 4;
        $col_isi    = 0;

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

        $judul = "DATA REKAP HASIL UJIAN CUSTOM PESERTA  - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = "ANGKATAN PERKULIAHAN " . $angkatan . " PROGRAM " . $program['nama_program'] . " - " . date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:T1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:T2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:AE4')->applyFromArray($style_up);

        $sheet->getStyle('A5:AE'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'UCV_ID')
            ->setCellValue('B4', 'PESERTA KLS ID')
            ->setCellValue('C4', 'NIS')
            ->setCellValue('D4', 'NAMA')
            ->setCellValue('E4', 'JENIS KELAMIN')
            ->setCellValue('F4', 'KELAS')
            ->setCellValue('G4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('H4', 'PENGAJAR')
            ->setCellValue('I4', 'HARI KELAS')
            ->setCellValue('J4', 'WAKTU KELAS')
            ->setCellValue('K4', 'KELULUSAN');
        
        for ($i=1; $i <= 10; $i++){
            $col_status     = 'text'.$i.'_status';
            $col_name       = 'text'.$i.'_name'  ;

            $col_letter = chr(64 + $i + 11); 
            if($ucc[$col_status] == 1) {
                $cell = $col_letter.'4';
                $spreadsheet->getActiveSheet()
                ->setCellValue($cell, $ucc[$col_name]);
                $col_isi = $col_isi+1;
            }
        }

        for ($i=1; $i <= 10; $i++){
            $col_status     = 'int'.$i.'_status';
            $col_name       = 'int'.$i.'_name'  ;

            $col_letter = chr(64 + $i + (11+$col_isi)); 
            if($ucc[$col_status] == 1) {
                $cell = $col_letter.'4';
                $spreadsheet->getActiveSheet()
                ->setCellValue($cell, $ucc[$col_name]);
            }
        }
    
        $columns = range('A', 'Z');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
        $columns = array('AA', 'AB', 'AC', 'AD', 'AE');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;

        foreach ($ujian as $data) {

                $waktu = $data['waktu_kelas'] . ' ' . $data['zona_waktu_kelas'];

                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['ucv_id'])
                ->setCellValue('B' . $row, $data['peserta_kelas_id'])
                ->setCellValue('C' . $row, $data['nis'])
                ->setCellValue('D' . $row, $data['nama_peserta'])
                ->setCellValue('E' . $row, $data['jenkel'])
                ->setCellValue('F' . $row, $data['nama_kelas'])
                ->setCellValue('G' . $row, $data['angkatan_kelas'])
                ->setCellValue('H' . $row, $data['nama_pengajar'])
                ->setCellValue('I' . $row, $data['hari_kelas'])
                ->setCellValue('J' . $row, $waktu)
                ->setCellValue('K' . $row, $data['status_peserta_kelas']);

                for ($i=1; $i <= 10; $i++){
                    $col_status = 'text'.$i.'_status';
                    $col_letter = chr(64 + $i + 11); 
                    $val        = 'ucv_text'.$i;
                    if($ucc[$col_status] == '1') {
                        $cell = $col_letter.$row;
                        $spreadsheet->getActiveSheet()
                        ->setCellValue($cell, $data[$val]);
                    }
                }

                for ($i=1; $i <= 10; $i++){
                    $col_status = 'int'.$i.'_status';
                    $col_letter = chr(64 + $i + (11+$col_isi)); 
                    $val        = 'ucv_int'.$i;
                    if($ucc[$col_status] == '1') {
                        $cell = $col_letter.$row;
                        $spreadsheet->getActiveSheet()
                        ->setCellValue($cell, $data[$val]);
                    }
                }

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Ujian-Custom-Program '.$program['nama_program'].'-Angkatan '.$angkatan.'-'. date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Ujian Custom via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');
        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}