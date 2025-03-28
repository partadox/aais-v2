<?php
namespace App\Controllers\Pengajar;

use App\Controllers\BaseController;

class KelasNonreg extends BaseController
{
    public function index()
    {
        $user           = $this->userauth(); // Return Array
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('tahun', $params)) {
            $tahun           = $params['tahun'];
            if (ctype_digit($tahun)) {
                $tahun           = $params['tahun'];
            }else {
                $tahun           = date('Y');
            }
        } else {
            $tahun           = date('Y');
        }
        
        $list_tahun      = $this->nonreg_kelas->list_unik_tahun();
        $get_pengajar_id    = $this->pengajar->get_pengajar_id($user['user_id']);
        $pengajar_id        = $get_pengajar_id->pengajar_id;

        $nonreg_pengajar    = $this->nonreg_pengajar->list_pengajar($pengajar_id);
        $npj_kelas_array = array_map(function($item) {
            return $item['npj_kelas'];
        }, $nonreg_pengajar);

        // $list               = $this->nonreg_kelas->whereIn('nk_id', $npj_kelas_array)->where('nk_angkatan', $angkatan)->where('nk_status', 1)->where('nk_status_daftar', 1)->findAll();
        if ($npj_kelas_array != null) {
            $list               = $this->nonreg_kelas->whereIn('nk_id', $npj_kelas_array)->where('nk_tahun', $tahun)->where('nk_status', 1)->findAll();
        } else{
            $list = null;
        }
        


        $data = [
            'title'                 => 'Daftar Kelas Non-Reguler Anda pada Tahun '.$tahun.' Sebagai Pengajar',
            'user'                  => $user,
            'list_tahun'            => $list_tahun,
            'tahun_pilih'           => $tahun,
            'list'                  => $list,
        ];

