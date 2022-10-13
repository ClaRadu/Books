<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;

class BookManController extends Controller
{
     protected $mbooks, $appn;
	
	// create a new controller instance
	public function __construct() { 
		$this->mbooks = null;
		$hc = new HomeController();
		$this->appn = $hc->getName();
	}
	
	// list all the entries
	public function index(Request $request) {
		// get all data
		$this->mbooks = DB::table('books')->get();
		
		return view('manBooks.index', [ 'books' => $this->mbooks ]);
	}
	
	// list by id
	public function indexid(Request $request, $id) {
		// get data by the specified id
		$this->mbooks = DB::table('books')->where('ID', '=', $id)->get();
		
		return view('manBooks.update', [ 'books' => $this->mbooks ]);
	}
	
	// add new data
	public function insert(Request $request) {
		// retrieve the value(s)
		$title = $request->input('btitle');
		$price = $request->input('bprice');		
		// make sure we send sane values
		if ($price === 'edit') { $price = 0; }
		$price = floatval($price);
		
		// add new entry
		if (!empty($title) && $title !== 'edit') { DB::table('books')->insert([ 'title' => $title, 'price' => $price ]); }
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// update data
	public function updt(Request $request) {
		// retrieve the value(s)
		$id = $request->input('bkid');
		$title = $request->input('btitle');
		$prevtitle = $request->input('bprevtitle');
		$price = $request->input('bprice');
		// make sure we send sane values
		$price = floatval($price);
		if (empty($title)) { $title = $prevtitle; }
		
		// update data
		if (!empty($id) && !empty($title)) {
			// check if current data needs to be updated
			if ($title != $prevtitle) { // yah
				DB::table('books')
					->where('ID', $id)
					->update( array('title' => $title, 'price' => $price) );
			} else { // nope, but update price anyway
				DB::table('books')
					->where('ID', $id)
					->update( array('price' => $price) );
			}
		}
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// delete an entry
	public function dele(Request $request, $id) {
		// first, delete by id
		DB::table('books')->where('ID', '=', $id)->delete();
		// also delete from bookpub table
		DB::table('bookpub')->where('book_id', '=', $id)->delete();
		// delete from cart table too
		DB::table('cart')->where('book_id', '=', $id)->delete();
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
}
