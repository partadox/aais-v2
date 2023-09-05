<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Beasiswa extends BaseController
{
    public function index()
	{
		$user  = $this->userauth(); // Return Array

		$data = [
			'title' 				=> 'Beasiswa',
			'user'  				=> $user,
		];
		return view('panel_admin/beasiswa/index', $data);
	}

	public function list()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Beasiswa',
            ];
            $msg = [
                'data' => view('panel_admin/beasiswa/list', $data)
            ];
            echo json_encode($msg);
        }
    }

	public function getdata()
    {
		
		if ($this->request->isAJAX()) {
			$user  		= $this->userauth(); // Return Array
			$level_user = $user['level'];
			$lists 		= $this->beasiswa->get_datatables();
            $data 		= [];
            $no 		= $this->request->getPost('start');
            foreach ($lists as $list) {
                $no++;

                $row = [];
                if ($level_user == 1 || $level_user == 2 || $level_user == 3 || $level_user == 7) {
                    
                    $hapus = "<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"hapus('" . $list->beasiswa_id . "','" . $list->nama_peserta . "','" . $list->peserta_id . "'" ." )\">
                    <i class=\"fa fa-trash\"></i>
                </button>";
                } else {
                    $hapus = "";
                }
                
                if($list->beasiswa_status == '0'){$beasiswa_status = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled>TERSEDIA</button>";}
                elseif($list->beasiswa_status == '1'){$beasiswa_status = "<button type=\"button\" class=\"btn btn-secondary btn-sm\" disabled>TERPAKAI</button>";}

                $beasiswa_daftar= '';
                $beasiswa_spp1  = '';
                $beasiswa_spp2  = '';
                $beasiswa_spp3  = '';
                $beasiswa_spp4  = '';

                if($list->beasiswa_daftar == '1'){$beasiswa_daftar = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled><i class=\"fa fa-check\"></i></button>";}
                if($list->beasiswa_spp1 == '1'){$beasiswa_spp1 = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled><i class=\"fa fa-check\"></i></button>";}
                if($list->beasiswa_spp2 == '1'){$beasiswa_spp2 = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled><i class=\"fa fa-check\"></i></button>";}
                if($list->beasiswa_spp3 == '1'){$beasiswa_spp3 = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled><i class=\"fa fa-check\"></i></button>";}
                if($list->beasiswa_spp4 == '1'){$beasiswa_spp4 = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled><i class=\"fa fa-check\"></i></button>";}
                

                $row[] = "<input type=\"checkbox\" name=\"beasiswa_id[]\" class=\"centangBeasiswaid\" value=\"$list->beasiswa_id\">" ." ".$no;
                $row[] = $list->nis;
                $row[] = $list->beasiswa_code;
				$row[] = $list->nama_peserta;
                $row[] = $list->nama_program;
                $row[] = $beasiswa_status;
                $row[] = $beasiswa_daftar;
                $row[] = $beasiswa_spp1;
                $row[] = $beasiswa_spp2;
                $row[] = $beasiswa_spp3;
                $row[] = $beasiswa_spp4;
                $row[] = $list->beasiswa_create;
                $row[] = $list->beasiswa_used;
                $row[] = $hapus;
                $data[] = $row;
            }
            $output = [
                "recordTotal"     => $this->beasiswa->count_all(),
                "recordsFiltered" => $this->beasiswa->count_filtered(),
                "data"            => $data,
                "userLevel"       => $level_user 
            ];
            echo json_encode($output);
			
		}
        
    }

	public function input()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'             => 'Form Input Beasiswa',
                'peserta'           => $this->peserta->list(),
                'program'           => $this->program->list(),
            ];
            $msg = [
                'sukses' => view('panel_admin/beasiswa/add', $data)
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
                'beasiswa_peserta' => [
                    'label' => 'Peserta',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'beasiswa_program' => [
                    'label' => 'Program',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'beasiswa_peserta'  => $validation->getError('beasiswa_peserta'),
                        'beasiswa_program'      => $validation->getError('beasiswa_program'),
                    ]
                ];
            } else {
                $peserta_id = $this->request->getVar('beasiswa_peserta');
                $program_id = $this->request->getVar('beasiswa_program');
                $peserta    = $this->peserta->find($peserta_id);
                $program    = $this->program->find($program_id);

                $length = 6;
                $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $code = '';
                
                for ($i = 0; $i < $length; $i++) {
                    $randomIndex = mt_rand(0, strlen($characters) - 1);
                    $code .= $characters[$randomIndex];
                }

                $simpandata = [
                    'beasiswa_code'   => $code,
                    'beasiswa_peserta'=> $peserta_id,
                    'beasiswa_program'=> $program_id,
                    'beasiswa_status' => 0,
                    'beasiswa_daftar' => $this->request->getPost('beasiswa_daftar'),
                    'beasiswa_spp1'   => $this->request->getPost('beasiswa_spp1'),
                    'beasiswa_spp2'   => $this->request->getPost('beasiswa_spp2'),
                    'beasiswa_spp3'   => $this->request->getPost('beasiswa_spp3'),
                    'beasiswa_spp4'   => $this->request->getPost('beasiswa_spp4'),
                    'beasiswa_create' => date('Y-m-d H:i:s'),
                ];

                $this->beasiswa->insert($simpandata);

                $aktivitas = 'Buat Kode Beasiswa Peserta : ' . $peserta['nis'] . '-' . $peserta['nama_peserta'].' untuk Program ' . $program['nama_program'];

                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'beasiswa'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $beasiswa_id = $this->request->getVar('beasiswa_id');
            $peserta_id  = $this->request->getVar('peserta_id');
            $peserta     = $this->peserta->find($peserta_id);
            $aktivitas   = 'Hapus Data Beasiswa Peserta : ' .  $peserta['nis'] . ' ' . $peserta['nama_peserta'];

            $this->db->transStart();
            $this->beasiswa->delete($beasiswa_id);
            $this->db->transComplete();

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
                    'link' => 'beasiswa'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function deleteselect()
    {
        if ($this->request->isAJAX()) {
            $beasiswa_id = $this->request->getVar('beasiswa_id');
            if (count($beasiswa_id) != NULL) {
                foreach ($beasiswa_id as $item) {
                    $beasiswa = $this->beasiswa->find($item);
                    $peserta_id    = $beasiswa['beasiswa_peserta'];
                    $peserta = $this->peserta->find($peserta_id);
                    $aktivitas   = 'Hapus Data Beasiswa Peserta : ' .  $peserta['nis'] . ' ' . $peserta['nama_peserta'];
                    $this->db->transStart();
                    $this->beasiswa->delete($item);
                    $this->db->transComplete();

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
            //var_dump($peserta);
            $msg = [
                'sukses' => [
                    'link' => 'beasiswa'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function import()
    {
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
            return redirect()->to('index');
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

                //Cek apakah peserta / program ada
                $cek_peserta   = $this->peserta->cek_peserta_id($excel['1']);
                $cek_program   = $this->program->cek_program_id($excel['2']);

                if ($cek_peserta != 1 && $cek_program != 1) {
                    $jumlaherror++;
                    if ($cek_peserta != 1) {
                        $gagal1 =  ' ID peserta tidak ditemukan';
                    } else{
                        $gagal1 = '';
                    }
                    
                    if ($cek_peserta != 1) {
                        $gagal2 =  ' ID program tidak ditemukan';
                    } else{
                        $gagal2 = '';
                    }

                    $aktivitas1 = 'Buat Data Beasiswa via Import Excel, No : '  . $excel['0'] . ' - ' .  $excel['4'] . $gagal1 . $gagal2;

                     /*--- Log ---*/
                     $this->logging('Admin', 'GAGAL', $aktivitas1);

                } elseif($cek_peserta == 1 && $cek_program == 1) {

                    $length = 6;
                    $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    $code = '';
                    
                    for ($i = 0; $i < $length; $i++) {
                        $randomIndex = mt_rand(0, strlen($characters) - 1);
                        $code .= $characters[$randomIndex];
                    }

                    $peserta = $this->peserta->find($excel['1']);
                    $program = $this->program->find($excel['2']);

                    $data   = [
                        'beasiswa_code'      => $code,
                        'beasiswa_peserta'   => $excel['1'],
                        'beasiswa_program'   => $excel['2'],
                        'beasiswa_status'    => '0',
                        'beasiswa_daftar'    => $excel['3'],
                        'beasiswa_spp1'      => $excel['4'],
                        'beasiswa_spp2'      => $excel['5'],
                        'beasiswa_spp3'      => $excel['6'],
                        'beasiswa_spp4'      => $excel['7'],
                        'beasiswa_create'    => date('Y-m-d H:i:s'),
                    ];
                    $this->db->transStart();
                    $this->beasiswa->insert($data);
                    $this->db->transComplete();

                    $aktivitas = 'Buat Data Beasiswa via Import Excel, Peserta : ' . $peserta['nis'] . '-' . $peserta['nama_peserta'].' untuk Program ' . $program['nama_program'];

                    if ($this->db->transStatus() === FALSE)
                    {
                        /*--- Log ---*/
                        $this->logging('Admin', 'FAIL', $aktivitas);
                    }
                    else
                    {
                        $jumlahsukses++;
                        /*--- Log ---*/
                        $this->logging('Admin', 'BERHASIL', $aktivitas);
                    }
                }
            }
            $this->session->setFlashdata('pesan_sukses', "Data Excel Berhasil Import = $jumlahsukses <br> Data Gagal Import = $jumlaherror");
            return redirect()->to('beasiswa');
        }
    }
    
    public function export()
    {
        $beasiswa    =  $this->beasiswa->list();
        $total_row  =  count($beasiswa) + 5;

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

        $judul = "DATA BEASISWA ALHAQQ - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:L2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:L4')->applyFromArray($style_up);

        $sheet->getStyle('A5:L'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'KODE BEASISWA')
            ->setCellValue('B4', 'NIS')
            ->setCellValue('C4', 'NAMA')
            ->setCellValue('D4', 'PROGRAM')
            ->setCellValue('E4', 'STATUS BEASISWA')
            ->setCellValue('F4', 'DAFTAR')
            ->setCellValue('G4', 'SPP-1')
            ->setCellValue('H4', 'SPP-2')
            ->setCellValue('I4', 'SPP-3')
            ->setCellValue('J4', 'SPP-4')
            ->setCellValue('K4', 'DT. DIBUAT')
            ->setCellValue('L4', 'DT. DIGUNAKAN');

        $columns = range('A', 'L');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;

        foreach ($beasiswa as $data) {

            if ($data['beasiswa_status'] == '0') {
                $beasiswa_status = 'TERSEDIA';
            } else {
                $beasiswa_status = 'TERPAKAI';
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['beasiswa_code'])
                ->setCellValue('B' . $row, $data['nis'])
                ->setCellValue('C' . $row, $data['nama_peserta'])
                ->setCellValue('D' . $row, $data['nama_program'])
                ->setCellValue('E' . $row, $beasiswa_status)
                ->setCellValue('F' . $row, $data['beasiswa_daftar'])
                ->setCellValue('G' . $row, $data['beasiswa_spp1'])
                ->setCellValue('H' . $row, $data['beasiswa_spp2'])
                ->setCellValue('I' . $row, $data['beasiswa_spp3'])
                ->setCellValue('J' . $row, $data['beasiswa_spp4'])
                ->setCellValue('K' . $row, $data['beasiswa_create'])
                ->setCellValue('L' . $row, $data['beasiswa_used']);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Beasiswa-'. date('Y-m-d-His');

        $aktivitas =  'Download Data Beasiswa via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}