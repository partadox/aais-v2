<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Log extends BaseController
{
    public function admin()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Log Admin',
            'user'  => $user,
            'list'  => $this->log->list()
        ];
        return view('panel_admin/log/admin', $data); 
    }

    public function user()
    {
        $user  = $this->userauth();
        $data = [
            'title' => 'Log User',
            'user'  => $user,
            'list'  => $this->log_user->list()
        ];
        return view('panel_admin/log/user', $data); 
    }
}