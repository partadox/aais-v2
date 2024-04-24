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

    public function wa_status()
    {
        //id
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        $id           = $params['id'];

        $wa = $this->wa->find($id);
        if ($wa) {
            if ($wa['status'] == 1) {
                $statusShow = "CONNECT";
            }else {
                $statusShow = "DISCONNECT";
            }
            $responseData = [
                'status'        => $wa['status'],
                'statusShow'    => $statusShow,
                'datetime'      => $wa['datetime'],
                'datetimeShow'  => shortdate_indo(substr($wa['datetime'],0,10))." ".substr($wa['datetime'],11,5)." WITA",
                'id'            => $wa['id'],
                'key'           => $wa['wa_key']
            ];
            return $this->response->setJSON($responseData);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Data not found']);
        }
    }

    public function wa_check()
    {
        if ($this->request->isAJAX()) {
            $idWA = $this->request->getVar('idWA');
            $dataWA= $this->wa->find($idWA);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/device',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: '.$dataWA['wa_key']
            ),
            ));

            $response = curl_exec($curl);
            $response = json_decode($response, true);
            curl_close($curl);

            if ($response["device_status"] === "connect") {
                $status = 1;
            } else {
                $status = 0;
            }
            $updatedata = [
                'status'     => $status,
                'datetime'   => date('Y-m-d H:i:s'),
            ];
            $this->wa->update($idWA, $updatedata);
            return $this->response->setJSON(
                [
                    'success' => $status,
                    'code'    => '200',
                    'data'    => [
                        'title' => 'Berhasil',
                    ],
                ]);
        }
    }

    public function wa_test()
    {
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('to', $params)) {
            $to     = $params['to'];
            $idWA   = $this->request->getVar('idWA');
            $dataWA = $this->wa->find($idWA);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $to,
                    'message' => "Test Kirim Pesan dari WA Gateway", 
                    'countryCode' => '62', //optional
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization:'.$dataWA['wa_key'] //change TOKEN to your actual token
                ),
            ));

            $response = curl_exec($curl);
            $response = json_decode($response, true);
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
            }
            curl_close($curl);
            if ($response["status"] == true) {
                return $this->response
                ->setStatusCode(200) // Use setStatusCode for HTTP status code
                ->setJSON([
                    'success' => 1,
                    'message' => 1 ? 'Operation successful.' : 'Operation failed.',
                    'data'    => [
                        'title' => 'Berhasil',
                    ],
                ]);
            } else {
                return $this->response
                ->setStatusCode(200) // Use setStatusCode for HTTP status code
                ->setJSON([
                    'success' => 0,
                    'message' => 0 ? 'Operation successful.' : 'Operation failed.',
                    'data'    => [
                        'title' => 'Gagal',
                    ],
                ]);
            }
            
        } else {
            return $this->response
            ->setStatusCode(400) // Use setStatusCode for HTTP status code
            ->setJSON([
                'success' => 0,
                'message' => 0 ? 'Operation successful.' : 'Operation failed.',
                'data'    => [
                    'title' => 'Berhasil',
                ],
            ]);
        }
    }
}