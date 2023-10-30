<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pembayaran extends BaseController
{
    /*--- TRANSAKSI BAYAR ---*/
    //frontend
	public function index()
	{
		$user  = $this->userauth(); // Return Array

        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('angkatan', $params) && array_key_exists('payment', $params)) {
            $angkatan           = $params['angkatan'];
            if (ctype_digit($angkatan)) {
                $angkatan           = $params['angkatan'];
            }else {
                $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
                $angkatan           = $get_angkatan->angkatan_kuliah;
            }
            $payment_filter     = $params['payment'];
            if ($payment_filter == 'all' || $payment_filter == 'tf' || $payment_filter == 'flip' || $payment_filter == 'beasiswa') {
                $payment_filter = $params['payment'];
            }else {
                $payment_filter = 'all';
            }
        } else {
            $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
            $angkatan           = $get_angkatan->angkatan_kuliah;
            $payment_filter     = "all";
        }
		$list_angkatan      = $this->kelas->list_unik_angkatan();

		$data = [
			'title' 				=> 'Semua Pembayaran',
			'user'  				=> $user,
            'angkatan'              => $angkatan,
            'list_angkatan'         => $list_angkatan,
            'payment_filter'        => $payment_filter
		];
		return view('panel_admin/pembayaran/index', $data);
	}

    public function pembayaran_filter()
    {
        $angkatan_filter = $this->request->getVar('angkatan_filter'); 
        $payment_filter = $this->request->getVar('payment_filter'); 

        $queryParam = 'angkatan=' . $angkatan_filter. '&payment=' . $payment_filter ;

        $newUrl = 'pembayaran?' . $queryParam; 

        return redirect()->to($newUrl);
    }

	public function list()
    {
        if ($this->request->isAJAX()) {
            $angkatan       = $this->request->getPost('angkatan');
            $payment_filter = $this->request->getPost('payment_filter');
            $data = [
                'title'         => 'Pembayaran',
                'angkatan'      => $angkatan,
                'payment_filter'=> $payment_filter,
            ];
            $msg = [
                'data' => view('panel_admin/pembayaran/list', $data)
            ];
            echo json_encode($msg);
        }
    }

	public function getdata()
    {
		
		if ($this->request->isAJAX()) {
			$user  		= $this->userauth(); // Return Array

            $angkatan       = $this->request->getPost('angkatan');
            $payment_filter = $this->request->getPost('payment_filter');
            
			$lists 		= $this->bayar->get_datatables($angkatan, $payment_filter);
            $data 		= [];
            $no 		= $this->request->getPost('start');
            foreach ($lists as $list) {
                $no++;

                $row = [];

                $row3 = "";
                $row4 = "";
                $row5 = "";
                $row6 = "";
                $row7 = "";
                $row8a = "";
                $row8b = "";
                $btn_edit = "";
                $btn_hapus = "";
                $btn_bukti = "";
                $btn_bill = "";

                $row2 = "<h6>Nama: $list->nama_peserta</h6><p>NIS:$list->nis </p><p>Kelas: $list->nama_kelas</p>";

                if($list->metode == NULL){
                    $row3 = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled>TF Manual</button>";
                    $row7 = "<img class=\"zoom\"  src=\"public/img/transfer/$list->bukti_bayar\" alt=\"\" width=\"150\" align=\"right\" border=\"1\" hspace=\"\" vspace=\"\" style=\"transition: transform .2s;\" onmouseover=\"this.style.transform='scale(2.5)'\" onmouseout=\"this.style.transform='scale(1)'\"/>";
                    $btn_edit = "<button type=\"button\" class=\"btn btn-warning mb-2\" onclick=\"edit('$list->bayar_id')\" ><i class=\"fa fa-edit mr-1\"></i>Edit</button>";
                    $btn_bukti = "<button type=\"button\" class=\"btn btn-info mb-2\" onclick=\"gambar('$list->bayar_id')\" ><i class=\" fa fa-image mr-1\"></i> Bukti</button>";

                    if ($list->status_konfirmasi != "Proses") {
                        $btn_hapus = "<button type=\"button\" class=\"btn btn-danger mb-2\" onclick=\"hapus('$list->bayar_id')\" ><i class=\" fa fa-trash mr-1\"></i>Hapus</button>";
                    }

                }
                elseif($list->metode == 'flip'){
                    $row3 = "<button type=\"button\" class=\"btn btn-primary btn-sm\" disabled>Flip</button>";}
                elseif($list->metode == 'beasiswa'){
                    $row3 = "<button type=\"button\" class=\"btn btn-info btn-sm\" disabled>Beasiswa</button>";};

                $row4 = "<p>Tgl:  $list->tgl_bayar</p><p>Jam: $list->waktu_bayar</p>";
                $row5 = "<a>Total: Rp ". rupiah($list->nominal_bayar) ."</a> <br>
                <a>Daftar: Rp ". rupiah($list->awal_bayar_daftar) ." </a> <br>
                <a>SPP1: Rp ".rupiah($list->awal_bayar_spp1)."</a> <br>
                <a>SPP2: Rp ".rupiah($list->awal_bayar_spp2)."</a> <br>
                <a>SPP3: Rp ".rupiah($list->awal_bayar_spp3)."</a> <br>
                <a>SPP4: Rp ".rupiah($list->awal_bayar_spp4)."</a><br>
                <a>Modul: Rp ".rupiah($list->awal_bayar_modul)."</a> <br>
                <a>Infaq: Rp ".rupiah($list->awal_bayar_infaq)."</a> <br>
                <a>Lain: Rp ".rupiah($list->awal_bayar_lainnya)."</a> <br>
                <a>Ket: ".$list->keterangan_bayar ."</a> ";

                if($list->status_bayar_admin == 'SESUAI BAYAR'){
                    $row6 = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled>SESUAI BAYAR</button>"."<p>Ket Adm: <br> $list->keterangan_bayar_admin</p>";}
                elseif($list->status_bayar_admin == 'KURANG BAYAR'){
                    $row6 = "<button type=\"button\" class=\"btn btn-warning btn-sm\" disabled>KURANG BAYAR</button>"."<p>Ket Adm: <br> $list->keterangan_bayar_admin</p>";}
                elseif($list->status_bayar_admin == 'LEBIH BAYAR'){
                    $row6 = "<button type=\"button\" class=\"btn btn-secondary btn-sm\" disabled>LEBIH BAYAR</button>"."<p>Ket Adm: <br> $list->keterangan_bayar_admin</p>";}
                elseif($list->status_bayar_admin == 'BELUM BAYAR'){
                    $row6 = "<button type=\"button\" class=\"btn btn-danger btn-sm\" disabled>BELUM BAYAR</button>"."<p>Ket Adm: <br> $list->keterangan_bayar_admin</p>";}
                elseif($list->status_bayar_admin == 'BEBAS BIAYA'){
                    $row6 = "<button type=\"button\" class=\"btn btn-info btn-sm\" disabled>BEBAS BIAYA</button>"."<p>Ket Adm: <br> $list->keterangan_bayar_admin</p>";}
                elseif($list->status_bayar_admin == 'GAGAL BAYAR'){
                    $row6 = "<button type=\"button\" class=\"btn btn-danger btn-sm\" disabled>GAGAL BAYAR</button>"."<p>Ket Adm: <br> $list->keterangan_bayar_admin</p>";};

                if($list->status_konfirmasi == 'Proses'){
                    $row8a = "<button type=\"button\" class=\"btn btn-secondary btn-sm\" disabled>Proses</button>";}
                elseif($list->status_konfirmasi == 'Terkonfirmasi'){
                    $row8a = "<button type=\"button\" class=\"btn btn-success btn-sm\" disabled>Terkonfirmasi</button>"."<p>Validator: $list->validator</p> ";}
                elseif($list->status_konfirmasi == 'Tolak'){
                    $row8a = "<button type=\"button\" class=\"btn btn-danger btn-sm\" disabled>Tolak</button>"."<p>Validator: $list->validator</p>";}
                elseif($list->status_konfirmasi == 'Gagal'){
                    $row8a = "<button type=\"button\" class=\"btn btn-danger btn-sm\" disabled>Gagal</button>"."<p>Validator: $list->validator</p>";};

                if($list->tgl_bayar_konfirmasi == '1000-01-01' || $list->tgl_bayar_konfirmasi == NULL){
                    $row8b = "<p>-</p> ";}
                else{
                    $row8b = "<p>Tgl: ".shortdate_indo($list->tgl_bayar_konfirmasi)."</p><p>Jam: $list->waktu_bayar_konfirmasi</p>";};

                $row[] = $no.'('.$list->bayar_id .')';
				$row[] = $row2;
                $row[] = $row3;
				$row[] = $row4;
                $row[] = $row5;
                $row[] = $row6;
                $row[] = $row7;
                $row[] = $row8a."<br>".$row8b;
                $row[] = $btn_edit."<br>".$btn_hapus."<br>".$btn_bukti."<br>".$btn_bill;

                $data[] = $row;
            }
            $output = [
                "recordTotal"     => $this->bayar->count_all(),
                "recordsFiltered" => $this->bayar->count_filtered(),
                "data"            => $data,
            ];
            echo json_encode($output);
			
		}
        
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $bayar_id       = $this->request->getVar('bayar_id');
            $pembayaran     =  $this->bayar->find($bayar_id);
            $data = [
                'title'                 => 'Ubah Data Pembayaran',
                'bayar_id'              => $pembayaran['bayar_id'],
                'awal_bayar'            => $pembayaran['awal_bayar'],
                'awal_bayar_infaq'      => $pembayaran['awal_bayar_infaq'],
                'awal_bayar_daftar'     => $pembayaran['awal_bayar_daftar'],
                'awal_bayar_spp1'       => $pembayaran['awal_bayar_spp1'],
                'awal_bayar_spp2'       => $pembayaran['awal_bayar_spp2'],
                'awal_bayar_spp3'       => $pembayaran['awal_bayar_spp3'],
                'awal_bayar_spp4'       => $pembayaran['awal_bayar_spp4'],
                'keterangan_bayar'      => $pembayaran['keterangan_bayar'],
                'keterangan_bayar'      => $pembayaran['keterangan_bayar'],
                'status_bayar_admin'    => $pembayaran['status_bayar_admin'],
                'keterangan_bayar_admin'=> $pembayaran['keterangan_bayar_admin'],
            ];
            $msg = [
                'sukses' => view('panel_admin/pembayaran/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function edit_bukti()
    {
        if ($this->request->isAJAX()) {
            $bayar_id = $this->request->getVar('bayar_id');
            $data = [
                'title'     => 'Upload Bukti Transfer Baru',
                'bayar_id'  => $bayar_id
            ];
            $msg = [
                'sukses' => view('panel_admin/pembayaran/edit_bukti', $data)
            ];
            echo json_encode($msg);
        }
    }

    //Backend

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'awal_bayar' => [
                    'label' => 'awal_bayar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'awal_bayar_infaq' => [
                    'label' => 'awal_bayar_infaq',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'awal_bayar_daftar' => [
                    'label' => 'awal_bayar_daftar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'awal_bayar_spp1' => [
                    'label' => 'awal_bayar_spp1',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'awal_bayar_spp2' => [
                    'label' => 'awal_bayar_spp2',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'awal_bayar_spp3' => [
                    'label' => 'awal_bayar_spp3',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'awal_bayar_spp4' => [
                    'label' => 'awal_bayar_spp4',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_bayar_admin' => [
                    'label' => 'status_bayar_admin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'awal_bayar'        => $validation->getError('awal_bayar'),
                        'awal_bayar_infaq'  => $validation->getError('awal_bayar_infaq'),
                        'awal_bayar_daftar' => $validation->getError('awal_bayar_daftar'),
                        'awal_bayar_spp1'   => $validation->getError('awal_bayar_spp1'),
                        'awal_bayar_spp2'   => $validation->getError('awal_bayar_spp2'),
                        'awal_bayar_spp3'   => $validation->getError('awal_bayar_spp3'),
                        'awal_bayar_spp4'   => $validation->getError('awal_bayar_spp4'),
                        'status_bayar_admin'=> $validation->getError('status_bayar_admin'),
                    ]
                ];
            } else {

                //Get from form input view modal
                $get_awal_bayar         =  $this->request->getVar('awal_bayar');
                $get_awal_bayar_infaq   =  $this->request->getVar('awal_bayar_infaq');
                $get_awal_bayar_daftar  =  $this->request->getVar('awal_bayar_daftar');
                $get_awal_bayar_spp1    =  $this->request->getVar('awal_bayar_spp1');
                $get_awal_bayar_spp2    =  $this->request->getVar('awal_bayar_spp2');
                $get_awal_bayar_spp3    =  $this->request->getVar('awal_bayar_spp3');
                $get_awal_bayar_spp4    =  $this->request->getVar('awal_bayar_spp4');
                $status_bayar_admin     =  $this->request->getVar('status_bayar_admin');
                $keterangan_bayar_admin =  $this->request->getVar('keterangan_bayar_admin');

                //Replace Rp. and thousand separtor from input
                $awal_bayar_int           = str_replace(str_split('Rp. .'), '', $get_awal_bayar);
                $awal_bayar_daftar_int    = str_replace(str_split('Rp. .'), '', $get_awal_bayar_daftar);
                $awal_bayar_spp1_int      = str_replace(str_split('Rp. .'), '', $get_awal_bayar_spp1);
                $awal_bayar_infaq_int     = str_replace(str_split('Rp. .'), '', $get_awal_bayar_infaq);
                $awal_bayar_spp2_int      = str_replace(str_split('Rp. .'), '', $get_awal_bayar_spp2);
                $awal_bayar_spp3_int      = str_replace(str_split('Rp. .'), '', $get_awal_bayar_spp3);
                $awal_bayar_spp4_int      = str_replace(str_split('Rp. .'), '', $get_awal_bayar_spp4);

                //Get Data from Input view
                $keterangan_bayar       =  $this->request->getVar('keterangan_bayar');
                $awal_bayar              = $awal_bayar_int;
                $awal_bayar_daftar       = $awal_bayar_daftar_int;
                $awal_bayar_spp1         = $awal_bayar_spp1_int;
                $awal_bayar_infaq        = $awal_bayar_infaq_int;
                $awal_bayar_spp2         = $awal_bayar_spp2_int;
                $awal_bayar_spp3         = $awal_bayar_spp3_int;
                $awal_bayar_spp4         = $awal_bayar_spp4_int;

                $update_data = [
                    'awal_bayar'            => $awal_bayar ,
                    'awal_bayar_infaq'      => $awal_bayar_infaq ,
                    'awal_bayar_daftar'     => $awal_bayar_daftar,
                    'awal_bayar_spp1'       => $awal_bayar_spp1,
                    'awal_bayar_spp2'       => $awal_bayar_spp2,
                    'awal_bayar_spp3'       => $awal_bayar_spp3,
                    'awal_bayar_spp4'       => $awal_bayar_spp4,
                    'keterangan_bayar'      => $keterangan_bayar,
                    'status_bayar_admin'    => $status_bayar_admin,
                    'nominal_bayar'         => $awal_bayar,
                    'keterangan_bayar_admin'=> $keterangan_bayar_admin,
                ];

                $bayar_id = $this->request->getVar('bayar_id');
                $this->bayar->update($bayar_id, $update_data);

                $bayar_data         = $this->bayar->find($bayar_id);
                $bayar_peserta_id   = $bayar_data['bayar_peserta_id'];
                $bayar_kelas_id     = $bayar_data['kelas_id'];
                $peserta_data       = $this->peserta->find($bayar_peserta_id);
                $peserta_nama       = $peserta_data['nama_peserta'];
                $peserta_nis        = $peserta_data['nis'];
                $kelas_data         = $this->kelas->find($bayar_kelas_id);
                $kelas_nama         = $kelas_data['nama_kelas'];

                $aktivitas = 'Edit Data Pembayaran ID : ' .  $this->request->getVar('bayar_id') . ' : ' . $peserta_nis . ' - ' . $peserta_nama . ' pada kelas ' . $kelas_nama;

                /*--- Log ---*/
				$this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'pembayaran'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update_bukti()
    {
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'foto' => [
                'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                'errors' => [
                    'mime_in' => 'Harus gambar!'
                ]
            ]
        ]);

        if (!$valid) {
            $this->session->setFlashdata('pesan_error', 'ERROR! Upload Bukti Bayar!');
            return redirect()->to('/pembayaran');
        } else {

            $bayar_id           = $this->request->getVar('bayar_id');
            $databayar          = $this->bayar->find($bayar_id);
            $bukti_bayar_lama   = $databayar['bukti_bayar'];
            $bayar_peserta_id   = $databayar['bayar_peserta_id'];
            $datapeserta        = $this->peserta->find($bayar_peserta_id);
            $nama_peserta       = $datapeserta['nama_peserta'];
            $nis_peserta        = $datapeserta['nis'];

            // get file foto from input
            $filefoto = $this->request->getFile('foto');
            // ambil nama file
            // $namafoto = $filefoto->getName();
            // nama foto baru
            $ext = $filefoto->guessExtension();
            $namafoto_new = $databayar['bayar_peserta_id'].'-'.date('Ymd-His').'.'.$ext;

            $data_bayar = [
                'bukti_bayar'  => $namafoto_new,
            ];
            
            // insert status konfirmasi
            $this->db->transStart();
            $this->bayar->update($bayar_id, $data_bayar);
            $filefoto->move('public/img/transfer/', $namafoto_new);
            unlink('public/img/transfer/' . $bukti_bayar_lama);
            $this->db->transComplete();

            $aktivitas = 'Ubah Bukti Transfer, ID Pembayaran : ' . $bayar_id . ' Atas Nama ' .  $nis_peserta .  ' - '. $nama_peserta;

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
            
            $this->session->setFlashdata('pesan_sukses', 'Bukti Pembayaran Berhasil Diubah!');
            return redirect()->to('/pembayaran');
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $bayar_id           = $this->request->getVar('bayar_id');
            $bayar_data         = $this->bayar->find($bayar_id);
            $bayar_peserta_id   = $bayar_data['bayar_peserta_id'];
            $bayar_kelas_id     = $bayar_data['kelas_id'];
            $peserta_data       = $this->peserta->find($bayar_peserta_id);
            $peserta_nama       = $peserta_data['nama_peserta'];
            $peserta_nis        = $peserta_data['nis'];
            $kelas_data         = $this->kelas->find($bayar_kelas_id);
            $kelas_nama         = $kelas_data['nama_kelas'];

            $aktivitas = 'Hapus Data Pembayaran ID : ' .  $this->request->getVar('bayar_id') . ' : ' . $peserta_nis . ' - ' . $peserta_nama . ' pada kelas ' . $kelas_nama;

            $this->bayar->delete($bayar_id);

            /*--- Log ---*/
			$this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => 'pembayaran'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function export()
    {
        $angkatan           = $this->request->getVar('angkatan_filter'); 
        $payment_filter     = $this->request->getVar('payment_filter'); 
        $bayar              = $this->bayar->get_datatables($angkatan, $payment_filter);
        $total_row          = count($bayar) + 5;

        if ($payment_filter == 'all') {
            $payment = "Semua";
        }elseif ($payment_filter == 'tf') {
            $payment = "Tranfer Manual";
        }elseif ($payment_filter == 'flip') {
            $payment = "Payment Gateway Flip";
        }elseif ($payment_filter == 'beasiswa') {
            $payment = "Beasiswa";
        }

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

        $judul = "DATA TRANSAKSI PEMBAYARAN ALHAQQ - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = "ANGKATAN: ".$angkatan." METODE BAYAR: ". $payment . " DIUNDUH PADA " .date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:AC1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:AC2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:AC4')->applyFromArray($style_up);

        $sheet->getStyle('A5:AC'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'TRANSAKSI ID')
            ->setCellValue('B4', 'NIS')
            ->setCellValue('C4', 'NAMA PESERTA')
            ->setCellValue('D4', 'KELAS')
            ->setCellValue('E4', 'PROGRAM')
            ->setCellValue('F4', 'LEVEL')
            ->setCellValue('G4', 'JENKEL')
            ->setCellValue('H4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('I4', 'WAKTU KELAS')
            ->setCellValue('J4', 'PENGAJAR')
            ->setCellValue('K4', 'STATUS BAYAR')
            ->setCellValue('L4', 'STATUS KONFIRMASI')
            ->setCellValue('M4', 'METODE PEMBAYARAN')
            ->setCellValue('N4', 'TGL UPLOAD')
            ->setCellValue('O4', 'WAKTU UPLOAD')
            ->setCellValue('P4', 'KET. PESERTA')
            ->setCellValue('Q4', 'ADMIN VERIFIKATOR')
            ->setCellValue('R4', 'TGL VERIFIKASI')
            ->setCellValue('S4', 'WAKTU VERIFIKASI')
            ->setCellValue('T4', 'KET. ADMIN')
            ->setCellValue('U4', 'TOTAL TF')
            ->setCellValue('V4', 'PENDAFTARAN')
            ->setCellValue('W4', 'SPP-1')
            ->setCellValue('X4', 'SPP-2')
            ->setCellValue('Y4', 'SPP-3')
            ->setCellValue('Z4', 'SPP-4')
            ->setCellValue('AA4', 'MODUL')
            ->setCellValue('AB4', 'INFAQ')
            ->setCellValue('AC4', 'BAYAR LAINNYA');

        $columns = range('A', 'Z');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
        $spreadsheet->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
        $row = 5;

        foreach ($bayar as $data) {

            if ($data->metode == NULL) {
                $metode = 'Transfer Manual';
                $bill = "";
            } elseif ($data->metode == 'flip') {
                $bill = $this->bill->find($data->flip_bill_id);
                $metode = 'Flip';
                $bill = " (".$bill['bill_bank'].'-'.$bill['bill_va'].")";
            } elseif ($data->metode == 'beasiswa') {
                $metode = 'Beasiswa';
                $bill = "";
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data->bayar_id)
                ->setCellValue('B' . $row, $data->nis)
                ->setCellValue('C' . $row, $data->nama_peserta)
                ->setCellValue('D' . $row, $data->nama_kelas)
                ->setCellValue('E' . $row, $data->nama_program)
                ->setCellValue('F' . $row, $data->nama_level)
                ->setCellValue('G' . $row, $data->jenkel)
                ->setCellValue('H' . $row, $data->angkatan_kelas)
                ->setCellValue('I' . $row, $data->hari_kelas . ', ' . $data->waktu_kelas . ' ' . $data->zona_waktu_kelas)
                ->setCellValue('J' . $row, $data->nama_pengajar)
                ->setCellValue('K' . $row, $data->status_bayar_admin)
                ->setCellValue('L' . $row, $data->status_konfirmasi)
                ->setCellValue('M' . $row, $metode)
                ->setCellValue('N' . $row, $data->tgl_bayar)
                ->setCellValue('O' . $row, $data->waktu_bayar)
                ->setCellValue('P' . $row, $data->keterangan_bayar)
                ->setCellValue('Q' . $row, $data->validator)
                ->setCellValue('R' . $row, $data->tgl_bayar_konfirmasi)
                ->setCellValue('S' . $row, $data->waktu_bayar_konfirmasi)
                ->setCellValue('T' . $row, $data->keterangan_bayar_admin)
                ->setCellValue('U' . $row, $data->awal_bayar)
                ->setCellValue('V' . $row, $data->awal_bayar_daftar)
                ->setCellValue('W' . $row, $data->awal_bayar_spp1)
                ->setCellValue('X' . $row, $data->awal_bayar_spp2)
                ->setCellValue('Y' . $row, $data->awal_bayar_spp3)
                ->setCellValue('Z' . $row, $data->awal_bayar_spp4)
                ->setCellValue('AA' . $row, $data->awal_bayar_modul)
                ->setCellValue('AB' . $row, $data->awal_bayar_infaq)
                ->setCellValue('AC' . $row, $data->awal_bayar_lainnya);
            

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Pembayaran-Angkatan'.$angkatan.'-Metode_'.$payment.'-'. date('Y-m-d-His');

        $aktivitas =  'Download Data Pembayaran via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    /*--- KONFIRMASI BAYAR ---*/
    //frontend
    public function index_konfirmasi()
	{
		$user           = $this->userauth(); // Return Array
        $program_bayar  = $this->bayar->bayar_konfirmasi();
        $data = [
            'title'    => 'Konfirmasi Pembayaran',
            'list'     => $program_bayar,
            'user'     => $user,
        ];
        return view('panel_admin/pembayaran/konfirmasi/index', $data);
	}

    public function input_konfirmasi()
    {
        if ($this->request->isAJAX()) {
            $bayar_id = $this->request->getVar('bayar_id');
            $pembayaran =  $this->bayar->find($bayar_id);

            //Get data Kelas id from tabel program bayar
            $get_kelas_id = $this->bayar->get_kelas_id($bayar_id);
            $kelas_id = $get_kelas_id->kelas_id;

            $data = [
                'title'               => 'Konfirmasi & Input Nominal Bayar',
                'bayar_id'            => $bayar_id,
                'kelas_id'            => $kelas_id,
                'bayar_peserta_id'    => $pembayaran['bayar_peserta_id'],
                'bukti_bayar'         => $pembayaran['bukti_bayar'],
                'awal_bayar'          => $pembayaran['awal_bayar'],
                'awal_bayar_daftar'   => $pembayaran['awal_bayar_daftar'],
                'awal_bayar_infaq'    => $pembayaran['awal_bayar_infaq'],
                'awal_bayar_spp1'     => $pembayaran['awal_bayar_spp1'],
                'awal_bayar_spp2'     => $pembayaran['awal_bayar_spp2'],
                'awal_bayar_spp3'     => $pembayaran['awal_bayar_spp3'],
                'awal_bayar_spp4'     => $pembayaran['awal_bayar_spp4'],
                'awal_bayar_modul'    => $pembayaran['awal_bayar_modul'],
                'awal_bayar_lainnya'  => $pembayaran['awal_bayar_lainnya'],
                'keterangan_bayar'    => $pembayaran['keterangan_bayar'],
            ];
            $msg = [
                'sukses' => view('panel_admin/pembayaran/konfirmasi/input', $data)
            ];
            echo json_encode($msg);
        }
    }

    //backend
    public function save_konfirmasi()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nominal_bayar' => [
                    'label' => 'nominal_bayar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_daftar' => [
                    'label' => 'bayar_daftar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_spp1' => [
                    'label' => 'bayar_spp1',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_spp2' => [
                    'label' => 'bayar_spp2',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_spp3' => [
                    'label' => 'bayar_spp3',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_spp4' => [
                    'label' => 'bayar_spp4',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_infaq' => [
                    'label' => 'bayar_infaq',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_modul' => [
                    'label' => 'bayar_modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'bayar_lain' => [
                    'label' => 'bayar_lain',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_bayar_admin' => [
                    'label' => 'status_bayar_admin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nominal_bayar'         => $validation->getError('nominal_bayar'),
                        'bayar_daftar'          => $validation->getError('bayar_daftar'),
                        'bayar_spp1'            => $validation->getError('bayar_spp1'),
                        'bayar_spp2'            => $validation->getError('bayar_spp2'),
                        'bayar_spp3'            => $validation->getError('bayar_spp3'),
                        'bayar_spp4'            => $validation->getError('bayar_spp4'),
                        'bayar_infaq'           => $validation->getError('bayar_infaq'),
                        'bayar_modul'           => $validation->getError('bayar_modul'),
                        'bayar_lain'            => $validation->getError('bayar_lain'),
                        'status_bayar_admin'    => $validation->getError('status_bayar_admin'),
                    ]
                ];
            } else {

                $user       = $this->userauth();
                $validator  = $user['username'];

                $bayar_id   = $this->request->getVar('bayar_id');
                $kelas_id   = $this->request->getVar('kelas_id');
                $peserta_id = $this->request->getVar('peserta_id');

                //Get peserta_kelas_id
                //$get_peserta_kelas_id   = $this->peserta_kelas->get_peserta_kelas_id($peserta_id, $kelas_id);
                $program_bayar_data     = $this->bayar->find($bayar_id); 
                $peserta_kelas_id       = $program_bayar_data['bayar_peserta_kelas_id'];

                //Data Peserta
                $data_peserta       = $this->peserta->find($peserta_id);
                $log_nama_peserta   = $data_peserta['nama_peserta'];
                $log_nis_peserta    = $data_peserta['nis'];

                //Get var
                $status_bayar_admin = $this->request->getVar('status_bayar_admin');
                $keterangan_admin   = strtoupper($this->request->getVar('keterangan_bayar_admin'));

                //Get nominal (on rupiah curenncy format) input from view
                $get_nominal_bayar = $this->request->getVar('nominal_bayar');
                $get_bayar_daftar  = $this->request->getVar('bayar_daftar');
                $get_bayar_spp1    = $this->request->getVar('bayar_spp1');
                $get_bayar_spp2    = $this->request->getVar('bayar_spp2');
                $get_bayar_spp3    = $this->request->getVar('bayar_spp3');
                $get_bayar_spp4    = $this->request->getVar('bayar_spp4');
                $get_bayar_infaq   = $this->request->getVar('bayar_infaq');
                $get_bayar_modul   = $this->request->getVar('bayar_modul');
                $get_bayar_lain    = $this->request->getVar('bayar_lain');

                //Get Data from Input view
                $nominal_bayar      = str_replace(str_split('Rp. .'), '', $get_nominal_bayar);
                $bayar_daftar       = str_replace(str_split('Rp. .'), '', $get_bayar_daftar);
                $bayar_spp1         = str_replace(str_split('Rp. .'), '', $get_bayar_spp1);
                $bayar_spp2         = str_replace(str_split('Rp. .'), '', $get_bayar_spp2);
                $bayar_spp3         = str_replace(str_split('Rp. .'), '', $get_bayar_spp3);
                $bayar_spp4         = str_replace(str_split('Rp. .'), '', $get_bayar_spp4);
                $bayar_infaq        = str_replace(str_split('Rp. .'), '', $get_bayar_infaq);
                $bayar_modul        = str_replace(str_split('Rp. .'), '', $get_bayar_modul);
                $bayar_lain         = str_replace(str_split('Rp. .'), '', $get_bayar_lain);

                $databayar = [
                    'status_bayar'              => 'Lunas',
                    'status_konfirmasi'         => 'Terkonfirmasi',
                    'status_bayar_admin'        => $status_bayar_admin,
                    'keterangan_bayar_admin'    => $keterangan_admin,
                    'awal_bayar'                => $nominal_bayar,
                    'awal_bayar_daftar'         => $bayar_daftar,
                    'awal_bayar_spp1'           => $bayar_spp1,
                    'awal_bayar_spp2'           => $bayar_spp2,
                    'awal_bayar_spp3'           => $bayar_spp3,
                    'awal_bayar_spp4'           => $bayar_spp4,
                    'awal_bayar_modul'          => $bayar_modul,
                    'awal_bayar_infaq'          => $bayar_infaq,
                    'awal_bayar_lainnya'        => $bayar_lain,
                    'nominal_bayar'             => $nominal_bayar,
                    'tgl_bayar_konfirmasi'      => date('Y-m-d'),
                    'waktu_bayar_konfirmasi'    => date('H:i:s'),
                    'validator'                 => $validator,
                ];

                $this->db->transStart();
                $this->bayar->update($bayar_id, $databayar);

                if ($bayar_daftar != '0') {
                    $dataabsen = [
                        'bckp_absen_peserta_id'     => $peserta_id,
                        'bckp_absen_peserta_kelas'  => $kelas_id,
                    ];
                    $this->absen_peserta->insert($dataabsen);
                    $absenID = $this->absen_peserta->insertID();
        
                    $dataujian = [
                        'bckp_ujian_peserta'     => $peserta_id,
                        'bckp_ujian_kelas'       => $kelas_id,
                    ];
                    $this->ujian->insert($dataujian);
                    $ujianID = $this->ujian->insertID();
                    $PKdaftar = [
                        'byr_daftar'            => $bayar_daftar,
                        'dt_konfirmasi_daftar'  => date('Y-m-d H:i:s'),
                        'data_absen'            => $absenID,
                        'data_ujian'            => $ujianID,
                        'expired_tgl_daftar'    => NULL,
                        'expired_waktu_daftar'  => NULL,
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKdaftar);

                    $ucvData = [
                        'ucv_ujian_id'      => $ujianID,
                        'ucv_peserta_id'    => $peserta_id,
                        'ucv_kelas_id'      => $kelas_id,
                    ];
                    $this->ujian_custom_value->insert($ucvData);
                }

                if ($bayar_spp1 != '0') {
                    $PKspp1 = [
                        'byr_spp1'            => $bayar_spp1,
                        'dt_konfirmasi_spp1'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp1);
                }
    
                if ($bayar_spp2 != '0') {
                    $PKspp2 = [
                        'byr_spp2'            => $bayar_spp2,
                        'dt_konfirmasi_spp2'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp2);
                }
    
                if ($bayar_spp3 != '0') {
                    $PKspp3 = [
                        'byr_spp3'            => $bayar_spp3,
                        'dt_konfirmasi_spp3'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp3);
                }
    
                if ($bayar_spp4 != '0') {
                    $PKspp4 = [
                        'byr_spp4'            => $bayar_spp4,
                        'dt_konfirmasi_spp4'  => date('Y-m-d H:i:s')
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKspp4);
                }

                if ($bayar_modul != '0') {
                    $PKmodul = [
                        'byr_modul'            => $bayar_modul,
                    ];
                    $this->peserta_kelas->update($peserta_kelas_id, $PKmodul);
                    $data_modul = [
                        'bayar_modul_id'        => $bayar_id,
                        'bayar_modul'           => $bayar_modul,
                        'status_bayar_modul'    => 'Lunas',
                    ];
                    $this->bayar_modul->insert($data_modul);
                }
    
                if ($bayar_lain != '0') {
                    $data_lain = [
                        'lainnya_bayar_id'        => $bayar_id,
                        'bayar_lainnya'           => $bayar_lain,
                        'data_peserta_id_lain'    => $peserta_id,
                        'status_bayar_lainnya'    => 'Lunas',
                    ];
                    $this->bayar_lain->insert($data_lain);
                }
    
                if ($bayar_infaq != '0') {
                    $data_infaq = [
                        'infaq_bayar_id'        => $bayar_id,
                        'bayar_infaq'           => $bayar_infaq,
                        'data_peserta_id_infaq' => $peserta_id
                    ];
                    $this->infaq->insert($data_infaq);
                }

                //Get data total bayar
                $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
                $byr_daftar         = $peserta_kelas['byr_daftar'];
                $byr_modul          = $peserta_kelas['byr_modul'];
                $byr_spp1           = $peserta_kelas['byr_spp1'];
                $byr_spp2           = $peserta_kelas['byr_spp2'];
                $byr_spp3           = $peserta_kelas['byr_spp3'];
                $byr_spp4           = $peserta_kelas['byr_spp4'];

                $beasiswa_daftar    = $peserta_kelas['beasiswa_daftar'];
                $beasiswa_spp1      = $peserta_kelas['beasiswa_spp1'];
                $beasiswa_spp2      = $peserta_kelas['beasiswa_spp2'];
                $beasiswa_spp3      = $peserta_kelas['beasiswa_spp3'];
                $beasiswa_spp4      = $peserta_kelas['beasiswa_spp4'];
    
                $payments = [
                    [$byr_daftar, $beasiswa_daftar],
                    [$byr_spp1, $beasiswa_spp1],
                    [$byr_spp2, $beasiswa_spp2],
                    [$byr_spp3, $beasiswa_spp3],
                    [$byr_spp4, $beasiswa_spp4]
                ];
                
                $spp_status = 'LUNAS';
                
                foreach ($payments as $payment) {
                    if (($payment[0] == '0' && $payment[1] != 1) || ($payment[0] == NULL && $payment[1] != 1)) {
                        $spp_status = 'BELUM LUNAS';
                        break;
                    }
                }

                $PKstatus = [
                    'spp_status'  => $spp_status,
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKstatus);
                

                $aktivitas = 'Konfirmasi Transaksi ID ' . $bayar_id . ' - ' . $log_nis_peserta . ' ' . $log_nama_peserta;

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
                        'link' => '/pembayaran/konfirmasi'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    /*--- TAMBAH BAYAR ---*/
    //frontend
    public function add_daftar()
    {
        $user         = $this->userauth();
        $get_angkatan = $this->konfigurasi->angkatan_kuliah();
        $angkatan     = $get_angkatan->angkatan_kuliah;

        $peserta       = $this->peserta->list();
        $kelas         = $this->kelas->list_2nd($angkatan);

        $data = [
            'title'         => 'Tambah Pembayaran Pendaftaran Program Peserta',
            'user'          => $user,
            'peserta'       => $peserta,
            'kelas'         => $kelas,
        ];
        return view('panel_admin/pembayaran/tambah/daftar', $data);
    }

    public function add_spp()
    {
        $user           = $this->userauth(); // Return Array
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
        
        $peserta_kelas      = $this->peserta_kelas->list_kelas_peserta($angkatan);
        $list_angkatan      = $this->kelas->list_unik_angkatan();

        $data = [
            'title'         => 'Tambah Pembayaran SPP Peserta',
            'user'          => $user,
            'list_angkatan' => $list_angkatan,
            'peserta_kelas' => $peserta_kelas,
            'angkatan_pilih'=> $angkatan,
        ];
        return view('panel_admin/pembayaran/tambah/spp', $data);
    }

    public function add_lain()
    {
        $user       = $this->userauth();
        $peserta    = $this->peserta->list();

        $data = [
            'title'         => 'Tambah Pembayaran Infaq & Lainnya Peserta',
            'user'          => $user,
            'peserta'       => $peserta,
        ];
        return view('panel_admin/pembayaran/tambah/lain', $data);
    }

    //backend
    public function save_daftar()
    {
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'peserta' => [
                'label' => 'peserta',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'kelas' => [
                'label' => 'kelas',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'awal_bayar' => [
                'label' => 'awal_bayar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'daftar' => [
                'label' => 'daftar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'spp1' => [
                'label' => 'spp1',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'spp2' => [
                'label' => 'spp2',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'spp3' => [
                'label' => 'spp3',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'spp4' => [
                'label' => 'spp4',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'infaq' => [
                'label' => 'infaq',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'modul' => [
                'label' => 'modul',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'lain' => [
                'label' => 'lain',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'status_bayar_admin' => [
                'label' => 'status_bayar_admin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                'errors' => [
                    'mime_in' => 'Harus gambar!'
                ]
            ]
        ]);

        if (!$valid) {
            $this->session->setFlashdata('pesan_eror', 'ERROR! Seluruh Form Input Bertanda * Wajib Diisi dan Harap Upload Bukti Bayar!');
            return redirect()->to('/pembayaran/add-daftar');
        } else {

            $user       = $this->userauth();
            $validator  = $user['username'];

            //Get inputan peserta, kelas, status bayar dan keterangan admin
            $peserta_id         = $this->request->getVar('peserta');
            $kelas_id           = $this->request->getVar('kelas');
            $status_bayar_admin = $this->request->getVar('status_bayar_admin');
            $keterangan_admin   = strtoupper($this->request->getVar('keterangan_admin'));
            $peserta            = $this->peserta->find($peserta_id);
            $kelas              = $this->kelas->find($kelas_id);
            $program_id         = $kelas['program_id'];
            $program            = $this->program->find($program_id);
            $biaya_daftar       = $program['biaya_daftar'];
            $biaya_bulanan      = $program['biaya_bulanan'];
            $biaya_modul        = $program['biaya_modul'];

            // get file foto from input
            $filefoto = $this->request->getFile('foto');
            // ambil nama file
            //$namafoto = $filefoto->getName();
            // nama foto baru
            $ext = $filefoto->guessExtension();
            $namafoto_new = $peserta_id.'-'.date('Ymd-His').'.'.$ext;
            
            //Get nominal (on rupiah curenncy format) input from view
            $get_awal_bayar    = $this->request->getVar('awal_bayar');
            $get_bayar_daftar  = $this->request->getVar('daftar');
            $get_bayar_spp1    = $this->request->getVar('spp1');
            $get_bayar_spp2    = $this->request->getVar('spp2');
            $get_bayar_spp3    = $this->request->getVar('spp3');
            $get_bayar_spp4    = $this->request->getVar('spp4');
            $get_bayar_infaq   = $this->request->getVar('infaq');
            $get_bayar_modul   = $this->request->getVar('modul');
            $get_bayar_lain    = $this->request->getVar('lain');

            //Get Data from Input view
            $nominal_bayar      = str_replace(str_split('Rp. .'), '', $get_awal_bayar);
            // $bayar_daftar       = str_replace(str_split('Rp. .'), '', $get_bayar_daftar);
            // $bayar_spp1         = str_replace(str_split('Rp. .'), '', $get_bayar_spp1);
            // $bayar_spp2         = str_replace(str_split('Rp. .'), '', $get_bayar_spp2);
            // $bayar_spp3         = str_replace(str_split('Rp. .'), '', $get_bayar_spp3);
            // $bayar_spp4         = str_replace(str_split('Rp. .'), '', $get_bayar_spp4);
            // $bayar_modul        = str_replace(str_split('Rp. .'), '', $get_bayar_modul);
            $bayar_infaq        = str_replace(str_split('Rp. .'), '', $get_bayar_infaq);
            $bayar_lain         = str_replace(str_split('Rp. .'), '', $get_bayar_lain);

            


            $data_bayar = [
                'kelas_id'                  => $kelas_id,
                'bayar_peserta_id'          => $peserta_id,
                'status_bayar'              => 'Lunas',
                'status_bayar_admin'        => $status_bayar_admin,
                'status_konfirmasi'         => 'Terkonfirmasi',
                'awal_bayar'                => $nominal_bayar,
                'awal_bayar_infaq'          => $bayar_infaq,
                'awal_bayar_lainnya'        => $bayar_lain,
                // 'awal_bayar_daftar'         => $bayar_daftar,
                // 'awal_bayar_spp1'           => $bayar_spp1,
                // 'awal_bayar_spp2'           => $bayar_spp2,
                // 'awal_bayar_spp3'           => $bayar_spp3,
                // 'awal_bayar_spp4'           => $bayar_spp4,
                // 'awal_bayar_modul'          => $bayar_modul,
                'bukti_bayar'               => $namafoto_new,
                'tgl_bayar'                 => date('Y-m-d'),
                'waktu_bayar'               => date('H:i:s'),
                'keterangan_bayar_admin'    => $keterangan_admin,
                'tgl_bayar_konfirmasi'      => date('Y-m-d'),
                'waktu_bayar_konfirmasi'    => date('H:i:s'),
                'nominal_bayar'             => $nominal_bayar,
                'validator'                 => $validator,
            ];

            $this->db->transStart();
            $this->bayar->insert($data_bayar);
            $filefoto->move('public/img/transfer/', $namafoto_new);
            $bayar_id = $this->bayar->insertID();

            $dataabsen = [
                'bckp_absen_peserta_id'     => $peserta_id,
                'bckp_absen_peserta_kelas'  => $kelas_id,
            ];
            $this->absen_peserta->insert($dataabsen);
            $absenID = $this->absen_peserta->insertID();

            $dataujian = [
                'bckp_ujian_peserta'     => $peserta_id,
                'bckp_ujian_kelas'       => $kelas_id,
            ];
            $this->ujian->insert($dataujian);

            $ujianID = $this->ujian->insertID();

            $ucvData = [
                'ucv_ujian_id'      => $ujianID,
                'ucv_peserta_id'    => $peserta_id,
                'ucv_kelas_id'      => $kelas_id,
            ];
            $this->ujian_custom_value->insert($ucvData);

            $datapesertakelas = [
                'data_peserta_id'       => $peserta_id,
                'data_kelas_id'         => $kelas_id,
                'data_absen'            => $absenID,
                'data_ujian'            => $ujianID,
                'status_peserta_kelas'  => 'BELUM LULUS',
                // 'byr_daftar'            => $bayar_daftar,
                'dt_bayar_daftar'       => date("Y-m-d H:i:s"),
                'dt_konfirmasi_daftar'  => date("Y-m-d H:i:s"),
            ];
            $this->peserta_kelas->insert($datapesertakelas);
            $peserta_kelas_id = $this->peserta_kelas->insertID();

            $payments = ['daftar', 'spp1', 'spp2', 'spp3', 'spp4'];
            foreach($payments as $payment) {
                $get_bayar = 'get_bayar_' . $payment;
                $beasiswa = 'beasiswa_' . $payment;
                $byr = 'byr_' . $payment;

                if ($$get_bayar == 2) {
                    $dtupdate = [$beasiswa => 1];
                    $this->peserta_kelas->update($peserta_kelas_id, $dtupdate);
                }

                if ($$get_bayar == 1) {
                    $dtupdate = [$byr => ($payment == 'daftar') ? $biaya_daftar : $biaya_bulanan];
                    $this->peserta_kelas->update($peserta_kelas_id, $dtupdate);
                }
            }

            ///
            $payments = ['daftar', 'spp1', 'spp2', 'spp3', 'spp4'];

            foreach($payments as $payment) {
                $get_bayar = 'get_bayar_' . $payment;
                $beasiswa = 'beasiswa_' . $payment;
                $awal_bayar = 'awal_bayar_' . $payment;
                $byr = 'byr_' . $payment;

                if ($$get_bayar == 2) {
                    $dtupdate = [$beasiswa => 1];
                    $this->peserta_kelas->update($peserta_kelas_id, $dtupdate);
                    $dtupdate2 = [$awal_bayar => 0];
                    $this->bayar->update($bayar_id, $dtupdate2);
                }

                if ($$get_bayar == 1) {
                    $biaya = ($payment == 'daftar') ? $biaya_daftar : $biaya_bulanan;
                    $dtupdate = [$byr => $biaya];
                    $this->peserta_kelas->update($peserta_kelas_id, $dtupdate);
                    $dtupdate2 = [$awal_bayar => $biaya];
                    $this->bayar->update($bayar_id, $dtupdate2);
                }
            }
            ///

            $PKbayar= [
                'bayar_peserta_kelas_id' => $peserta_kelas_id,
            ];
            $this->bayar->update($bayar_id, $PKbayar);

            if ($get_bayar_modul == 1) {
                $PKmodul = [
                    'byr_modul'            => $biaya_modul,
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKmodul);
                $data_modul = [
                    'bayar_modul_id'        => $bayar_id,
                    'bayar_modul'           => $biaya_modul,
                    'status_bayar_modul'    => 'Lunas',
                ];
                $this->bayar_modul->insert($data_modul);
                $PKmodul2 = [
                    'awal_bayar_modul'            => $biaya_modul,
                ];
                $this->bayar->update($bayar_id, $PKmodul2);
            }

            if ($bayar_lain != '0') {
                $data_lain = [
                    'lainnya_bayar_id'        => $bayar_id,
                    'bayar_lainnya'           => $bayar_lain,
                    'data_peserta_id_lain'    => $peserta_id,
                    'status_bayar_lainnya'    => 'Lunas',
                ];
                $this->bayar_lain->insert($data_lain);
            }

            if ($bayar_infaq != '0') {
                $data_infaq = [
                    'infaq_bayar_id'        => $bayar_id,
                    'bayar_infaq'           => $bayar_infaq,
                    'data_peserta_id_infaq' => $peserta_id
                ];
                $this->infaq->insert($data_infaq);
            }

            //Get data total bayar
            $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
            $byr_daftar         = $peserta_kelas['byr_daftar'];
            $byr_modul          = $peserta_kelas['byr_modul'];
            $byr_spp1           = $peserta_kelas['byr_spp1'];
            $byr_spp2           = $peserta_kelas['byr_spp2'];
            $byr_spp3           = $peserta_kelas['byr_spp3'];
            $byr_spp4           = $peserta_kelas['byr_spp4'];

            $beasiswa_daftar    = $peserta_kelas['beasiswa_daftar'];
            $beasiswa_spp1      = $peserta_kelas['beasiswa_spp1'];
            $beasiswa_spp2      = $peserta_kelas['beasiswa_spp2'];
            $beasiswa_spp3      = $peserta_kelas['beasiswa_spp3'];
            $beasiswa_spp4      = $peserta_kelas['beasiswa_spp4'];

            $payments = [
                [$byr_daftar, $beasiswa_daftar],
                [$byr_spp1, $beasiswa_spp1],
                [$byr_spp2, $beasiswa_spp2],
                [$byr_spp3, $beasiswa_spp3],
                [$byr_spp4, $beasiswa_spp4]
            ];
            
            $spp_status = 'LUNAS';
            
            foreach ($payments as $payment) {
                if (($payment[0] == '0' && $payment[1] != 1) || ($payment[0] == NULL && $payment[1] != 1)) {
                    $spp_status = 'BELUM LUNAS';
                    break;
                }
            }

            $PKstatus = [
                'spp_status'  => $spp_status,
            ];
            $this->peserta_kelas->update($peserta_kelas_id, $PKstatus);
            
            $aktivitas = 'Buat Data Pembayaran Pendaftaran Atas Nama Peserta : ' . $peserta['nis'] . ' - ' . $peserta['nama_peserta'] . ' Pada Kelas ' . $kelas['nama_kelas'];

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

            $this->session->setFlashdata('pesan_sukses', 'Pembuatan Pembayaran dan Pendaftaran Peserta oleh Admin Berhasil. Peserta Sudah Masuk di Kelas yang Dipilih.');
            return redirect()->to('/pembayaran/add-daftar');
        }
    }

    public function save_spp()
    {
        $validation = \Config\Services::validation();

        //Get Tgl Today
        $tgl = date("Y-m-d");
        $waktu = date("H:i:s");
        $strwaktu = date("H-i-s");

        $valid = $this->validate([
            'peserta_kelas_id' => [
                'label' => 'peserta_kelas_id',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'awal_bayar' => [
                'label' => 'awal_bayar',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'spp2' => [
                'label' => 'spp2',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'spp3' => [
                'label' => 'spp3',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'spp4' => [
                'label' => 'spp4',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'infaq' => [
                'label' => 'infaq',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'lain' => [
                'label' => 'lain',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'status_bayar_admin' => [
                'label' => 'status_bayar_admin',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                'errors' => [
                    'mime_in' => 'Harus gambar!'
                ]
            ]
        ]);

        if (!$valid) {
            $this->session->setFlashdata('pesan_eror', 'ERROR! Seluruh Form Input Bertanda * Wajib Diisi dan Harap Upload Bukti Bayar!');
            return redirect()->to('/pembayaran/add-spp');
        } else {

            $user               = $this->userauth();
            $validator          = $user['username'];

            //Get inputan peserta, kelas, status bayar dan keterangan admin
            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');
            $status_bayar_admin = $this->request->getVar('status_bayar_admin');
            $keterangan_admin   = strtoupper($this->request->getVar('keterangan_admin'));

            //Get Data Peserta-Kelas, Peserta, dan Data Kelas
            $get_data_peserta_kelas = $this->peserta_kelas->find($peserta_kelas_id);;
            $peserta_id             = $get_data_peserta_kelas['data_peserta_id'];
            $kelas_id               = $get_data_peserta_kelas['data_kelas_id'];
            $kelas                  = $this->kelas->find($kelas_id);
            $program_id         = $kelas['program_id'];
            $program            = $this->program->find($program_id);
            $biaya_daftar       = $program['biaya_daftar'];
            $biaya_bulanan      = $program['biaya_bulanan'];
            $biaya_modul        = $program['biaya_modul'];

            $get_data_peserta       = $this->peserta->find($peserta_id);
            $nama_peserta           = $get_data_peserta['nama_peserta'];
            $nis                    = $get_data_peserta['nis'];

            $get_data_kelas         = $this->kelas->find($kelas_id);
            $nama_kelas             = $get_data_kelas['nama_kelas'];
            
            // get file foto from input
            $filefoto = $this->request->getFile('foto');
            // ambil nama file
            //$namafoto = $filefoto->getName();
            // nama foto baru
            $ext = $filefoto->guessExtension();
            $namafoto_new = $peserta_id.'-'.date('Ymd-His').'.'.$ext;

            //Get nominal (on rupiah curenncy format) input from view
            $get_awal_bayar    = $this->request->getVar('awal_bayar');
            $get_bayar_spp2    = $this->request->getVar('spp2');
            $get_bayar_spp3    = $this->request->getVar('spp3');
            $get_bayar_spp4    = $this->request->getVar('spp4');
            $get_bayar_modul   = $this->request->getVar('modul');
            $get_bayar_infaq   = $this->request->getVar('infaq');
            $get_bayar_lain    = $this->request->getVar('lain');

            //Get Data from Input view
            $nominal_bayar      = str_replace(str_split('Rp. .'), '', $get_awal_bayar);
            // $bayar_spp2         = str_replace(str_split('Rp. .'), '', $get_bayar_spp2);
            // $bayar_spp3         = str_replace(str_split('Rp. .'), '', $get_bayar_spp3);
            // $bayar_spp4         = str_replace(str_split('Rp. .'), '', $get_bayar_spp4);
            // $bayar_modul        = str_replace(str_split('Rp. .'), '', $get_bayar_modul);
            $bayar_infaq        = str_replace(str_split('Rp. .'), '', $get_bayar_infaq);
            $bayar_lain         = str_replace(str_split('Rp. .'), '', $get_bayar_lain);

            $data_bayar = [
                'kelas_id'                  => $kelas_id,
                'bayar_peserta_id'          => $peserta_id,
                'status_bayar'              => 'Lunas',
                'status_bayar_admin'        => $status_bayar_admin,
                'status_konfirmasi'         => 'Terkonfirmasi',
                'awal_bayar'                => $nominal_bayar,
                'awal_bayar_daftar'         => '0',
                'awal_bayar_infaq'          => $bayar_infaq,
                'awal_bayar_spp1'           => '0',
                // 'awal_bayar_spp2'           => $bayar_spp2,
                // 'awal_bayar_spp3'           => $bayar_spp3,
                // 'awal_bayar_spp4'           => $bayar_spp4,
                // 'awal_bayar_modul'          => $bayar_modul,
                'awal_bayar_lainnya'        => $bayar_lain,
                'bukti_bayar'               => $namafoto_new,
                'tgl_bayar'                 => $tgl,
                'waktu_bayar'               => $waktu,
                'keterangan_bayar_admin'    => $keterangan_admin,
                'tgl_bayar_konfirmasi'      => $tgl,
                'waktu_bayar_konfirmasi'    => $waktu,
                'nominal_bayar'             => $nominal_bayar,
                'validator'                 => $validator,
            ];

            $this->db->transStart();
            $this->bayar->insert($data_bayar);
            $filefoto->move('public/img/transfer/', $namafoto_new);
            $bayar_id = $this->bayar->insertID();

            //
            $bayarTypes = ['spp2', 'spp3', 'spp4'];
            foreach ($bayarTypes as $type) {
                $get_bayar = ${"get_bayar_$type"};
                $biaya = ($type == 'daftar') ? $biaya_daftar : $biaya_bulanan;
                if ($get_bayar == 2) {
                    if ($get_data_peserta_kelas["byr_$type"] != $biaya || $get_data_peserta_kelas["beasiswa_$type"] != 1) {
                        $dtupdate = ["beasiswa_$type" => 1];
                        $this->peserta_kelas->update($peserta_kelas_id, $dtupdate);
                        $dtupdate2 = ["awal_bayar_$type" => 0];
                        $this->bayar->update($bayar_id, $dtupdate2);
                    }
                }
                if ($get_bayar == 1) {
                    if ($get_data_peserta_kelas["byr_$type"] != $biaya || $get_data_peserta_kelas["beasiswa_$type"] != 1) {
                        $dtupdate = ["byr_$type" => $biaya];
                        $this->peserta_kelas->update($peserta_kelas_id, $dtupdate);
                        $dtupdate2 = ["awal_bayar_$type" => $biaya];
                        $this->bayar->update($bayar_id, $dtupdate2);
                    }
                }
            }
            //

            if ($get_bayar_modul == 1) {
                $PKmodul = [
                    'byr_modul'            => $biaya_modul,
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $PKmodul);
                $data_modul = [
                    'bayar_modul_id'        => $bayar_id,
                    'bayar_modul'           => $biaya_modul,
                    'status_bayar_modul'    => 'Lunas',
                ];
                $this->bayar_modul->insert($data_modul);
                $PKmodul2 = [
                    'awal_bayar_modul'            => $biaya_modul,
                ];
                $this->bayar->update($bayar_id, $PKmodul2);
            }

            if ($bayar_lain != '0') {
                $data_lain = [
                    'lainnya_bayar_id'        => $bayar_id,
                    'bayar_lainnya'           => $bayar_lain,
                    'data_peserta_id_lain'    => $peserta_id,
                    'status_bayar_lainnya'    => 'Lunas',
                ];
                $this->bayar_lain->insert($data_lain);
            }

            if ($bayar_infaq != '0') {
                $data_infaq = [
                    'infaq_bayar_id'        => $bayar_id,
                    'bayar_infaq'           => $bayar_infaq,
                    'data_peserta_id_infaq' => $peserta_id
                ];
                $this->infaq->insert($data_infaq);
            }

            //Get data total bayar
            $peserta_kelas      = $this->peserta_kelas->find($peserta_kelas_id);
            $byr_daftar         = $peserta_kelas['byr_daftar'];
            $byr_modul          = $peserta_kelas['byr_modul'];
            $byr_spp1           = $peserta_kelas['byr_spp1'];
            $byr_spp2           = $peserta_kelas['byr_spp2'];
            $byr_spp3           = $peserta_kelas['byr_spp3'];
            $byr_spp4           = $peserta_kelas['byr_spp4'];

            $beasiswa_daftar    = $peserta_kelas['beasiswa_daftar'];
            $beasiswa_spp1      = $peserta_kelas['beasiswa_spp1'];
            $beasiswa_spp2      = $peserta_kelas['beasiswa_spp2'];
            $beasiswa_spp3      = $peserta_kelas['beasiswa_spp3'];
            $beasiswa_spp4      = $peserta_kelas['beasiswa_spp4'];

            $payments = [
                [$byr_daftar, $beasiswa_daftar],
                [$byr_spp1, $beasiswa_spp1],
                [$byr_spp2, $beasiswa_spp2],
                [$byr_spp3, $beasiswa_spp3],
                [$byr_spp4, $beasiswa_spp4]
            ];
            
            $spp_status = 'LUNAS';
            
            foreach ($payments as $payment) {
                if (($payment[0] == '0' && $payment[1] != 1) || ($payment[0] == NULL && $payment[1] != 1)) {
                    $spp_status = 'BELUM LUNAS';
                    break;
                }
            }

            $PKstatus = [
                'spp_status'  => $spp_status,
            ];
            $this->peserta_kelas->update($peserta_kelas_id, $PKstatus);

            $aktivitas = 'Buat Data Pembayaran SPP Atas Nama Peserta : ' . $nis . ' - ' . $nama_peserta . ' Pada Kelas ' . $nama_kelas;

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


            $this->session->setFlashdata('pesan_sukses', 'Pembuatan Pembayaran SPP oleh Admin Berhasil.');
            return redirect()->to('/pembayaran/add-spp');
        }
    }

    public function save_lain()
    {
            $validation = \Config\Services::validation();
            //Get Tgl Today
            $tgl = date("Y-m-d");
            $waktu = date("H:i:s");
            $strwaktu = date("H-i-s");

            $valid = $this->validate([
                'peserta_id' => [
                    'label' => 'peserta_id',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'awal_bayar' => [
                    'label' => 'awal_bayar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'infaq' => [
                    'label' => 'infaq',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'lain' => [
                    'label' => 'lain',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'status_bayar_admin' => [
                    'label' => 'status_bayar_admin',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'foto' => [
                    'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                    'errors' => [
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);

            if (!$valid) {
                $this->session->setFlashdata('pesan_eror', 'ERROR! Seluruh Form Input Bertanda * Wajib Diisi dan Harap Upload Bukti Bayar!');
                return redirect()->to('/pembayaran/add-lain');
            } else {

                //Admin input
                $validator          = session()->get('username');

                //Get inputan peserta, kelas, status bayar dan keterangan admin
                $peserta_id         = $this->request->getVar('peserta_id');
                $status_bayar_admin = $this->request->getVar('status_bayar_admin');
                $keterangan_admin   = strtoupper($this->request->getVar('keterangan_admin'));

                $get_data_peserta       = $this->peserta->find($peserta_id);
                $nama_peserta           = $get_data_peserta['nama_peserta'];
                $nis                    = $get_data_peserta['nis'];
                
                // get file foto from input
                $filefoto = $this->request->getFile('foto');
                $ext = $filefoto->guessExtension();
                // nama foto baru
                $namafoto_new = $peserta_id . '-'. date('Ymd-His') .'.'. $ext;
                
                //Get nominal (on rupiah curenncy format) input from view
                 $get_awal_bayar    = $this->request->getVar('awal_bayar');
                 $get_bayar_infaq   = $this->request->getVar('infaq');
                 $get_bayar_lain    = $this->request->getVar('lain');

                 //Get Data from Input view
                 $awal_bayar         = str_replace(str_split('Rp. .'), '', $get_awal_bayar);
                 $bayar_infaq        = str_replace(str_split('Rp. .'), '', $get_bayar_infaq);
                 $bayar_lain         = str_replace(str_split('Rp. .'), '', $get_bayar_lain);

                $data_bayar = [
                    'bayar_peserta_id'          => $peserta_id,
                    'status_bayar'              => 'Lunas',
                    'status_bayar_admin'        => $status_bayar_admin,
                    'status_konfirmasi'         => 'Terkonfirmasi',
                    'awal_bayar'                => $awal_bayar,
                    'awal_bayar_daftar'         => '0',
                    'awal_bayar_infaq'          => $bayar_infaq,
                    'awal_bayar_spp1'           => '0',
                    'awal_bayar_spp2'           => '0',
                    'awal_bayar_spp3'           => '0',
                    'awal_bayar_spp4'           => '0',
                    'awal_bayar_modul'          => '0',
                    'awal_bayar_lainnya'        => $bayar_lain,
                    'bukti_bayar'               => $namafoto_new,
                    'tgl_bayar'                 => date('Y-m-d'),
                    'waktu_bayar'               => date('H:i:s'),
                    'keterangan_bayar_admin'    => $keterangan_admin,
                    'tgl_bayar_konfirmasi'      => date('Y-m-d'),
                    'waktu_bayar_konfirmasi'    => date('H:i:s'),
                    'nominal_bayar'             => $awal_bayar,
                    'validator'                 => $validator,
                ];

                $this->db->transStart();
                $this->bayar->insert($data_bayar);
                $filefoto->move('public/img/transfer/', $namafoto_new);
                $bayar_id = $this->bayar->insertID();

                if ($bayar_lain != '0') {
                    $data_lain = [
                        'lainnya_bayar_id'        => $bayar_id,
                        'bayar_lainnya'           => $bayar_lain,
                        'data_peserta_id_lain'    => $peserta_id,
                        'status_bayar_lainnya'    => 'Lunas',
                    ];
                    $this->bayar_lain->insert($data_lain);
                }

                if ($bayar_infaq != '0') {
                    $data_infaq = [
                        'infaq_bayar_id'        => $bayar_id,
                        'bayar_infaq'           => $bayar_infaq,
                        'data_peserta_id_infaq' => $peserta_id
                    ];
                    $this->infaq->insert($data_infaq);
                }
                $aktivitas = 'Buat Data Pembayaran Infaq & Lain Atas Nama Peserta : ' . $nis . ' - ' . $nama_peserta;

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

                $this->session->setFlashdata('pesan_sukses', 'Pembuatan Pembayaran Infaq & Pembayaran Lain oleh Admin Berhasil.');
                return redirect()->to('/pembayaran/add-lain');
            }
    }

    /*--- REKAP BAYAR SPP ---*/
    //frontend
    public function rekap_spp()
    {
        $user           = $this->userauth(); // Return Array
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
        $list_rekap         = $this->peserta_kelas->admin_rekap_bayar($angkatan);

        $data = [
            'title'         => 'Rekap Data Pembayaran Peserta Angkatan ' . $angkatan,
            'user'          => $user,
            'list_angkatan' => $list_angkatan,
            'list'          => $list_rekap,
            'angkatan_pilih'=> $angkatan,
        ];
        
        return view('panel_admin/pembayaran/rekap/spp', $data);
    }

    public function rekap_spp_detail()
    {
        $user           = $this->userauth(); // Return Array
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('peserta', $params) && array_key_exists('kelas', $params)) {
            $peserta_id    = $params['peserta'];
            $kelas_id      = $params['kelas'];
            if (ctype_digit($peserta_id)) {
                $peserta_id= $params['peserta'];
            }else {
                return redirect()->to('/pembayaran/rekap-spp');
            }

            if (ctype_digit($kelas_id)) {
                $kelas_id  = $params['kelas'];
            }else {
                return redirect()->to('/pembayaran/rekap-spp');
            }

        } else {
            return redirect()->to('/pembayaran/rekap-spp');
        }
        

        //Data peserta
        $peserta  = $this->peserta->find($peserta_id);

        //Data kelas
        $kelas    = $this->kelas->find($kelas_id); 

        //Query List Bayar
        $list          = $this->bayar->rincian_bayar_peserta($peserta_id, $kelas_id);

        $data = [
            'title'         => 'Rincian Pembayaran ' . $peserta['nama_peserta'] . 'Pada Kelas ' . $kelas['nama_kelas'],
            'user'          => $user,
            'list'          => $list,
        ];
        return view('panel_admin/pembayaran/rekap/spp_detail', $data);
    }

    public function rekap_spp_edit()
    {
        if ($this->request->isAJAX()) {

            $peserta_kelas_id       = $this->request->getVar('peserta_kelas_id');
            $find_data              = $this->peserta_kelas->find($peserta_kelas_id);
            $peserta_id             = $find_data['data_peserta_id'];
            $peserta_data           = $this->peserta->find($peserta_id);
            $kelas_id               = $find_data['data_kelas_id'];
            $kelas_data             = $this->kelas->find($kelas_id);

            $biaya_daftar       = $this->request->getVar('biaya_daftar');
            $biaya_modul        = $this->request->getVar('biaya_modul');
            $biaya_program      = $this->request->getVar('biaya_program');
            $total_biaya        = $biaya_daftar + $biaya_modul + $biaya_program;

            $data = [
                'title'                 => 'Ubah Data Rekap Pembayaran SPP',
                'peserta_kelas_id'      => $peserta_kelas_id,
                'total_biaya'           => $total_biaya,
                'byr_daftar'            => $find_data['byr_daftar'],
                'byr_modul'             => $find_data['byr_modul'],
                'byr_spp1'              => $find_data['byr_spp1'],
                'byr_spp2'              => $find_data['byr_spp2'],
                'byr_spp3'              => $find_data['byr_spp3'],
                'byr_spp4'              => $find_data['byr_spp4'],
                'status_aktif_peserta'  => $find_data['status_aktif_peserta'],
                'nis'                   => $peserta_data['nis'],
                'nama_peserta'          => $peserta_data['nama_peserta'],
                'nama_kelas'            => $kelas_data['nama_kelas']

            ];
            $msg = [
                'sukses' => view('panel_admin/pembayaran/rekap/spp_edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    //backend
    public function rekap_spp_update()
    {
        if ($this->request->isAJAX()) {
                //Get nominal (on rupiah curenncy format) input from view
                $get_byr_daftar             = $this->request->getVar('byr_daftar');
                $get_byr_modul              = $this->request->getVar('byr_modul');
                $get_byr_spp1               = $this->request->getVar('byr_spp1');
                $get_byr_spp2               = $this->request->getVar('byr_spp2');
                $get_byr_spp3               = $this->request->getVar('byr_spp3');
                $get_byr_spp4               = $this->request->getVar('byr_spp4');
                $get_status_aktif_peserta   = $this->request->getVar('status_aktif_peserta');
                
                if ($get_byr_spp1 == '') {
                    $byr_spp1 = NULL;
                } else {
                    $byr_spp1     = str_replace(str_split('Rp. .'), '', $get_byr_spp1);
                }

                if ($get_byr_spp2 == '') {
                    $byr_spp2 = NULL;
                } else {
                    $byr_spp2     = str_replace(str_split('Rp. .'), '', $get_byr_spp2);
                }

                if ($get_byr_spp3 == '') {
                    $byr_spp3 = NULL;
                } else {
                    $byr_spp3     = str_replace(str_split('Rp. .'), '', $get_byr_spp3);
                }

                if ($get_byr_spp4 == '') {
                    $byr_spp4 = NULL;
                } else {
                    $byr_spp4     = str_replace(str_split('Rp. .'), '', $get_byr_spp4);
                }

                if ($get_byr_modul == '') {
                    $byr_modul = NULL;
                } else {
                    $byr_modul    = str_replace(str_split('Rp. .'), '', $get_byr_modul);
                }

                if ($get_status_aktif_peserta == "") {
                    $status_aktif_peserta = NULL;
                } else {
                    $status_aktif_peserta = "OFF";
                }
                

                //Replace Rp. and thousand separtor from input
                $byr_daftar   = str_replace(str_split('Rp. .'), '', $get_byr_daftar);

                $spp_terbayar = $byr_daftar + $byr_modul + $byr_spp1 + $byr_spp2 + $byr_spp3 + $byr_spp4;
                $total_biaya  = $this->request->getVar('total_biaya');
                $spp_piutang  = abs($spp_terbayar - $total_biaya);

                if ($spp_piutang == '0') {
                    $spp_status = "LUNAS";
                } elseif ($spp_piutang != '0') {
                    $spp_status = "BELUM LUNAS";
                }
                

                $simpandata = [
                    'spp_status'     => $spp_status,
                    'byr_daftar'     => $byr_daftar,
                    'byr_modul'      => $byr_modul,
                    'byr_spp1'       => $byr_spp1,
                    'byr_spp2'       => $byr_spp2,
                    'byr_spp3'       => $byr_spp3,
                    'byr_spp4'       => $byr_spp4,
                    'status_aktif_peserta' => $status_aktif_peserta,
                ];
                
                $peserta_kelas_id       = $this->request->getVar('peserta_kelas_id');
                $find_data              = $this->peserta_kelas->find($peserta_kelas_id);
                $peserta_id             = $find_data['data_peserta_id'];
                $peserta_data           = $this->peserta->find($peserta_id);
                $kelas_id               = $find_data['data_kelas_id'];
                $kelas_data             = $this->kelas->find($kelas_id);

                $this->peserta_kelas->update($peserta_kelas_id, $simpandata);

                $aktivitas = 'Ubah Data Rekap SPP Peserta  ' . $peserta_data['nis'] . ' ' . $peserta_data['nama_peserta'] . ' Kelas ' . $kelas_data['nama_kelas'];

                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => '/pembayaran/rekap-spp'
                    ]
                ];
            
            echo json_encode($msg);
        }
    }

    public function rekap_spp_export()
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
        
        $rekap_spp         = $this->peserta_kelas->admin_rekap_bayar($angkatan);
        $total_row         = count($rekap_spp) + 5;
        
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

        $judul = "DATA REKAP PEMBAYARAN SPP ALHAQQ - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   =  "ANGKATAN " .$angkatan. ' - ' . date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:Z1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:Z2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:Z4')->applyFromArray($style_up);

        $sheet->getStyle('A5:Z'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'NIS')
            ->setCellValue('B4', 'NAMA PESERTA')
            ->setCellValue('C4', 'JENIS KELAMIN')
            ->setCellValue('D4', 'LEVEL')
            ->setCellValue('E4', 'ANGKATAN PERKULIAHAN')
            ->setCellValue('F4', 'STATUS PESERTA')
            ->setCellValue('G4', 'KELAS')
            ->setCellValue('H4', 'PENGAJAR')
            ->setCellValue('I4', 'STATUS SPP')
            ->setCellValue('J4', 'TERBAYAR (TANPA MODUL)')
            ->setCellValue('K4', 'PIUTANG (TANPA MODUL)')
            ->setCellValue('L4', 'BAYAR PENDAFTARAN')
            ->setCellValue('M4', 'BAYAR SPP-1')
            ->setCellValue('N4', 'BAYAR SPP-2')
            ->setCellValue('O4', 'BAYAR SPP-3')
            ->setCellValue('P4', 'BAYAR SPP-4')
            ->setCellValue('Q4', 'BAYAR MODUL')

            ->setCellValue('R4', 'DT BYR PENDAFTARAN')
            ->setCellValue('S4', 'DT KONF. PENDAFTARAN')
            ->setCellValue('T4', 'DT BYR SPP2')
            ->setCellValue('U4', 'DT KONF. SPP2')

            ->setCellValue('V4', 'DT BYR SPP3')
            ->setCellValue('W4', 'DT KONF. SPP3')
            ->setCellValue('X4', 'DT BYR SPP4')
            ->setCellValue('Y4', 'DT KONF. SPP4')
            ->setCellValue('Z4', 'No. Telp. Peserta');

        $columns = range('A', 'Z');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;

        foreach ($rekap_spp as $data) {

            $sheet->getStyle('Z' . $row)->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

            $totalBiaya = $data['biaya_daftar'] + $data['biaya_program'];
            $totalBayar = $data['byr_daftar'] + $data['byr_spp1'] + $data['byr_spp2'] + $data['byr_spp3'] + $data['byr_spp4'];
            $totalBeasiswa = 0;

            $bayar_daftar = $data['byr_daftar'];
            $bayar_spp1   = $data['byr_spp1'];
            $bayar_spp2   = $data['byr_spp2'];
            $bayar_spp3   = $data['byr_spp3'];
            $bayar_spp4   = $data['byr_spp4'];
        
            // Jika beasiswa diterima, anggap sebagai pembayaran
            if($data['beasiswa_daftar'] == 1) {
                $totalBeasiswa += $data['biaya_daftar'];
                $bayar_daftar = "BEASISWA";
            }
            if($data['beasiswa_spp1'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
                $bayar_spp1 = "BEASISWA";
            }
            if($data['beasiswa_spp2'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
                $bayar_spp2 = "BEASISWA";
            }
            if($data['beasiswa_spp3'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
                $bayar_spp3 = "BEASISWA";
            }
            if($data['beasiswa_spp4'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
                $bayar_spp4 = "BEASISWA";
            }
            // total pembayaran ditambah dengan total beasiswa
            $totalBayar += $totalBeasiswa;

            if ($totalBiaya - $totalBayar != 0) {
                $spp_status = "BELUM LUNAS";
            } elseif ($totalBiaya - $totalBayar == 0){
                $spp_status = "LUNAS";
            }

            $terbayar = $data['byr_daftar'] + $data['byr_spp1'] + $data['byr_spp2'] + $data['byr_spp3'] + $data['byr_spp4'];
        

            if($data['status_aktif_peserta'] == NULL) {
                $status_aktif_peserta = 'AKTIF';
            }else {
                $status_aktif_peserta = $data['status_aktif_peserta'];
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $data['nis'])
                ->setCellValue('B' . $row, $data['nama_peserta'])
                ->setCellValue('C' . $row, $data['jenkel'])
                ->setCellValue('D' . $row, $data['nama_level'])
                ->setCellValue('E' . $row, $data['angkatan_kelas'])
                ->setCellValue('F' . $row, $status_aktif_peserta)
                ->setCellValue('G' . $row, $data['nama_kelas'])
                ->setCellValue('H' . $row, $data['nama_pengajar'])
                ->setCellValue('I' . $row, $spp_status)
                ->setCellValue('J' . $row, $terbayar)
                ->setCellValue('K' . $row, $totalBiaya - $totalBayar)
                ->setCellValue('L' . $row, $bayar_daftar)
                ->setCellValue('M' . $row, $bayar_spp1)
                ->setCellValue('N' . $row, $bayar_spp2)
                ->setCellValue('O' . $row, $bayar_spp3)
                ->setCellValue('P' . $row, $bayar_spp4)
                ->setCellValue('Q' . $row, $data['byr_modul'])

                ->setCellValue('R' . $row, $data['dt_bayar_daftar'])
                ->setCellValue('S' . $row, $data['dt_konfirmasi_daftar'])
                ->setCellValue('T' . $row, $data['dt_bayar_spp2'])
                ->setCellValue('U' . $row, $data['dt_konfirmasi_spp2'])
                ->setCellValue('V' . $row, $data['dt_bayar_spp3'])
                ->setCellValue('W' . $row, $data['dt_konfirmasi_spp3'])
                ->setCellValue('X' . $row, $data['dt_bayar_spp4'])
                ->setCellValue('Y' . $row, $data['dt_konfirmasi_spp4'])
                ->setCellValue('Z' . $row, $data['hp']);
                // ->setCellValue('AA' . $row, $data['peserta_kelas_id']);
            
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-SPP-Angkatan'.$angkatan.'-'. date('Y-m-d-His');

        $aktivitas =  'Download Data Rekap SPP via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function rekap_spp_cek()
    {
        $user = $this->userauth();
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
        
        $list       = $this->peserta_kelas->admin_rekap_bayar($angkatan);
        $checked    = "";
        // var_dump($list);
        foreach($list as $data){
            $peserta_kelas_id =  intval($data['peserta_kelas_id']);
            $totalBiaya = $data['biaya_daftar'] + $data['biaya_program'];
            $totalBayar = $data['byr_daftar'] + $data['byr_spp1'] + $data['byr_spp2'] + $data['byr_spp3'] + $data['byr_spp4'];
            $totalBeasiswa = 0;

            // Jika beasiswa diterima, anggap sebagai pembayaran
            if($data['beasiswa_daftar'] == 1) {
                $totalBeasiswa += $data['biaya_daftar'];
            }
            if($data['beasiswa_spp1'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
            }
            if($data['beasiswa_spp2'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
            }
            if($data['beasiswa_spp3'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
            }
            if($data['beasiswa_spp4'] == 1) {
                $totalBeasiswa += $data['biaya_bulanan'];
            }
            // total pembayaran ditambah dengan total beasiswa
            $totalBayar += $totalBeasiswa;

            if($totalBiaya - $totalBayar != 0) {
                $spp_status_real = "BELUM LUNAS";
            }
            if($totalBiaya - $totalBayar == 0) {
                $spp_status_real = "LUNAS";
            }

            if ($data['spp_status'] != $spp_status_real) {
                $data = [
                    'spp_status' => $spp_status_real
                ];
                $this->peserta_kelas->update($peserta_kelas_id, $data);
                
                $checked = $checked . $peserta_kelas_id.', ';
            }
        }
        $aktivitas = "Pembenaran Otomatis Status SPP pada peserta_kelas_id: ".$checked;
        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);
        return redirect()->to('/log-admin');
    }

    /*--- REKAP BAYAR INFAQ ---*/
    //frontend
    public function rekap_infaq()
    {
        $user = $this->userauth();
        $data = [
            'title'  => 'Rekap Data Pembayaran Infaq',
            'user'   => $user,   
            'infaq'  => $this->infaq->list(),
        ];
        return view('panel_admin/pembayaran/rekap/infaq', $data);
        //var_dump($this->infaq->list());
    }
    //backend
    public function rekap_infaq_export()
    {
        $rekap_infaq =  $this->infaq->list();
        $total_row   = count($rekap_infaq) + 5;

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

        $judul = "DATA REKAP PEMBAYARAN INFAQ ALHAQQ - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:I4')->applyFromArray($style_up);

        $sheet->getStyle('A5:I'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'TRANSAKSI ID')
            ->setCellValue('B4', 'NIS')
            ->setCellValue('C4', 'NAMA PESERTA')
            ->setCellValue('D4', 'TGL BAYAR')
            ->setCellValue('E4', 'WAKTU BAYAR')
            ->setCellValue('F4', 'NOMINAL')
            ->setCellValue('G4', 'VALIDATOR')
            ->setCellValue('H4', 'KET. PESERTA')
            ->setCellValue('I4', 'KET. ADMIN');
        
        $columns = range('A', 'I');
        foreach ($columns as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        $row = 5;

        foreach ($rekap_infaq as $rekap) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $rekap['bayar_id'])
                ->setCellValue('B' . $row, $rekap['nis'])
                ->setCellValue('C' . $row, $rekap['nama_peserta'])
                ->setCellValue('D' . $row, $rekap['tgl_bayar'])
                ->setCellValue('E' . $row, $rekap['waktu_bayar'])
                ->setCellValue('F' . $row, $rekap['bayar_infaq'])
                ->setCellValue('G' . $row, $rekap['validator'])
                ->setCellValue('H' . $row, $rekap['keterangan_bayar'])
                ->setCellValue('I' . $row, $rekap['keterangan_bayar_admin']);
            $row++;
        }

        $writer     = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename   =  'Data-Rekap-Infaq-'. date('Y-m-d-His');

        $aktivitas  = 'Download Data Rekap Infaq via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    /*--- REKAP BAYAR LAIN ---*/
    //frontend
    public function rekap_lain()
    {
        $user = $this->userauth();
        $data = [
            'title'  => 'Rekap Data Pembayaran Lain',
            'user'   => $user,
            'lain'   => $this->bayar_lain->list(),
        ];
        return view('panel_admin/pembayaran/rekap/lain', $data);
    }

    public function rekap_lain_edit()
    {
        if ($this->request->isAJAX()) {

            $biaya_lainnya_id = $this->request->getVar('biaya_lainnya_id');
            $bayar_lain       =  $this->bayar_lain->find($biaya_lainnya_id);
            $data = [
                'title'             => 'Ubah Pembayaran Lain',
                'biaya_lainnya_id'  => $biaya_lainnya_id,
                'bayar_lainnya'     => $bayar_lain['bayar_lainnya'],
            ];
            $msg = [
                'sukses' => view('panel_admin/pembayaran/rekap/lain_edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    //backend
    public function rekap_lain_export()
    {
        $rekap_lain =  $this->bayar_lain->list();
        $total_row  = count($rekap_lain) + 5;

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

        $judul = "DATA REKAP PEMBAYARAN LAINNYA ALHAQQ - ALHAQQ ACADEMIC INFORMATION SYSTEM";
        $tgl   = date("d-m-Y");

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->applyFromArray($styleColumn);

        $sheet->setCellValue('A2', $tgl);
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A2')->applyFromArray($styleColumn);

        $sheet->getStyle('A4:I4')->applyFromArray($style_up);

        $sheet->getStyle('A5:I'.$total_row)->applyFromArray($isi_tengah);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A4', 'TRANSAKSI ID')
            ->setCellValue('B4', 'NIS')
            ->setCellValue('C4', 'NAMA PESERTA')
            ->setCellValue('D4', 'TGL BAYAR')
            ->setCellValue('E4', 'WAKTU BAYAR')
            ->setCellValue('F4', 'NOMINAL')
            ->setCellValue('G4', 'VALIDATOR')
            ->setCellValue('H4', 'KET. PESERTA')
            ->setCellValue('I4', 'KET. ADMIN');
        
            $columns = range('A', 'I');
            foreach ($columns as $column) {
                $spreadsheet->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

        $row = 5;

        foreach ($rekap_lain as $rekap) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $row, $rekap['bayar_id'])
                ->setCellValue('B' . $row, $rekap['nis'])
                ->setCellValue('C' . $row, $rekap['nama_peserta'])
                ->setCellValue('D' . $row, $rekap['tgl_bayar'])
                ->setCellValue('E' . $row, $rekap['waktu_bayar'])
                ->setCellValue('F' . $row, $rekap['bayar_lainnya'])
                ->setCellValue('G' . $row, $rekap['validator'])
                ->setCellValue('H' . $row, $rekap['keterangan_bayar'])
                ->setCellValue('I' . $row, $rekap['keterangan_bayar_admin']);

            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename =  'Data-Rekap-Pembyaran-Lain-'. date('Y-m-d-His');

        $aktivitas = 'Download Data Rekap Pemby. Lain via Export Excel, Waktu : ' .  date('Y-m-d-H:i:s');

        /*--- Log ---*/
        $this->logging('Admin', 'BERHASIL', $aktivitas);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function rekap_lain_update()
    {
        if ($this->request->isAJAX()) {
                $get             = $this->request->getVar('bayar_lainnya');
                $bayar_lainnya   = str_replace(str_split('Rp. .'), '', $get);
                $update_data = [
                    'bayar_lainnya'  => $bayar_lainnya,
                ];

                $biaya_lainnya_id = $this->request->getVar('biaya_lainnya_id');
                $this->bayar_lain->update($biaya_lainnya_id, $update_data);

                $find_data              = $this->bayar_lain->find($biaya_lainnya_id);
                $transaksi_id           = $find_data['lainnya_bayar_id'];

                $bayar_data             = $this->bayar->find($transaksi_id);
                $peserta_id             = $bayar_data['bayar_peserta_id'];

                $peserta_data           = $this->peserta->find($peserta_id);
                $nis                    = $peserta_data['nis'];
                $nama                   = $peserta_data['nama_peserta'];

                $aktivitas = 'Ubah Pembayaran Lain, Transaksi ID: ' .  $transaksi_id . ' Peserta ' . $nis . ' - ' . $nama;

                /*--- Log ---*/
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => '/pembayaran/rekap-lain'
                    ]
                ];
            
            echo json_encode($msg);
        }
    }

    public function rekap_lain_delete()
    {
        if ($this->request->isAJAX()) {

            $biaya_lainnya_id       = $this->request->getVar('biaya_lainnya_id');

            $find_data              = $this->bayar_lain->find($biaya_lainnya_id);
            $transaksi_id           = $find_data['lainnya_bayar_id'];

            $bayar_data             = $this->bayar->find($transaksi_id);
            $peserta_id             = $bayar_data['bayar_peserta_id'];

            $peserta_data           = $this->peserta->find($peserta_id);
            $nis                    = $peserta_data['nis'];
            $nama                   = $peserta_data['nama_peserta'];

            $this->bayar_lain->delete($biaya_lainnya_id);

            $aktivitas = 'Hapus Data Pembayaran Lain, Transaksi ID : ' .  $transaksi_id . ' Peserta ' . $nis . ' - ' . $nama;

            /*--- Log ---*/
            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => '/pembayaran/rekap-lain'
                ]
            ];
            echo json_encode($msg);
        }
    }
}