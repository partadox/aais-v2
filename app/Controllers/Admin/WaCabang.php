<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class WaCabang extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Manajemen Session Fitur WA Gateway AAIS Cabang',
            'list'  => $this->wa->list(),
            'user'  => $user,
        ];

        return view('panel_admin/wa/index', $data); 
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $modul = $this->request->getVar('modul');
            if ($modul == "cek") {
                $response = $this->request->getVar('response');
                if ($response == 0) {
                    $status = 0;
                    $statusLog = 'EXPIRED';
                } else {
                    $status = 1;
                    $statusLog = 'AKTIF';
                }
                
                $updatedata = [
                    'status'     => $status,
                    'datetime'   => date('Y-m-d H:i:s'),
                ];

                $id = $this->request->getVar('id');
                $this->wa->update($id, $updatedata);
                $aktivitas = 'Cek session WA Cabang, Status = ' .  $statusLog;
                $this->logging('Admin', 'BERHASIL', $aktivitas);
            } elseif ($modul == "hapus") {
                $updatedata = [
                    'status'     => 0,
                    'datetime'   => date('Y-m-d H:i:s'),
                ];
                $id = $this->request->getVar('id');
                $this->wa->update($id, $updatedata);
                $aktivitas = 'Hapus session WA Cabang';
                $this->logging('Admin', 'BERHASIL', $aktivitas);
                return $this->response->setJSON(
					[
						'success' => true,
						'code'    => '200',
						'data'    => [
							'title' => 'Berhasil',
						],
						'message' => 'Pengisian Form Berhasil.' ,
					]);
            } 
            
        }
    }

}