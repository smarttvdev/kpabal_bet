<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\GeneralSettings;

class AdminController extends Controller
{

	public function __construct(){
		$Gset = GeneralSettings::first();
		$this->sitename = $Gset->sitename;
	}

	public function dashboard(){
		$data['page_title'] = 'DashBoard';
			$data['Gset'] = GeneralSettings::first();
		return view('admin.dashboard', $data);
	}



	public function logout()    {
		Auth::guard('admin')->logout();
		session()->flash('message', 'Just Logged Out!');
		return redirect('/admin');
	}
















}
