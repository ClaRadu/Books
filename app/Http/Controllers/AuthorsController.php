<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;

class AuthorsController extends Controller
{
    protected $authors, $appn;
	
	// create a new controller instance
	public function __construct() { 
		$this->authors = null;
		$hc = new HomeController();
		$this->appn = $hc->getName();
	}
	
	// list all entries
	public function index(Request $request) {
		// get all data
		$this->authors = DB::table('authors')->get();
		
		return view('authors.index', [ 'authors' => $this->authors ]);
	}
	
	// list by id
	public function indexid(Request $request, $id) {
		// get data by the specified id
		$this->authors = DB::table('authors')->where('id', '=', $id)->get();
		
		return view('authors.update', [ 'authors' => $this->authors ]);
	}
	
	// add new data
	public function insert(Request $request) {
		// retrieve the value(s)
		$fname = $request->input('afname');
		$lname = $request->input('alname');
		// last name can be left clear ( in case Cher or Shakira are being added to the table )
		if (empty($lname) || strtoupper($lname) === 'EDIT') { $lname = ''; }
		
		// add new entry
		if (!empty($fname) && strtoupper($fname) !== 'EDIT') { DB::table('authors')->insert([ 'first_name' => $fname, 'last_name' => $lname ]); }
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// update data
	public function updt(Request $request) {
		// retrieve the value(s)
		$id = $request->input('aid');
		$fname = $request->input('afname');
		$lname = $request->input('alname');
		// make sure we send sane values
		if (empty($lname)) { $lname = ''; }
		
		// update data
		if (!empty($id) && !empty($fname)) {
			DB::table('authors')
				->where('id', $id)
				->update(array('first_name' => $fname, 'last_name' => $lname));
		}
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// delete an entry ( get ) - not used right now -
	public function dele(Request $request, $id) {
		// first, delete element by id
		DB::table('authors')->where('id', '=', $id)->delete();
		// also delete from bookpub table
		DB::table('bookpub')->where('author_id', '=', $id)->delete();
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// deleting via post
	public function delz(Request $request) {
		// retrieve the value(s)
		$id = $request->input('idz');
		$author = $request->input('fullname');
		
		// first, delete element by id
		DB::table('authors')->where('id', '=', $id)->delete();
		// also delete from bookpub table
		DB::table('bookpub')->where('author_id', '=', $id)->delete();
		// clear cart table to avoid a situation where a book that isn't available remains in cart
		DB::table('cart')->delete();
		
		// return delete message
		return view('authors.msg', [ 'delAuth' => $author ]);
	}
}