        return view('panel_pengajar/kelas_nonreg/index', $data); 
    }

    public function absensi()
    {
        $user = $this->userauth(); // Return Array

        //Angkatan
        $uri = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString = $uri->getQuery();
        $params = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('kelas', $params)) {
            $kelas_id = $params['kelas'];
        } else {
            return redirect()->to('/pengajar/kelas-nonreg');
        }

        // $peserta_onkelas = $this->peserta_kelas->peserta_onkelas_absen($kelas_id);
        // $absen_pengajar_id = $this->kelas->get_data_absen_pengajar_id($kelas_id)->data_absen_pengajar;
        // $absen_pengajar = $this->absen_pengajar->find($absen_pengajar_id);

        $get_pengajar_id    = $this->pengajar->get_pengajar_id($user['user_id']);
        $pengajar_id        = $get_pengajar_id->pengajar_id;

        $absenTm = $this->nonreg_absen_pengajar
        ->join('nonreg_pengajar', 'nonreg_pengajar.npj_id = nonreg_absen_pengajar.napj_pengajar')
        ->where('npj_kelas', $kelas_id)
        ->where('npj_pengajar', $pengajar_id)
        
        ->first();

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
                    $entry[$tmKey] = json_decode($record[$tmKey],true);
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

        $data = [
			'title'			=> 'Absensi Kelas Non-Reguler '.$kelas['nk_nama'],
			'user'			=> $user,
            'kelas'         => $kelas,
            'absenTm'       => $absenTm,
            'peserta_onkelas'=> $peserta_onkelas
		];

        return view('panel_pengajar/kelas_nonreg/absensi', $data);
        
    }

    public function input_absensi()
    {
        if ($this->request->isAJAX()) {

            $user = $this->userauth();

            $tm         = $this->request->getVar('tm');
            $nk_id      = $this->request->getVar('nk_id');

            $get_pengajar_id    = $this->pengajar->get_pengajar_id($user['user_id']);
            $pengajar_id        = $get_pengajar_id->pengajar_id;

            $absenKelas = $this->nonreg_absen_pengajar
            ->join('nonreg_pengajar', 'nonreg_pengajar.npj_id = nonreg_absen_pengajar.napj_pengajar')
            ->where('npj_kelas', $nk_id)
            ->where('npj_pengajar', $pengajar_id)
            ->first();

            $absenTm    = json_decode($absenKelas['napj'.$tm],true);

            $title      = 'FORM ISI ABSENSI TM-'.$tm;
            $kelas      = $this->nonreg_kelas->find($nk_id);
            $pengajar   = $this->pengajar->find($pengajar_id);

            $getAbsensi = $this->nonreg_absen_peserta
            ->join('nonreg_peserta', 'nonreg_peserta.np_id = nonreg_absen_peserta.naps_peserta')
            ->where('np_kelas', $nk_id)
            ->orderBy('np_id', 'ASC')
            ->findAll();

            $listAbsensi= [];

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
                    'naps'.$tm => json_decode($record['naps'.$tm],true)
                ];
            }

            $data = [
                'title'         => $title,
                'kelas'         => $kelas,
                'pengajar'      => $pengajar,
                'tm'            => $tm,
                'absenTm'       => $absenTm,
                'absenKelas'    => $absenKelas,
                'listAbsensi'   => $listAbsensi
            ];

            // $absen_tm   = $this->peserta_kelas->peserta_onkelas_absen_tm($tm, $kelas_id);
            // $data_absen_pengajar   = $this->request->getVar('data_absen_pengajar');

            //Data Kelas
            // $data_kelas         = $this->kelas->list_detail_kelas($kelas_id);
            // $nama_pengajar      = $data_kelas[0]['nama_pengajar'];
            // $absen_pengajar_id  = $data_kelas[0]['data_absen_pengajar'];

            //Data absen pengajar
            // $absen_pengajar  = $this->absen_pengajar->find($data_absen_pengajar);
            // $tgl_tm          = "tgl_".$tm;
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
            //     'absen_pengajar'=> $absen_pengajar,
            //     'absen_pengajar_id' => $absen_pengajar_id,
            // ];

            $msg = [
                'sukses' => view('panel_pengajar/kelas_nonreg/input_absensi', $data)
            ];
            echo json_encode($msg);
        }
    }

    // public function atur_absensi()
    // {
    //     if ($this->request->isAJAX()) {

    //         $kelas_id  = $this->request->getVar('kelas_id');
    //         $kelas     = $this->kelas->find($kelas_id);
    //         if ($kelas['metode_absen'] == NULL) {
    //             $metode = 'Pengajar';
    //         } else{
    //             $metode = $kelas['metode_absen'];
    //         }
    //         $data = [
    //             'title' => 'Pengaturan Absensi Mandiri',
    //             'kelas' => $kelas,
    //             'metode'=> $metode,
    //         ];

    //         $msg = [
    //             'sukses' => view('panel_pengajar/kelas/atur_absensi', $data)
    //         ];
    //         echo json_encode($msg);
    //     }
    // }


    public function save_absensi()
    {
        $user = $this->userauth();

        $tm      = $this->request->getVar('tm');
        $kelasId = $this->request->getVar('kelasId');
        $napjId  = $this->request->getVar('napjId');

        $dt_tm   = $this->request->getVar('dt_tm');
        $note    = str_replace(array("\r", "\n", "\r\n"), ' ',$this->request->getVar('note'));

        $arNp    = $this->request->getVar('arNp');
        $arNaps  = $this->request->getVar('arNaps');

        $kelas = $this->nonreg_kelas->find($kelasId);

        foreach ($arNaps as $naps) {
            $cek = $this->request->getVar('cek'.$naps);
            $ab  = json_encode([
                'tm'    => $cek,
                'dt_tm' => $dt_tm,
                'dt_isi'=> date('Y-m-d H:i:s'),
                'note'  => '',
                'by'    => $user['nama']
            ]);
            $abData = [
                'naps'.$tm => $ab,
            ];
            $this->nonreg_absen_peserta->update($naps,$abData);
        }

        $abpj  = json_encode([
            'tm'      => '1',
            'dt_tm'   => $dt_tm,
            'dt_isi'  => date('Y-m-d H:i:s'),
            'note'    => $note,
            'by'      => $user['nama']
        ]);
        $abpjData = [
            'napj'.$tm => $abpj,
        ];
        $this->nonreg_absen_pengajar->update($napjId,$abpjData);

        return $this->response->setJSON(
        [
            'success' => true,
            'code'    => '200',
            'data'    => [
                'title' => 'Berhasil',
                'link'  => '/pengajar/absensi-nonreg?kelas=' . $kelasId,
                'icon'  => 'success',
            ],
            'message' => 'Pengisian Form Berhasil.' ,
        ]);
    }

    // public function update_atur_absensi()
    // {
    //     $kelas_id       = $this->request->getVar('kelas_id');
    //     $kelas          = $this->kelas->find($kelas_id);
    //     $metode_absen   = $this->request->getVar('metode_absen');
    //     $tm_absen       = $this->request->getVar('tm_absen');
    //     $expired_absen  = $this->request->getVar('expired_absen');

    //     if ($metode_absen == "Mandiri") {
    //         if ($this->request->isAJAX()) {
    //             $validation = \Config\Services::validation();
    //             $valid = $this->validate([
    //                 'expired_absen_waktu' => [
    //                     'label' => 'Waktu expired absen mandiri',
    //                     'rules' => 'required',
    //                     'errors' => [
    //                         'required' => '{field} tidak boleh kosong',
    //                     ]
    //                 ],
    //             ]);
    //             if (!$valid) {
    //                 $msg = [
    //                     'error' => [
    //                         'expired_absen_waktu'  => $validation->getError('expired_absen_waktu'),
    //                     ]
    //                 ];
    //             } else {
    //                 $updatedata = [
    //                     'metode_absen'  => $metode_absen,
    //                     'tm_absen'      => $tm_absen,
    //                     'expired_absen' => $expired_absen,
    //                 ];
    
    //                 $this->kelas->update($kelas_id, $updatedata);
    
    //                 $aktivitas = 'Pengajar Mengubah Metode Absen Menjadi Mandiri di Kelas' . $kelas['nama_kelas'] . ' sampai ' . $expired_absen ;
    
    //                 $this->logging('Admin', 'BERHASIL', $aktivitas);
    
    //                 $msg = [
    //                     'sukses' => [
    //                         'link' => '/pengajar/absensi?kelas='.$kelas_id
    //                     ]
    //                 ];
    //             }
                
    //         }
    //     }

    //     echo json_encode($msg);
        
    // }

    // public function absensi_note()
    // {
    //     if ($this->request->isAJAX()) {

    //         $absen_peserta_id   = $this->request->getVar('absen_peserta_id');
    //         $absen              = $this->absen_peserta->find($absen_peserta_id);
    //         $tm_notes           = [];
    //         $peserta            = $this->request->getVar('nis') . ' - ' . $this->request->getVar('nama');
    //         $kelas_id           = $this->request->getVar('kelas_id');

    //         for ($i = 1; $i <= 16; $i++) {
    //             $tm_notes[$i] = $absen["note_ps_tm" . $i];
    //         }

    //         $data = [
    //             'title'            => 'Note Peserta',
    //             'absen_peserta_id' => $absen_peserta_id,
    //             'absen'            => $absen,
    //             'tm_notes'         => json_encode($tm_notes),
    //             'peserta'          => $peserta,
    //             'kelas_id'         => $kelas_id,
    //         ];
    //         $msg = [
    //             'sukses' => view('panel_pengajar/kelas/edit-note', $data)
    //         ];
    //         echo json_encode($msg);
    //     }
    // }

    // public function update_absensi_note()
    // {
    //     if ($this->request->isAJAX()) {
    //         $absen_peserta_id    = $this->request->getVar('absen_peserta_id');
    //         $tm                  = $this->request->getVar('tm');
    //         $note_ps_tm          = 'note_ps_tm'.$tm;

    //         $absen               = $this->absen_peserta->find($absen_peserta_id);

    //         $update_data = [
    //             $note_ps_tm  => str_replace(array("\r", "\n"), ' ',$this->request->getVar('note'))
    //         ];
    //         $this->absen_peserta->update($absen_peserta_id, $update_data);

    //         $msg = [
    //             'sukses' => [
    //                 'link' => '/pengajar/absensi?kelas='.$this->request->getVar('kelas_id')
    //             ]
    //         ];
    //     }
    //     echo json_encode($msg);
    // }
}