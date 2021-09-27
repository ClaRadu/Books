<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	protected $tst, $appname;
	
	// create a new controller instance
	public function __construct() {
		$this->tst = false;
		$this->appname = 'Books ( Test practic ) - v.1.0';
	}
	
	public function getName() { return $this->appname; }
	
	public function index() { return view('home', ['appnm' => $this->appname]); }
}
