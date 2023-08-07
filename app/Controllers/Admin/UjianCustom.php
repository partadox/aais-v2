<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class UjianCustom extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        //Angkatan
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('program', $params) && array_key_exists('angkatan', $params) ) {
            $modul              = 'Filter';
            $program_id         = $params['program'];
            $angkatan           = $params['angkatan'];
        } else {
            $modul              = '';
            $program_id         = NULL;
            $angkatan           = NULL;
        }
        
        $list_angkatan      = $this->kelas->list_unik_angkatan();
        $list_program_uc    = $this->program->list_ujian_custom();

        if ($angkatan != NULL) {
            $angkatan_title     = ' Angkatan Perkuliahan '. $angkatan;
        } else {
            $angkatan_title     = '';
        }
        
        $data = [
            'title'             => 'Data Ujian Custom' . $angkatan_title,
            'user'              => $user,
            'modul'             => $modul,
            'list_angkatan'     => $list_angkatan,
            'angkatan'          => $angkatan,
            'program_id'        => $program_id,
            'list_program_uc'   => $list_program_uc,
        ];
        return view('panel_admin/ujian_custom/index', $data);
    }

    public function modal()
    {
        if ($this->request->isAJAX()) {

            $ucv_id        = $this->request->getVar('ucv_id');
            $program_id    = $this->request->getVar('program_id');
            $peserta_kelas_id= $this->request->getVar('peserta_kelas_id');

            $ucv           = $this->ujian_custom_value->find($ucv_id);
            $peserta       = $this->peserta->find($ucv['ucv_peserta_id']);
            $kelas         = $this->kelas->find($ucv['ucv_kelas_id']);

            $program       = $this->program->find($program_id);
            $ucc           = $this->ujian_custom_config->find($program['ujian_custom_id']);

            $peserta_kelas = $this->peserta_kelas->find($peserta_kelas_id);
            $kelulusan     = $peserta_kelas['status_peserta_kelas'];

            $data = [
                'title'     => 'Data Ujian',
                'ucv'       => $ucv,
                'ucc'       => $ucc,
                'peserta_kelas_id' => $peserta_kelas_id,
                'kelulusan' => $kelulusan,
                'peserta'   => $peserta,
                'kelas'     => $kelas,
            ];
            $msg = [
                'sukses' => view('panel_admin/ujian_custom/modal', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- BACKEND ---*/

    public function filter()
    {
        $angkatan      = $this->request->getVar('angkatan'); 
        $program       = $this->request->getVar('program');

        $queryParam = 'angkatan=' . $angkatan . '&program=' . $program;

        $newUrl = '/ujian-custom?' . $queryParam; 

        return redirect()->to($newUrl);
    }

    public function list()
    {
        if ($this->request->isAJAX()) {
            $angkatan      = $this->request->getVar('angkatan'); 
            $program_id    = $this->request->getVar('program');

            $program       = $this->program->find($program_id);
            $nama_program  = $program['nama_program'];

            $data = [
                'title'         => 'Data Kedatangan',
                'modul'	        => 'Filter',
                'angkatan'      => $angkatan,
                'program_id'    => $program_id,
                'nama_program'  => $nama_program
            ];
            $msg = [
                'data' => view('panel_admin/ujian_custom/list', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function fetch()
    {
        if ($this->request->isAJAX()) {
            $angkatan      = $this->request->getVar('angkatan'); 
            $program_id    = $this->request->getVar('program');

            $lists 		= $this->peserta_kelas->get_datatables($angkatan, $program_id);
            $data 		= [];
            $no 		= $this->request->getPost('start');


            foreach ($lists as $list) {
                $no++;

                $btn_info = "<button type=\"button\" class=\"btn btn-sm btn-info mb-2 mr-2\" onclick=\"info('$list->ucv_id', '$list->program_id', '$list->peserta_kelas_id')\" ><i class=\" fa fa-arrow-circle-right\"></i> Data Ujian</button>";

                $kelulusan = $list->status_peserta_kelas;
                if ($kelulusan == 'BELUM LULUS') {
                    $btn_lulus= "<button type=\"button\" class=\"btn btn-secondary mb-2 mr-2\" disabled> $kelulusan</button>";
                } elseif($kelulusan == 'LULUS') {
                    $btn_lulus= "<button type=\"button\" class=\"btn btn-success mb-2 mr-2\" disabled> $kelulusan</button>";
                } elseif($kelulusan == 'MENGULANG') {
                    $btn_lulus= "<button type=\"button\" class=\"btn btn-warning mb-2 mr-2\" disabled> $kelulusan</button>";
                }
                
                $row_action = $btn_info;

                $row = [];

                $row[] = $no;
				$row[] = $list->nis;
                $row[] = $list->nama_peserta;
                $row[] = $list->jenkel;
                $row[] = $list->nama_kelas;
                $row[] = $list->angkatan_kelas;
                $row[] = $list->nama_pengajar;
                $row[] = $list->hari_kelas;
                $row[] = $list->waktu_kelas . ' ' . $list->zona_waktu_kelas;
                $row[] = $btn_lulus;
                $row[] = $row_action;

                $data[] = $row;
            }
            $output = [
                "recordTotal"     => $this->peserta_kelas->count_all(),
                "recordsFiltered" => $this->peserta_kelas->count_filtered(),
                "data"            => $data,
            ];
            echo json_encode($output);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {

            $ucv_id = $this->request->getVar('ucv_id');

            for ($i = 1; $i <= 10; $i++) {
                $var_text = 'ucv_text' . $i;
                $var_int = 'ucv_int' . $i;

                $variabel[] = array(
                        $var_text => $this->request->getVar($var_text),
                        $var_int => $this->request->getVar($var_int),
                );
            }

            $saveData = [];
            for ($i = 1; $i <= 10; $i++) {
                $textStatusKey = "ucv_text{$i}";
                $intStatusKey = "ucv_int{$i}";

                $saveData[$textStatusKey] = $variabel[$i - 1][$textStatusKey] ?? null;
                $saveData[$intStatusKey] = $variabel[$i - 1][$intStatusKey] ?? null;
            }

            $this->ujian_custom_value->update($ucv_id, $saveData);

            $update_status= [
                'status_peserta_kelas'   => $this->request->getVar('status_peserta_kelas'),
            ];
            $peserta_kelas_id   = $this->request->getVar('peserta_kelas_id');
            $this->peserta_kelas->update($peserta_kelas_id, $update_status);

            $peserta_id     = $this->request->getVar('peserta_id');
            $peserta        =  $this->peserta->find($peserta_id);

            $aktivitas = 'Ubah Data Ujian Custom, NIS : ' .   $peserta['nis'] .  ' Nama : '. $peserta['nama_peserta'];
            $this->logging('Admin', 'BERHASIL', $aktivitas);

            $msg = [
                'sukses' => [
                    'link' => '/ujian-custom?angkatan='.$this->request->getVar('angkatan').'&program='.$this->request->getVar('program')
                ]
            ];
            
            echo json_encode($msg);
        }
    }

}