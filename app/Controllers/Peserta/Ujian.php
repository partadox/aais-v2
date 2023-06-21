<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Ujian extends BaseController
{
    public function index()
    {
        if ($this->request->isAJAX()) {

            $user                 = $this->userauth(); // Return Array
            $ujian_id             = $this->request->getVar('data_ujian');
            $kelas_id             = $this->request->getVar('kelas_id');

            $ujian                = $this->ujian->find($ujian_id);
            $kelas                = $this->kelas->find($kelas_id);

            $data = [
                'title'             => 'Hasil Ujian pada Kelas ' . $kelas['nama_kelas'],
                'kelas'             => $kelas,
                'ujian'             => $ujian,
            ];

            $msg = [
                'sukses' => view('panel_peserta/ujian/index', $data)
            ];
            echo json_encode($msg);
        }

    }
}