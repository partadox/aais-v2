<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class WA extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'WA Gateway',
            'list'  => $this->wa_switch->list(),
            'user'  => $user,
        ];

        return view('panel_admin/wa/index', $data); 
    }

    public function wa_input_footer()
    {
        if ($this->request->isAJAX()) {
            $user  = $this->userauth();
            $data = [
                'title' => 'Form Template Footer WA Notif',
                'user'  => $user,
                'wa'    => $this->wa->find(1),
            ];
            $msg = [
                'sukses' => view('panel_admin/wa/footer', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function wa_input_action()
    {
        if ($this->request->isAJAX()) {
            $user  = $this->userauth();
            $code  = $this->request->getVar('code');
            $modul = $this->request->getVar('modul');

            $wa    = $this->wa_switch->find($code);
            $data = [
                'title' => $wa['name'],
                'user'  => $user,
                'wa'    => $wa,
                'modul' => $modul,
            ];
            $msg = [
                'sukses' => view('panel_admin/wa/action', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- BACKEND ---*/

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

             //-------WAG SENDIRI BARU-------
            $apiKey = getenv('WAG_KEY');
            if ($idWA == 1) {
                $url = "https://wag.jlbsd.my.id/session/status/aais-pusat";
            } else {
                $url = "https://wag.jlbsd.my.id/session/status/aais-cabang";
            }
            // Menginisialisasi CURL
            $ch = curl_init($url);

            // Mengatur opsi cURL
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                // CURLOPT_POSTFIELDS => $data, // Mengirim data JSON
                CURLOPT_HTTPHEADER => array(
                    'accept: */*',
                    'x-api-key: ' . $apiKey, // Header x-api-key sesuai dengan perintah cURL di Swagger
                    'Content-Type: application/json'
                ),
            ));

            // Mengeksekusi CURL dan mendapatkan respons
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            if ($response['state'] == "CONNECTED") {
                $status = 1;
            } else {
                $status = 0;
            }
            curl_close($ch);

            #------- WA gateway Fonnte ---------
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://api.fonnte.com/device',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_HTTPHEADER => array(
            //     'Authorization: '.$dataWA['wa_key']
            // ),
            // ));

            // $response = curl_exec($curl);
            // $response = json_decode($response, true);
            // curl_close($curl);

            // if ($response["device_status"] === "connect") {
            //     $status = 1;
            // } else {
            //     $status = 0;
            // }
            #------- END WA gateway Fonnte ---------

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

            #------- WA gateway Sendiri Baru ---------
            $apiKey = getenv('WAG_KEY');
            // Endpoint API
            if ($idWA == 1) {
                $url = "https://wag.jlbsd.my.id/client/sendMessage/aais-pusat";
            } else {
                $url = "https://wag.jlbsd.my.id/client/sendMessage/aais-cabang";
            }
            
            // Data yang akan dikirim
            $data = json_encode([
                "chatId" => $to . "@c.us",
                "contentType"=>"string",
                "content" =>strval("Halo, ini dari WA Gateway pesan tes")
            ]);

            // Menginisialisasi CURL
            $ch = curl_init($url);

            // Mengatur opsi cURL
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data, // Mengirim data JSON
                CURLOPT_HTTPHEADER => array(
                    'accept: */*',
                    'x-api-key: ' . $apiKey, // Header x-api-key sesuai dengan perintah cURL di Swagger
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            curl_close($ch);

            #------- WA gateway Fonnte ---------
            // $countryCode ="62";
            // if (substr($to, 0, 2) == "62" || substr($to, 0, 2) == "08") {
            //     $countryCode ="62";
            // } else {
            //     $countryCode = substr($to, 0, 2);
            // }

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //     CURLOPT_URL => 'https://api.fonnte.com/send',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'POST',
            //     CURLOPT_POSTFIELDS => array(
            //         'target' => $to,
            //         'message' => "Test Kirim Pesan dari WA Gateway", 
            //         'countryCode' => $countryCode, //optional
            //     ),
            //     CURLOPT_HTTPHEADER => array(
            //         'Authorization:'.$dataWA['wa_key'] //change TOKEN to your actual token
            //     ),
            // ));

            // $response = curl_exec($curl);
            // $response = json_decode($response, true);
            // if (curl_errno($curl)) {
            //     $error_msg = curl_error($curl);
            // }
            // curl_close($curl);
            #------- END WA gateway Fonnte ---------

            // if ($response["status"] == true) {
            if ($response["success"] == true) {
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

    public function wa_update_footer()
    {
        if ($this->request->isAJAX()) {
            $footer = $this->request->getVar('footer');
            if ($footer == "") {
                $footer == NULL;
            }
            $update_data = [
                'footer'       => $footer,
            ];
            
            $this->wa->update(1, $update_data);

            $aktivitas = 'Edit Data WA Notif Template Footer';
            $this->logging('Admin', 'BERHASIL', $aktivitas);


            $msg = [
                'sukses' => [
                    'link' => 'wa-gateway'
                ]
            ];
            
            echo json_encode($msg);
        }
    }

    public function wa_update_action()
    {
        if ($this->request->isAJAX()) {
            $code   = $this->request->getVar('code');
            $status = $this->request->getVar('status');
            $wa     = $this->wa_switch->find($code);

            $update_data = [
                'status'       => $status,
            ];

            $this->wa_switch->update($code, $update_data);

            $aktivitas = 'Nonaktif WA Notif pada Fitur '.$wa['name'];
            $this->logging('Admin', 'BERHASIL', $aktivitas);


            $msg = [
                'sukses' => [
                    'link' => 'wa-gateway'
                ]
            ];
            
            echo json_encode($msg);
        }
    }
}