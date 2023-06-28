<?php
namespace App\Controllers;

class Tos extends BaseController
{
	public function tos()
	{
		return view('panel/tos');
	}
	public function privacy()
	{
		return view('panel/privacy');
	}
}