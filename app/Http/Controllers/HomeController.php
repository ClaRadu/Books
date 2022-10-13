<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	protected $tst, $appname;
	
	// create a new controller instance
	public function __construct() {
		$this->tst = false;
		$this->appname = 'BookStore - v.1.03';
	}
	
	public function getName() { return $this->appname; }
	
	public function index() { return view('home', ['appnm' => $this->appname]); }
}
