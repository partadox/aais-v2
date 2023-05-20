<?php

namespace App\Controllers;

use App\Libraries\JWTCI4;

use CodeIgniter\Controller;
use GuzzleHttp\Client;

class Auth extends BaseController
{
    
	public function login()
	{
		helper('cookie');
        if (!get_cookie('gem')) {
			$data = [
				'title' => 'Login',
                'site_key' 	=> getenv('recaptchaKey'),
			];
			return view('auth/login',$data);
		} else {
			$token  = get_cookie('gem');
			$jwt    = new JWTCI4;
			$verifiy= $jwt->parseweb($token);
			if( !$verifiy['success'] )
			{
				delete_cookie('gem');
				$data = [
					'title'     => 'Login',
                    'site_key' 	=> getenv('recaptchaKey'),
				];
				return view('auth/login',$data);
				
			} else {
				return redirect()->to('dashboard');
			}
		}
	}

    private function validateRecaptcha($responseToken, $secretKey, $scoreThreshold)
    {
        
        $client = new \GuzzleHttp\Client();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $secretKey,
                'response' => $responseToken
            ]
        ]);
        
        $responseData = json_decode($response->getBody(), true);
        
        return $responseData['success'] && $responseData['score'] >= $scoreThreshold;
    }

	public function dologin()
	{
		if( !$this->validate([
			'username' 	=> 'required',
			'password' 	=> 'required',
		]))
		{
			return $this->response->setJSON(
                [
                    'success' => false,
                    'code'    => '422',
                    'data'    => null, 
                    'message' => 'Username dan Password Harus Terisi.'
                ]);
		}
		$user       = $this->user->where('username', $this->request->getVar('username'))->first();
		if( $user )
		{
            $secretKey      = getenv('recaptchaSecret');
            $scoreThreshold = getenv('recaptchaThreshold');

             // validate reCAPTCHA
             $responseToken = $this->request->getVar('g-recaptcha-response');
            
             if (password_verify($this->request->getVar('password'), $user['password']) && $this->validateRecaptcha($responseToken, $secretKey, $scoreThreshold)) {
                $uid        = $user['user_id'];
                $rle        = $user['level'];
                $ofc        = 'Pusat';
                $atv        = $user['active'];
                $jwt        = new JWTCI4;
                $token      = $jwt->token($uid,$rle,$ofc,$atv);
                
                $exp        = 60 * 60 * 24 * 1; // in second (60 * 60 * 24 * 30) (86.400 = 1day)
                $remember   = $this->request->getVar('remember');
                if ($remember == 1) {
                    $exp        = 60 * 60 * 24 * 2; // 7day
                }
                set_Cookie('gem',$token,$exp);
                return $this->response->setJSON( 
                [
                    'success' => true,
                    'code'    => '200',
                    'data'    => [
                        'link' => 'dashboard',
                        'icon' => 'success',
                    ], 
                    'message' => 'Berhasil, Redirect...',  
                ]);
                

             } else {
                return $this->response->setJSON( 
                    [
                        'success' => true,
                        'code'    => '200',
                        'data'    => [
                            'link' => 'login',
                            'icon' => 'warning',
                        ], 
                        'message' => 'Password Salah atau Invalid Captcha Token, Refresh Page...',  
                    ]);
             }
			
		}else{

			return $this->response->setJSON( 
                [
                    'success' => false,
                    'code'    => '403',
                    'data'    => null, 
                    'message' => 'Username Salah.', 
                    ]);
		}
		
		
	}

    public function logout()
    {
        if ($this->request->isAJAX()) {

            set_cookie('gem','logout');

            $response = [
                'success' => true,
                'code'    => '200',
                'data'    => [
                    'link' => '/'
                ], 
                'message' => 'Berhasil, Redirect...', 
            ];

            echo json_encode($response);
        }
        
    }
	
}
