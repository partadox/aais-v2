<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$user  = $this->userauth(); // Return Array

		$data = [
			'title' 				=> 'Dashboard',
			'user'  				=> $user,
		];
		return view('panel/dashboard', $data);
	}
}