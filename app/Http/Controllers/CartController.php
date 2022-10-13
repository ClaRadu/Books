<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
	protected $cart, $appn;
	
	public function __construct() {
		$this->cart = null;
		$hc = new HomeController();
		$this->appn = $hc->getName();
	}
	
	// calculate total - return 
	private function caltot() {
		$tot = 0;
		foreach ($this->cart as $elem) {
			$tot += $elem->qtty*$elem->price;
		}
		
		return $tot;
	}
	
	// return unique titles from the `bookpub` table
	private function getUniqueBooks() {
		// get all data from bookpub table
		$bookpub = DB::table('bookpub')
					->leftJoin('books', 'bookpub.book_id', '=', 'books.id')
					->orderBy('title')
					->get();
		// make sure we return only unique values
		$books = $bookpub->unique('title');
		
		return $books;
	}
	
	// refresh the data in `cart` table
	private function refreshCart() {
		// get all data from cart table joined with books
		$this->cart = DB::table('cart')
						->leftJoin('books', 'cart.book_id', '=', 'books.id')
						->get();
	}
	
    // show all elements
	public function index(Request $request) {
		// refresh the data in this.cart
		$this->refreshCart();
		
		// get only required data from bookpub table
		$books = $this->getUniqueBooks();

		// calculate total
		$ntot = $this->caltot();
						
		return view('cart.index', [ 'cart' => $this->cart, 'books' => $books, 'total' => $ntot ]);
	}
	
	// add element
	public function add(Request $request) {
		// retrieve the value(s)
		$id = $request->input('bkid');
		$quant = $request->input('bkq');
		$name = $request->input('bkn');
		
		// add new entry
		if (!empty($id) && !empty($quant)) {
			DB::table('cart')->insert([ 'book_id' => $id, 'qtty' => $quant ]);
			// return add message
			return view('cart.msgadd', [ 'bknm' => $name, 'bkqt' => $quant ]);
		} else {
			// return error message
			return view('cart.msgerr', [ 'msg' => 'Could not add ' . $name . ' to cart!' ]);
		}
	}
	
	// add to cart from 'books' page
	public function addc(Request $request, $id) {
		// add new element
		if (strval($id)>0) { DB::table('cart')->insert([ 'book_id' => $id, 'qtty' => 1 ]); }
		
		// refresh the data in this.cart
		$this->refreshCart();
		
		// get only required data from bookpub table
		$books = $this->getUniqueBooks();
		
		// calculate total
		$ntot = $this->caltot();
		
		// redirect to cart
		return view('cart.index', [ 'cart' => $this->cart, 'books' => $books, 'total' => $ntot ]);
	}
	
	// deleting entry by id
	public function dele(Request $request) {
		// retrieve the value(s)
		$id = $request->input('bkid');
		$title = $request->input('bktitle');

		// add new entry
		if (!empty($id)) {
			DB::table('cart')->where('id', '=', $id)->delete();
			// return delete message
			return view('cart.msgdel', [ 'bknm' => $title ]);
		} else {
			// return error message
			return view('cart.msgerr', [ 'msg' => 'Could not delete ' . $title . ' from cart!' ]);
		}
	}
	
	// buy all from cart - processing a payment should go here
	// as it stands: just clean up the cart
	function buy(Request $request, $status) {
		if ($status === 'go') {
			// clean up cart table
			DB::table('cart')->where('id', '>=', 0)->delete();
			// show message
			return view('cart.msgbuy', [ 'appnm' => $this->appn ]);
		} else {
			// return error message
			return view('cart.msgerr', [ 'msg' => 'Could not process the request!' ]);
		}
	}
}
