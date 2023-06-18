<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

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
            'title'         => 'Data Cetak Sertifikat Peserta Periode ' . $periode,
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
                'title'   => 'Form Pengaturan Pendaftaran Sertifikat',
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

            $sertifikat_id   = $this->request->getVar('sertifikat_id');
            $data_sertifikat = $this->sertifikat->find($sertifikat_id);
            $peserta_id      = $data_sertifikat['sertifikat_peserta_id'];
            $data_peserta    = $this->peserta->find($peserta_id); 

            $data = [
                'title'                 => 'Edit Data Pendaftaran Sertifikat',
                'sertifikat_id'         => $sertifikat_id,
                'data_sertifikat'       => $data_sertifikat,
                'nama_peserta'          => $data_peserta[0]['nama_peserta'],
                'nis'                   => $data_peserta[0]['nis'],
                'sertifikat_level'      => $data_sertifikat[0]['sertifikat_level'],
                'nominal_bayar_cetak'   => $data_sertifikat[0]['nominal_bayar_cetak'],
                'keterangan_cetak'      => $data_sertifikat[0]['keterangan_cetak'],
                'nomor_sertifikat'      => $data_sertifikat[0]['nomor_sertifikat'],
                'status_cetak'          => $data_sertifikat[0]['status_cetak'],
                'link_cetak'            => $data_sertifikat[0]['link_cetak'],
            ];
            $msg = [
                'sukses' => view('auth/akademik/edit_sertifikat', $data)
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
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nominal_bayar_cetak' => [
                    'label' => 'nominal_bayar_cetak',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sertifikat_level' => [
                    'label' => 'sertifikat_level',
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
                        'sertifikat_level'      => $validation->getError('sertifikat_level'),
                    ]
                ];
            } else {

                $dt = date("Y-m-d H:i:s");

                $get_nominal_bayar_cetak        =  $this->request->getVar('nominal_bayar_cetak');
                $keterangan_cetak               =  $this->request->getVar('keterangan_cetak');

                $sertifikat_level               =  $this->request->getVar('sertifikat_level');
                $status_cetak                   =  $this->request->getVar('status_cetak');
                $nomor_sertifikat               =  $this->request->getVar('nomor_sertifikat');
                $link_cetak                     =  $this->request->getVar('link_cetak');

                $nominal_bayar_cetak            = str_replace(str_split('Rp. .'), '', $get_nominal_bayar_cetak);

                $data = [
                    'nominal_bayar_cetak'  => $nominal_bayar_cetak ,
                    'sertifikat_level'     => $sertifikat_level,
                    'status_cetak'         => $status_cetak,
                    'nomor_sertifikat'     => $nomor_sertifikat,
                    'link_cetak'           => $link_cetak,
                    'keterangan_cetak'     => $keterangan_cetak,
                    'dt_konfirmasi'        => $dt,
                ];

                $sertifikat_id = $this->request->getVar('sertifikat_id');

                $this->sertifikat->update($sertifikat_id , $data);

                $data_sertifikat = $this->sertifikat->find($sertifikat_id);
                $peserta_id      = $data_sertifikat['sertifikat_peserta_id'];
                $data_peserta    = $this->peserta->find($peserta_id);

                $aktivitas = 'Ubah Data Pendaftaran Cetak Sertifikat ' .  $data_peserta[0]['nis'] . ' ' . $data_peserta[0]['nama_peserta'];
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
        $judul = "DATA REKAP PENGAJUAN CETAK SERTIFIKAT PERIODE " . $periode;
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
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', date("Y-m-d"));
        $sheet->mergeCells('A2:L2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'SERTIFIKAT ID')
            ->setCellValue('B4', 'NIS')
            ->setCellValue('C4', 'NAMA')
            ->setCellValue('D4', 'JENIS KELAMIN')
            ->setCellValue('E4', 'SERTIFIKAT LEVEL')
            ->setCellValue('F4', 'STATUS SERTIFIKAT')
            ->setCellValue('G4', 'WAKTU PENGAJUAN')
            ->setCellValue('H4', 'WAKTU KONFIRMASI')
            ->setCellValue('I4', 'NOMINAL BAYAR')
            ->setCellValue('J4', 'KETERANGAN')
            ->setCellValue('K4', 'NO. SERTIFIKAT')
            ->setCellValue('L4', 'LINK UNDUH');
        
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

        $row = 5;

        foreach ($sertifikat as $data) {

                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['sertifikat_id'])
                ->setCellValue('B' . $row, $data['nis'])
                ->setCellValue('C' . $row, $data['nama_peserta'])
                ->setCellValue('D' . $row, $data['jenkel'])
                ->setCellValue('E' . $row, $data['sertifikat_level'])
                ->setCellValue('F' . $row, $data['status_cetak'])
                ->setCellValue('G' . $row, $data['dt_ajuan'])
                ->setCellValue('H' . $row, $data['dt_konfirmasi'])
                ->setCellValue('I' . $row, $data['nominal_bayar_cetak'])
                ->setCellValue('J' . $row, $data['keterangan_cetak'])
                ->setCellValue('K' . $row, $data['nomor_sertifikat'])
                ->setCellValue('L' . $row, $data['link_cetak']);

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

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Sertifikat-Cetak-Periode-' . $periode  . '-' . date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Pengajuan Sertifikat via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');
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