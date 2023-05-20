<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JWTCI4;
class LoginFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('cookie');
        if (!get_cookie('gem')) {
			return redirect()->to('login');
		} else {
            $requiredRoles = isset($arguments[0]) ? explode("-", $arguments[0]) : [];
			$token  = get_cookie('gem');
			$jwt    = new JWTCI4;
			$verifiy= $jwt->parseweb($token);
            $decode = $jwt->decodeweb($token);
			if( !$verifiy['success'] || !in_array($decode->rle, $requiredRoles))
			{
				return redirect()->to('404');
			}
		}
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
