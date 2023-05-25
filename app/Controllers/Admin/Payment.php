<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Payment extends BaseController
{
    public function index()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Pengaturan Metode Pembayaran',
            'list'  => $this->payment->list(),
            'user'  => $user,
        ];

        return view('panel_admin/payment/index', $data); 
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {

            $payment_id = $this->request->getVar('payment_id');
            $payment    =  $this->payment->find($payment_id);
            $data = [
                'title' => 'Ubah payment',
                'payment'  => $payment
            ];
            $msg = [
                'sukses' => view('panel_admin/payment/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- BACKEND ---*/

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'payment_name' => [
                    'label' => 'payment_name',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'payment_name'      => $validation->getError('payment_name'),
                    ]
                ];
            } else {
                if ($this->request->getVar('payment_type') == 'manual') {
                    $update_data = [
                        'payment_name'   => $this->request->getVar('payment_name'),
                        'payment_status' => $this->request->getVar('payment_status'),
                        'payment_bank'   => strtoupper($this->request->getVar('payment_bank')),
                        'payment_rekening'=> $this->request->getVar('payment_rekening'),
                        'payment_atasnama'   => strtoupper($this->request->getVar('payment_atasnama')),
                    ];
                } elseif($this->request->getVar('payment_type') == 'manual') {
                    $update_data = [
                        'payment_name'  => $this->request->getVar('payment_name'),
                        'payment_status'=> $this->request->getVar('payment_status'),
                    ];
                } else {
                    $update_data = [
                        'payment_name'  => $this->request->getVar('payment_name'),
                        'payment_status'=> $this->request->getVar('payment_status'),
                        'payment_price' => $this->request->getVar('payment_price'),
                        'payment_tax'   => $this->request->getVar('payment_tax'),
                    ];
                }
                
                

                $payment_id = $this->request->getVar('payment_id');
                $this->payment->update($payment_id, $update_data);
                $aktivitas = 'Ubah Data Payment : ' .  $this->request->getVar('payment_name');
                $this->logging('Admin', 'BERHASIL', $aktivitas);

                $msg = [
                    'sukses' => [
                        'link' => 'payment-methode'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

}