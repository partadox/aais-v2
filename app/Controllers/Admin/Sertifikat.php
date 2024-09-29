<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Mpdf\Mpdf;

class Sertifikat extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('periode', $params)) {
            $periode           = $params['periode'];
            if (ctype_digit($periode)) {
                $periode           = $params['periode'];
            }else {
                $get_periode       = $this->konfigurasi->periode_sertifikat();
                $periode           = $get_periode->periode_sertifikat;
            }
        } else {
            $get_periode       = $this->konfigurasi->periode_sertifikat();
            $periode           = $get_periode->periode_sertifikat;
        }
        
        $list_periode      = $this->sertifikat->list_unik_periode();
        $list_sertifikat    = $this->sertifikat->list($periode);

        $data = [
            'title'         => 'Data Sertifikat Digital Peserta ',
            'user'          => $user,
            'list'          => $list_sertifikat,
            'list_periode'  => $list_periode,
            'periode_pilih' => $periode,
        ];
        return view('panel_admin/sertifikat/index', $data);
    }

    public function input_atur()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'   => 'Form Pengaturan Menu Sertifikat',
                'konfig'  => $this->konfigurasi->list()
            ];
            $msg = [
                'sukses' => view('panel_admin/sertifikat/input_atur', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function input_konfirmasi()
    {
        if ($this->request->isAJAX()) {

            $sertifikat_id   = $this->request->getVar('sertifikat_id');
            $data_sertifikat = $this->sertifikat->find($sertifikat_id);
            $peserta_id      = $data_sertifikat['sertifikat_peserta_id'];
            $data_peserta    = $this->peserta->find($peserta_id); 

            $data = [
                'title'                 => 'Konfirmasi Pendaftaran Sertifikat',
                'sertifikat_id'         => $sertifikat_id,
                'data_sertifikat'       => $data_sertifikat,
                'nama_peserta'          => $data_peserta[0]['nama_peserta'],
                'nis'                   => $data_peserta[0]['nis'],
                'sertifikat_level'      => $data_sertifikat[0]['sertifikat_level'],
                'nominal_bayar_cetak'   => $data_sertifikat[0]['nominal_bayar_cetak'],
                'keterangan_cetak'      => $data_sertifikat[0]['keterangan_cetak']
            ];
            $msg = [
                'sukses' => view('panel_admin/sertifikat/input-konfirmasi', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $form            = $this->request->getVar('form');        
            $sertifikat_id   = $this->request->getVar('sertifikat_id');
            $data_sertifikat = $this->sertifikat->find($sertifikat_id);
            $peserta_id      = $data_sertifikat['sertifikat_peserta_id'];
            $data_peserta    = $this->peserta->find($peserta_id); 

            if ($form == 'show') {
                $title = "e-Sertifikat";
            } elseif($form == 'edit') {
                $title = "Unshow/Delete e-Sertifikat";
            }
            

            $data = [
                'title'                 => $title,
                'form'                  => $form,
                'sertifikat_id'         => $sertifikat_id,
                'data_sertifikat'       => $data_sertifikat,
                'data_peserta'          => $data_peserta,
            ];
            $msg = [
                'sukses' => view('panel_admin/sertifikat/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function konfirmasi()
    {
        $user  = $this->userauth();
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('periode', $params)) {
            $periode           = $params['periode'];
            if (ctype_digit($periode)) {
                $periode           = $params['periode'];
            }else {
                $get_periode       = $this->konfigurasi->periode_sertifikat();
                $periode           = $get_periode->periode_sertifikat;
            }
        } else {
            $get_periode       = $this->konfigurasi->periode_sertifikat();
            $periode           = $get_periode->periode_sertifikat;
        }
        
        $list_periode      = $this->sertifikat->list_unik_periode();
        $list_sertifikat    = $this->sertifikat->list($periode);

        $data = [
            'title'         => 'Data Cetak Sertifikat Peserta Periode ' . $periode,
            'user'          => $user,
            'list'          => $list_sertifikat,
            'list_periode'  => $list_periode,
            'periode_pilih' => $periode,
        ];
        return view('panel_admin/sertifikat/konfirmasi', $data);
    }

    public function detail()
    {
        $user  = $this->userauth();
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('id', $params)) {
            $sertifikat_id           = $params['id'];
            if (ctype_digit($sertifikat_id)) {
                $sertifikat_id           = $params['id'];
            }else {
                return redirect()->to('/sertifikat');
            }
        } else {
            return redirect()->to('/sertifikat');
        }
        
        $sert       = $this->sertifikat->find($sertifikat_id);
        $peserta    = $this->peserta->find($sert['sertifikat_peserta_id']); 

        // Create Mpdf instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4-L',
            'orientation' => 'L'
        ]);
        // Add a page
        $mpdf->AddPage();

        // Set the source file (PDF, image, etc.)
        $sourceFile     = 'public/assets/template/Sertifikat_Mushafy.pdf'; // Replace with the actual path to your source file
        // Output file path
        $outputFilePath = 'public/sertifikat/certificate_' . date('YmdHis') . '.pdf';

        $pageCount = $mpdf->SetSourceFile($sourceFile);

        // Import a page from the source file
        $templateId = $mpdf->ImportPage($pageCount);

        // Use the imported page as a template
        $mpdf->UseTemplate($templateId);

        $pageWidth = $mpdf->w;

        // Variable Nomor Sertifikat
        $mpdf->SetFont('arial', '', 15);
        $mpdf->SetTextColor(235, 183, 52);
        $textWidth  = $mpdf->GetStringWidth($sert['nomor_sertifikat']);
        $centerX    = ($pageWidth - $textWidth) / 2;
        $y          = 77;
        $mpdf->Text($centerX, $y, $sert['nomor_sertifikat']);

        // Variable Nama Peserta
        $mpdf->SetFont('sertifikat-nama', '', 0); //
        $mpdf->SetTextColor(255, 255, 255);
        $namaSert   = ucwords(strtolower($peserta['nama_peserta'])); 
        $textWidth  = $mpdf->GetStringWidth($namaSert);
        $centerX    = ($pageWidth - $textWidth) / 2;
        $y          = 118;
        $mpdf->Text($centerX, $y, $namaSert);

        // Variable tgl
        $mpdf->SetFont('arial', '', 13);
        $mpdf->SetTextColor(255, 255, 255);
        $varTgl     = substr($sert['dt_konfirmasi'], 0, 10);
        $tglSert    = "Balikpapan, ". date_indo($varTgl);
        $textWidth  = $mpdf->GetStringWidth($tglSert);
        $centerX    = (($pageWidth - $textWidth)+6) / 2;
        $y          = 153;
        $mpdf->Text($centerX, $y, $tglSert); // Adjusted coordinates for certificate number

        // Save the generated PDF
        $mpdf->Output($outputFilePath, 'F');
        var_dump($namaSert);

        // Display the PDF in the browser
        // header('Content-Type: application/pdf');
        // header('Content-Disposition: inline; filename="certificate_' . $sert['sertifikat_id'] . '.pdf"');
        // readfile($outputFilePath);
    }

    /*--- BACKEND ---*/

    public function save_atur()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'periode_sertifikat' => [
                    'label' => 'periode_sertifikat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_menu_sertifikat' => [
                    'label' => 'status_menu_sertifikat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'biaya_sertifikat' => [
                    'label' => 'biaya_sertifikat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'periode_sertifikat'      => $validation->getError('periode_sertifikat'),
                        'status_menu_sertifikat'  => $validation->getError('status_menu_sertifikat'),
                        'biaya_sertifikat'        => $validation->getError('biaya_sertifikat'),
                    ]
                ];
            } else {

                $periode_sertifikat         = $this->request->getVar('periode_sertifikat');
                $status_menu_sertifikat     = $this->request->getVar('status_menu_sertifikat');
                //Get data nominal rupiah
                $get_biaya_sertifikat       = $this->request->getVar('biaya_sertifikat');
                $biaya_sertifikat_int       = str_replace(str_split('Rp. .'), '', $get_biaya_sertifikat);
                $biaya_sertifikat           = $biaya_sertifikat_int;

                $data = [
                    'periode_sertifikat'       => $periode_sertifikat,
                    'status_menu_sertifikat'   => $status_menu_sertifikat,
                    'biaya_sertifikat'         => $biaya_sertifikat, 
                ];

                $konfig_id = 1;

                $this->konfigurasi->update($konfig_id, $data);

                $aktivitas = 'Ubah Pengaturan Cetak Sertifikat Menjadi : ' .   $status_menu_sertifikat . ' | Periode Cetak Sertifikat : ' . $periode_sertifikat . ' | Biaya Cetak : ' . $biaya_sertifikat;
                $this->logging('Admin', 'BERHASIL', $aktivitas);
                

                $msg = [
                    'sukses' => [
                        'link' => '/sertifikat'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function save_konfirmasi()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nominal_bayar_cetak' => [
                    'label' => 'nominal_bayar_cetak',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nominal_bayar_cetak'      => $validation->getError('nominal_bayar_cetak'),
                    ]
                ];
            } else {

                $dt = date("Y-m-d H:i:s");

                $get_nominal_bayar_cetak        =  $this->request->getVar('nominal_bayar_cetak');
                $keterangan_cetak               =  $this->request->getVar('keterangan_cetak');
                $nominal_bayar_cetak            = str_replace(str_split('Rp. .'), '', $get_nominal_bayar_cetak);

                $data = [
                    'nominal_bayar_cetak'  => $nominal_bayar_cetak ,
                    'status_cetak'         => 'Terkonfirmasi',
                    'keterangan_cetak'     => $keterangan_cetak,
                    'dt_konfirmasi'        => $dt,
                ];

                $sertifikat_id = $this->request->getVar('sertifikat_id');

                $this->sertifikat->update($sertifikat_id , $data);

                $data_sertifikat = $this->sertifikat->find($sertifikat_id);
                $peserta_id      = $data_sertifikat['sertifikat_peserta_id'];
                $data_peserta    = $this->peserta->find($peserta_id);

                $aktivitas = 'Konfirmasi Pendaftaran Cetak Sertifikat ' .  $data_peserta[0]['nis'] . ' ' . $data_peserta[0]['nama_peserta'];
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'sertifikat'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $sertifikat_id  =  $this->request->getVar('sertifikat_id');
            $tindakan       =  $this->request->getVar('tindakan');
            $unshow         =  $this->request->getVar('unshow');

            $data_sertifikat = $this->sertifikat->find($sertifikat_id);
            $peserta_id      = $data_sertifikat['sertifikat_peserta_id'];
            $data_peserta    = $this->peserta->find($peserta_id);

            if ($unshow == '0') {
                $unshow = NULL;
            }

            $data = [
                'unshow'  => $unshow ,
            ];

            $this->db->transStart();

            if ($tindakan == "hapus") {
                $aktivitas_action = "Hapus e-Sertifikat";
                $state[] = $this->sertifikat->delete($sertifikat_id );
            } else {
                $aktivitas_action = "Ubah Pengaturan Tampil e-Sertifikat di Sisi Peserta";
                $state[] = $this->sertifikat->update($sertifikat_id , $data);
            }

            $aktivitas = $aktivitas_action . ' ' .  $data_peserta['nis'] . ' ' . $data_peserta['nama_peserta'];

            if ($this->db->transStatus() === FALSE)
            {
                $this->db->transRollback();
                /*--- Log ---*/
                $this->logging('Admin', 'FAIL', $aktivitas);
            }
            else
            {
                $this->db->transComplete();
                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            }

            $msg = [
                'sukses' => [
                    'link' => '/sertifikat'
                ]
            ];
        
            echo json_encode($msg);
        }
    }

    public function export()
    {
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('periode', $params)) {
            $periode           = $params['periode'];
            if (ctype_digit($periode)) {
                $periode           = $params['periode'];
            }else {
                $get_periode       = $this->konfigurasi->periode_sertifikat();
                $periode           = $get_periode->periode_sertifikat;
            }
        } else {
            $get_periode       = $this->konfigurasi->periode_sertifikat();
            $periode           = $get_periode->periode_sertifikat;
        }

        $sertifikat = $this->sertifikat->list($periode);
        $judul = "DATA REKAP SERTIFIKAT ";
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

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:M1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', date("Y-m-d"));
        $sheet->mergeCells('A2:M2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'SERTIFIKAT ID')
            ->setCellValue('B4', 'NO. SERTIFIKAT')
            ->setCellValue('C4', 'NIS')
            ->setCellValue('D4', 'NAMA')
            ->setCellValue('E4', 'JENIS KELAMIN')
            ->setCellValue('F4', 'PROGRAM')
            ->setCellValue('G4', 'STATUS')
            ->setCellValue('H4', 'TGL SERTIFIKAT')
            ->setCellValue('I4', 'NOMINAL BAYAR')
            ->setCellValue('J4', 'TRANSAKSI ID')
            ->setCellValue('K4', 'DATA KELAS')
            ->setCellValue('L4', 'KETERANGAN')
            ->setCellValue('M4', 'FILENAME');
        
        $sheet->getStyle('A4')->applyFromArray($border);
        $sheet->getStyle('B4')->applyFromArray($border);
        $sheet->getStyle('C4')->applyFromArray($border);
        $sheet->getStyle('D4')->applyFromArray($border);
        $sheet->getStyle('E4')->applyFromArray($border);
        $sheet->getStyle('F4')->applyFromArray($border);
        $sheet->getStyle('G4')->applyFromArray($border);
        $sheet->getStyle('H4')->applyFromArray($border);
        $sheet->getStyle('I4')->applyFromArray($border);
        $sheet->getStyle('J4')->applyFromArray($border);
        $sheet->getStyle('K4')->applyFromArray($border);
        $sheet->getStyle('L4')->applyFromArray($border);
        $sheet->getStyle('M4')->applyFromArray($border);
        

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

        $row = 5;

        foreach ($sertifikat as $data) {

            if ($data['status'] == 1) {
                $status = "Terkonfirmasi";
            } else {
                $status = "Proses";
            }
            

            if ($data['sertifikat_kelas'] == 1) {
                $kelas = "-";
            } else {
                $kelas = $data['nama_kelas'];
            }

                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['sertifikat_id'])
                ->setCellValue('B' . $row, $data['nomor_sertifikat'])
                ->setCellValue('C' . $row, $data['nis'])
                ->setCellValue('D' . $row, $data['nama_peserta'])
                ->setCellValue('E' . $row, $data['jenkel'])
                ->setCellValue('F' . $row, $data['nama_program'])
                ->setCellValue('G' . $row, $status)
                ->setCellValue('H' . $row, $data['sertifikat_tgl'])
                ->setCellValue('I' . $row, $data['nominal_bayar_cetak'])
                ->setCellValue('J' . $row, $data['bukti_bayar_cetak'])
                ->setCellValue('K' . $row, $kelas)
                ->setCellValue('L' . $row, $data['keterangan_cetak'])
                ->setCellValue('M' . $row, $data['sertifikat_file']);

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

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Sertifikat'.'-' . date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Sertifikat via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
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
            return redirect()->to('/sertifikat');
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

                //Skip data nomor sertifikat duplikat
                $sertifikat    = $this->sertifikat->cek_nomor_sertifikat_duplikat($excel['10']);
                if ($sertifikat != 0 ) {
                    $jumlaherror++;
                } elseif($sertifikat == 0) {

                    $jumlahsukses++;

                    $sertifikat_id = $excel['0'];

                    $data1   = [
                        'status_cetak'         => $excel['5'],
                        'nominal_bayar_cetak'  => $excel['8'],
                        'keterangan_cetak'     => $excel['9'],
                        'nomor_sertifikat'     => $excel['10'],
                        'link_cetak'           => $excel['11'],
                    ];

                    $this->sertifikat->update($sertifikat_id, $data1);

                    $aktivitas = 'Import Data Pengajuan Sertifikat via Import Excel, NIS : ' .   $excel['1'] .  ' Nama : '. $excel['2'];
                    $this->logging('Admin', 'BERHASIL', $aktivitas);
                }
            }

            $this->session->setFlashdata('pesan_sukses', "Data Excel Berhasil Import = $jumlahsukses <br> Data Gagal Import = $jumlaherror");
            return redirect()->to('/sertifikat');
        }
    }

}