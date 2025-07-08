<?php

namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Sertifikat extends BaseController
{
    public function index()
    {
        $user         = $this->userauth();
        $user_id      = $user['user_id'];
        $peserta      = $this->peserta->get_peserta($user_id);

        $statSert     = $this->konfigurasi->status_menu_sertifikat();
        $status_sertifikat   = $statSert->status_menu_sertifikat;

        $data = [
            'title'             => 'Sertifikat',
            'user'              => $user,
            'status_sertifikat' => $status_sertifikat,
            'list'        => $this->sertifikat->list_peserta($peserta['peserta_id']),
        ];

        return view('panel_peserta/sertifikat/index', $data);
    }

    public function input()
    {
        $user         = $this->userauth();
        $user_id      = $user['user_id'];
        $peserta      = $this->peserta->get_peserta($user_id);

        $bSert              = $this->konfigurasi->biaya_sertifikat();
        $biaya_sertifikat   = $bSert->biaya_sertifikat;

        $statSert           = $this->konfigurasi->status_menu_sertifikat();
        $status_sertifikat  = $statSert->status_menu_sertifikat;

        $listLulus         = $this->peserta_kelas->list_kelas_peserta_lulus($peserta['peserta_id']);
        $sertifikat_sudah   = $this->sertifikat->sertifikat_sudah_peserta($peserta['peserta_id']);

        // Mendapatkan array dari sertifikat_kelas di Array B
        $kelasIds = array_column($sertifikat_sudah, 'sertifikat_kelas');

        // Filter Array A untuk menghapus elemen yang kelas_id-nya ada di Array B
        $list_lulus = array_filter($listLulus, function ($item) use ($kelasIds) {
            return !in_array($item['kelas_id'], $kelasIds);
        });

        $data = [
            'title'             => 'Form Pembayaran Sertifikat',
            'user'              => $user,
            'peserta'           => $peserta,
            'program'           => $this->program->list_program_sertifikat(),
            'biaya_sertifikat'  => $biaya_sertifikat,
            'status_sertifikat' => $status_sertifikat,
            'list_lulus'        => $list_lulus,
        ];

        return view('panel_peserta/sertifikat/add', $data);
    }

    public function show_sertifikat()
    {
        if ($this->request->isAJAX()) {
            $sertifikat_id   = $this->request->getVar('sertifikat_id');
            $data_sertifikat = $this->sertifikat->find($sertifikat_id);


            $data = [
                'title'                 => 'Sertifikat',
                'sertifikat_id'         => $sertifikat_id,
                'data_sertifikat'       => $data_sertifikat,
            ];
            $msg = [
                'sukses' => view('panel_peserta/sertifikat/modal', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function save_sertifikat()
    {
        $validation = \Config\Services::validation();

        //Get Tgl Today
        $tgl        = date("Y-m-d");
        $waktu      = date("H:i:s");
        $strwaktu   = date("H-i-s");

        $get_angkatan       = $this->konfigurasi->angkatan_kuliah();
        $angkatan           = $get_angkatan->angkatan_kuliah;

        $get_periode       = $this->konfigurasi->periode_sertifikat();
        $periode           = $get_periode->periode_sertifikat;

        $valid = $this->validate([
            'foto' => [
                'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpg,image/jpeg]|is_image[foto]',
                'errors' => [
                    'mime_in' => 'Harus gambar!'
                ]
            ]
        ]);

        if (!$valid) {
            $this->session->setFlashdata('pesan_eror', 'ERROR! Harap Upload Bukti Bayar!');
            return redirect()->to('/peserta/sertifikat-input');
        } else {

            $user               = $this->userauth();
            $validator          = $user['username'];

            $peserta_id         = $this->request->getVar("peserta_id");
            $peserta            = $this->peserta->find($peserta_id);

            //Get value
            $jenis               = $this->request->getVar('jenis');
            if ($jenis == 'aais') {
                $kelas_id           = $this->request->getVar("kelas_id");
                $kelas              = $this->kelas->find($kelas_id);
                $program_id         = $kelas['program_id'];
                $sertifikat_kelas    = $kelas_id;
                $program = $this->program->find($program_id);
                $padaWA = " untuk kelulusan Program " . $program['nama_program'] . " kelas " . $kelas['nama_kelas'];
            } elseif ($jenis == 'nonaais') {
                $program_id         = $this->request->getVar('program_id');
                $program            = $this->program->find($program_id);
                $sertifikat_kelas   = 1;

                $padaWA = " untuk kelulusan Program " . $program['nama_program'];
            }

            //Get inputan peserta, kelas, status bayar dan keterangan admin
            $keterangan_bayar       = str_replace(array("\r", "\n"), ' ', $this->request->getVar('keterangan_bayar'));

            // get file foto from input
            $filefoto           = $this->request->getFile('foto');
            $ext                = $filefoto->guessExtension();
            $namafoto_new       = $peserta['nis'] . '-Sertifikat-' . date('Ymd-His') . '.' . $ext;

            //Get nominal (on rupiah curenncy format) input from view
            $total              = $this->request->getVar('total');
            $nominal_bayar_cetak = $this->request->getVar('nominal_bayar_cetak');
            $get_bayar_infaq    = $this->request->getVar('infaq');

            //Get Data from Input view
            $bayar_infaq        = str_replace(str_split('Rp. .'), '', $get_bayar_infaq);

            $data_bayar = [
                'kelas_id'                  => "1",
                'bayar_peserta_id'          => "1",
                'bayar_tipe'                => 'sertifikat',
                'status_bayar'              => "Belum Lunas",
                'status_bayar_admin'        => null,
                'status_konfirmasi'         => 'Proses',
                'awal_bayar'                => $total,
                'awal_bayar_infaq'          => $bayar_infaq,
                'awal_bayar_spp1'           => $nominal_bayar_cetak,
                'bukti_bayar'               => $namafoto_new,
                'tgl_bayar'                 => $tgl,
                'waktu_bayar'               => $waktu,
                // 'keterangan_bayar'          => "Bayar Sertifikat#".strtoupper($jenis)."#".$peserta['nis']." - ".$peserta['nama_peserta']."#".$program['nama_program'],
                'keterangan_bayar'          => $keterangan_bayar,
                // 'tgl_bayar_konfirmasi'      => $tgl,
                // 'waktu_bayar_konfirmasi'    => $waktu,
                'nominal_bayar'             => $total,
                // 'validator'                 => $validator,
            ];

            $this->db->transStart();
            $state[]    = $this->bayar->insert($data_bayar);
            $state[]    = $filefoto->move('public/img/transfer/', $namafoto_new, true);
            $bayar_id   = $this->bayar->insertID();

            $newSertifikat = [
                'sertifikat_peserta_id' => $peserta_id,
                'sertifikat_program'    => $program_id,
                'periode_cetak'         => $periode,
                'angkatan_sertifikat'   => $angkatan,
                // 'nomor_sertifikat'      => $this->generate_nomor_sertifikat($program['kode_program']),
                'nomor_sertifikat'      => 0,
                'nominal_bayar_cetak'   => $nominal_bayar_cetak,
                'status'                => 0,
                'bukti_bayar_cetak'     => $bayar_id,
                'keterangan_cetak'      => $keterangan_bayar,
                'sertifikat_tgl'        => date('Y-m-d'),
                // 'sertifikat_file'       => $peserta['nis']."-".$program['kode_program']."-". date('YmdHis') . '.pdf',
                'sertifikat_file'       => 0,
                'sertifikat_kelas'       => $sertifikat_kelas,
            ];
            $sertifikat_id       = $this->sertifikat->insert($newSertifikat);
            $state[]            = $sertifikat_id;
            // $state[]        = $this->generate_sertifikat($sertifikat_id);           

            if ($bayar_infaq != '0') {
                $data_infaq = [
                    'infaq_bayar_id'        => $bayar_id,
                    'bayar_infaq'           => $bayar_infaq,
                    'data_peserta_id_infaq' => '1'
                ];
                $state[] = $this->infaq->insert($data_infaq);
            }

            $aktivitas = 'Buat Data Pembayaran Sertifikat ' . strtoupper($jenis);

            $state = json_encode($state);

            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                /*--- Log ---*/
                $this->logging('Peserta', 'FAIL', $aktivitas);
                $pesan      = 'pesan_eror';
                $pesanisi   = 'Pembuatan Pembayaran Sertifikat Gagal ' . $state;
            } else {
                $this->db->transComplete();
                /*--- Log ---*/
                $this->logging('Peserta', 'BERHASIL', $aktivitas);
                $pesan      = 'pesan_sukses';
                $pesanisi   = 'Pembuatan Pembayaran Sertifikat Berhasil.';
                $onWA = $this->wa_switch->find("peserta-sertifikat");
                if ($onWA['status'] == 1) {
                    $dataWA = $this->wa->find(1);
                    $msgWA  = "Terima kasih " . $peserta['nama_peserta'] . ", " . $peserta['nis'] . " Anda telah melakukan input pembayaran Sertifikat " . $padaWA . " sebesar Rp " . rupiah($total) . " pada " . date('d-m-Y H:i') . " WITA" . "\n\nHarap hubungi Admin jika dalam 2x24 jam (hari kerja) pembayaran anda belum dikonfirmasi." . "\n\nAdmin\n+628998049000\nLTTQ Al Haqq Balikpapan (Pusat)" . $dataWA['footer'];
                    $this->sendWA("aaispusat", $peserta['hp'], $msgWA);
                }
            }


            $this->session->setFlashdata($pesan, $pesanisi);
            return redirect()->to('/peserta/sertifikat');
        }
    }
}
