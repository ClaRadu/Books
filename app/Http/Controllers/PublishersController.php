<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;

class PublishersController extends Controller
{
    protected $publishers, $appn;
	
	// create a new controller instance
	public function __construct() { 
		$this->publishers = null;
		$hc = new HomeController();
		$this->appn = $hc->getName();
	}
	
	// list all the entries
	public function index(Request $request) {
		// get all data
		$this->publishers = DB::table('publishers')->get();
		
		return view('publishers.index', [ 'publishers' => $this->publishers ]);
	}
	
	// list by id
	public function indexid(Request $request, $id) {
		// get data by the specified id
		$this->publishers = DB::table('publishers')->where('id', '=', $id)->get();
		
		return view('publishers.update', [ 'publishers' => $this->publishers ]);
	}
	
	// testing only
	public function update(Request $request) { return view('publishers.adding'); }
	
	// add new data
	public function insert(Request $request) {
		// retrieve the value(s)
		$name = $request->input('pname');
		
		// add new entry
		if (!empty($name)) { DB::table('publishers')->insert([ 'name' => $name ]); }
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// update data
	public function updt(Request $request) {
		// retrieve the value(s)
		$id = $request->input('pid');
		$name = $request->input('pname');
		
		// update data
		if (!empty($id)) {
			DB::table('publishers')
				->where('id', $id)
				->update(array('name' => $name));
		}
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	
	// delete an entry
	public function dele(Request $request, $id) {
		// first, delete the id
		DB::table('publishers')->where('id', '=', $id)->delete();
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
}
