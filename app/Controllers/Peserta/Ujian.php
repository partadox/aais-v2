<?php
namespace App\Controllers\Peserta;

use App\Controllers\BaseController;

class Ujian extends BaseController
{
    public function index()
    {
        if ($this->request->isAJAX()) {

            $ujian_id             = $this->request->getVar('data_ujian');
            $kelas_id             = $this->request->getVar('kelas_id');
            $peserta_kelas_id     = $this->request->getVar('peserta_kelas_id');
            $peserta_kelas        = $this->peserta_kelas->find($peserta_kelas_id);
            $kelas                = $this->kelas->find($kelas_id);
            $program              = $this->program->find($kelas['program_id']);
            $ucc                  = NULL;
            $pengajar             = $this->pengajar->find($kelas['pengajar_id']);
            if ($program['ujian_custom_status'] == '1') {
                $ucc              = $this->ujian_custom_config->find($program['ujian_custom_id']); 
                $dataujian        = $this->ujian_custom_value->find_with_ujianid($ujian_id);
                $ujian            = $dataujian[0];
            } else {
                $ujian            = $this->ujian->find($ujian_id);
            }
            $data = [
                'title'             => 'Hasil Ujian',
                'kelas'             => $kelas,
                'kelulusan'         => $peserta_kelas['status_peserta_kelas'],
                'ujian_status'      => $program['ujian_custom_status'],
                'nama_pengajar'     => $pengajar['nama_pengajar'],
                'ucc'               => $ucc,
                'ujian'             => $ujian,
                'program'           => $program,
            ];
            $msg = [
                'sukses' => view('panel_peserta/ujian/index', $data)
            ];     
            echo json_encode($msg);
        }

    }
}