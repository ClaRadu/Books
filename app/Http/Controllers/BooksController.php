<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
	protected $books, $tst, $appn;
	
	// create a new controller instance
	public function __construct() {
		$this->books = null;
		$this->tst = false;
		$hc = new HomeController();
		$this->appn = $hc->getName();
	}
	
	// list all the entries in the address book
	public function index(Request $request) {
		// check the request method
		if ($this->tst) { // testing purposes only
			if ($request->isMethod('post')) { echo '* post request<br>'; }
			else { echo '* wait for it..get request<br>'; }
		}
		
		// get all data from books table and join with authors and publisers tables
		$books = DB::table('bookpub')->orderBy('book_id')->orderBy('publisher_id')
					->leftJoin('authors', 'bookpub.author_id', '=', 'authors.id')
					->leftJoin('books', 'bookpub.book_id', '=', 'books.id')
					->leftJoin('publishers', 'bookpub.publisher_id', '=', 'publishers.id')
					->get();
					
		// get all data from cart table
		$cart = DB::table('cart')->get();
		
		// return element(s) corresponding to the selected user - for registered users
//		return view('books.index', [ 'books' => $this->books->forUser($request->user()), ]);
		// return element(s)
		return view( 'books.index', [ 'books' => $books, 'cart' => $cart ] );
	}
	
	// list by id
	public function indexid(Request $request, $title) {
		// get required data
		$books = DB::table('bookpub')->where('title', '=', $title)->orderBy('title')
					->leftJoin('authors', 'bookpub.author_id', '=', 'authors.id')
					->leftJoin('books', 'bookpub.book_id', '=', 'books.id')
					->leftJoin('publishers', 'bookpub.publisher_id', '=', 'publishers.id')
					->get();
		// sele all from table publishers
		$publishers = DB::table('publishers')->get();
		// sele all from table authors
		$authors = DB::table('authors')->get();
		
		return view('books.update', [ 'books' => $books, 'publishers' => $publishers, 'authors' => $authors ]);
	}
	
	// list authors and publishers for the 'add' function
	public function indexAdd(Request $request) {
		// sele all from table publishers
		$publishers = DB::table('publishers')->get();
		// sele all from table authors
		$authors = DB::table('authors')->get();
		// sele all from table books
		$books = DB::table('books')->orderBy('ID')->get();
		
		// get all data from bookpub table
		$bookp = DB::table('bookpub')->orderBy('book_id')->get();
		// make sure we only return unique values
		$bookpub = $bookp->unique('book_id');
		
		return view('books.add', [ 'publishers' => $publishers, 'authors' => $authors, 'books' => $books, 'bookpub' => $bookpub ]);
	}
	
	// add new data
	public function insert(Request $request) {
		// retrieve the value(s)
		$bkid = $request->input('books');
		$title = $request->input('btitle');
		$price = $request->input('bprice');
		$pubId = $request->input('publishers');
//		$authId = $request->input('authors');
		$authlst = $request->input('lstAuId');
		// make sure we send sane values
		if (empty($price)) { $price = 1.0; }
		$price = floatval($price);
		
		// get array of IDs from the string
		$alst = explode('#', $authlst);
		if ($bkid > 0) { // value selected
			// add data from selectbox
			$this->insertBookPub($alst, $bkid, $pubId); // add new entry in 'bookpub' table
		} else { // id is probably 0 which means nothing has been selected
			// add data from the textbox
			if (!empty($title) && strtoupper($title) !== 'EDIT') { // but only if data is valid
				// add new entry in 'books' table
				$bks = $this->insertBooks($title, $price);
				// add new entries in 'bookpub' table
				$this->insertBookPub($alst, $bks[0]->ID, $pubId);
			}
		}
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// add new data in `books` table
	private function insertBooks($title, $price) {
		// add new entry
		DB::table('books')->insert([ 'title' => $title, 'price' => $price ]);
		// get data from the newly added element
		$book = DB::table('books')->where('title', '=', $title)->get();
		
		return $book;
	}
	
	// add new data in `bookpub` table
	private function insertBookPub($lstAuthors, $idbook, $idpub) {
		foreach ($lstAuthors as $id) {
			if (strval($id) > 0 && $idbook > 0) {
				// add new entry
				DB::table('bookpub')->insert([ 'book_id' => $idbook, 'publisher_id' => $idpub, 'author_id' => $id ]);
			}
		}
	}
	
	// update data
	public function updt(Request $request) {
		// retrieve the value(s)
		$title = $request->input('btitle');
		$prevtitle = $request->input('bprevtitle');
		$bkid = $request->input('bkid');
		$price = $request->input('bprice');
		$pubId = $request->input('publishers');
		$prevpid = $request->input('prevpub');
		$authlst = $request->input('lstAuId');
		// make sure we send sane values
		$price = floatval($price);
		if (empty($title)) { $title = $prevtitle; }
		
		// in `books` table
		// check if current data needs to be updated
		if ($title != $prevtitle) { // yah
			DB::table('books')
				->where('ID', $bkid)
				->update( array('title' => $title, 'price' => $price) );
		} else { // nope, but update price anyway
			DB::table('books')
				->where('ID', $bkid)
				->update( array('price' => $price) );
		}
		
		// in `bookpub` table
		// add new author(s) - if the case
		$alst = explode('#', $authlst);
		foreach($alst as $aid) {
			if (strval($aid)>0) {
				DB::table('bookpub')->insert([ 'book_id' => $bkid, 'publisher_id' => $pubId, 'author_id' => $aid ]);
			}
		}
		// update publishers - if the case
		if ($prevpid != $pubId) {
			DB::table('bookpub')
				->where('book_id', $bkid)
				->update( array('publisher_id' => $pubId) );
		}
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// delete author
	public function delea(Request $request, $id, $bk) {
		// count the number of records the book has
		$cntRows = DB::table('bookpub')->where('book_id', '=', $bk)->count();
		// if only 1 record found then delete the book from the cart table
		if ($cntRows == 1) {
			DB::table('cart')->where('book_id', '=', $bk)->delete();
		}
		// always delete the entry from the bookpub table
		DB::table('bookpub')->where([ ['book_id', '=', $bk], ['author_id', '=', $id] ])->delete();
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
	// delete book
	public function deleb(Request $request, $id) {
		// delete entry from books table - this was only needed in prev. version
//		DB::table('books')->where('ID', '=', $id)->delete();
		// and from bookpub table
		DB::table('bookpub')->where('book_id', '=', $id)->delete();
		// also delete from cart ( only published books can be bought )
		DB::table('cart')->where('book_id', '=', $id)->delete();
		
		// redirect to root
		return view('home', [ 'appnm' => $this->appn ]);
	}
	
}
