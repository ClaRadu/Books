<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// <todo> add/update/delete

class BooksController extends Controller
{
	protected $books, $tst;
	
	
	// create a new controller instance
	public function __construct() {
		$this->books = null;
		$this->tst = false;
	}
	
	// list all the entries in the address book
	public function index(Request $request) {
		// check the request method
		if ($this->tst) { // testing purposes only
			if ($request->isMethod('post')) { echo '*** post request<br>'; }
			else { echo '*** wait for it..get request<br>'; }
		}
		
		// get all data
		$books = DB::table('books')
					->leftJoin('publishers', 'books.publisher_id', '=', 'publishers.id')
					->get();
		
		return view('books.index', [ 'books' => $books ]);
		// return element(s) corresponding to the selected user
//		return view('books.index', [ 'books' => $this->books->forUser($request->user()), ]);
	}
	
	// list by id
	public function indexid(Request $request, $id) {
		// get data by the specified id
		$books = DB::table('books')->where('ID', '=', $id)->get();
		
		return view('books.index', [ 'books' => $books ]);
	}
	
	// add new data
	public function add() { return view('books.add'); }
	
	// delete an entry
	public function dele(Request $request, $id) {
		// first, delete the id
		DB::table('books')->where('ID', '=', $id)->delete();
		
		// now, call the index function
		$this->index($request);
	}
	
}
