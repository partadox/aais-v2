<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Absensi extends BaseController
{
    public function index()
    {
        if ($this->request->isAJAX()) {

            $user           = $this->userauth(); // Return Array
            $absen_peserta_id     = $this->request->getVar('data_absen');
            $kelas_id             = $this->request->getVar('kelas_id');

            $data_absen_peserta   = $this->absen_peserta->find($absen_peserta_id);
            $data_kelas           = $this->kelas->list_detail_kelas($kelas_id);

            $data = [
                'title'             => 'Absensi Peserta Kelas ' . $data_kelas[0]['nama_kelas'],
                'detail_kelas'      => $data_kelas,
                'tm1'               => $data_absen_peserta ['tm1'],
                'tm2'               => $data_absen_peserta ['tm2'],
                'tm3'               => $data_absen_peserta ['tm3'],
                'tm4'               => $data_absen_peserta ['tm4'],
                'tm5'               => $data_absen_peserta ['tm5'],
                'tm6'               => $data_absen_peserta ['tm6'],
                'tm7'               => $data_absen_peserta ['tm7'],
                'tm8'               => $data_absen_peserta ['tm8'],
                'tm9'               => $data_absen_peserta ['tm9'],
                'tm10'              => $data_absen_peserta ['tm10'],
                'tm11'              => $data_absen_peserta ['tm11'],
                'tm12'              => $data_absen_peserta ['tm12'],
                'tm13'              => $data_absen_peserta ['tm13'],
                'tm14'              => $data_absen_peserta ['tm14'],
                'tm15'              => $data_absen_peserta ['tm15'],
                'tm16'              => $data_absen_peserta ['tm16'],
            ];

            $msg = [
                'sukses' => view('panel_peserta/absensi/index', $data)
            ];
            echo json_encode($msg);
        }

    }
}