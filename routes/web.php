<?php

use Illuminate\Support\Facades\Route;
// controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BookManController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\PublishersController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// root - welcome page
Route::get('/welcome', function () { return view('welcome'); });

// starting page - home page, initially
Route::get('/', [ HomeController::class, 'index' ]);

// authors
Route::get('/authors', [AuthorsController::class, 'index']); // show all
Route::get('/authors/add', function () { return view('authors.add'); }); // return view - add new
Route::get('/author/{id}', [AuthorsController::class, 'indexid']); // show by id
Route::post('/author/ins', [AuthorsController::class, 'insert']); // insert / add new
Route::post('/author/update', [AuthorsController::class, 'updt']); // update
//Route::get('/author/del/{id}', [AuthorsController::class, 'dele']); // delete via get - deprecated
Route::post('/author/dele', [AuthorsController::class, 'delz']); // delete via js post request

// published books
Route::get('/books', [BooksController::class, 'index']);
Route::post('/books', [BooksController::class, 'index']);
Route::get('/book/{title}', [BooksController::class, 'indexid']); // show by id
Route::get('/books/add', [BooksController::class, 'indexAdd']); // add new book
Route::get('/books/addc/{id}', [CartController::class, 'addc']); // add book to cart
Route::post('/book/update', [BooksController::class, 'updt']);
Route::post('/book/ins', [BooksController::class, 'insert']);
//Route::delete('/book/del/{title}', [BooksController::class, 'dele']);
Route::get('/book/del/{id}', [BooksController::class, 'deleb']); // delete book
Route::get('/book/dela/{id}/book/{bk}', [BooksController::class, 'delea']); // delete author

// books ( manage books )
Route::get('/manBooks', [BookManController::class, 'index']);
Route::get('/mbook/{id}', [BookManController::class, 'indexid']); // show by id
Route::get('/manBooks/add', function () { return view('manBooks.add'); }); // add new
Route::post('/mbook/update', [BookManController::class, 'updt']);
Route::post('/mbook/ins', [BookManController::class, 'insert']);
Route::get('/mbook/del/{id}', [BookManController::class, 'dele']);

// shopping cart
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add']); // add book to cart
Route::post('/cart/del', [CartController::class, 'dele']); // remove book from cart
Route::get('/cart/buy/{status}', [CartController::class, 'buy']);

// publishers
Route::get('/publishers', [PublishersController::class, 'index']);
Route::get('/publisher/{id}', [PublishersController::class, 'indexid']); // show by id
Route::get('/publishers/add', function () { return view('publishers.add'); }); // add new
Route::post('/publisher/update', [PublishersController::class, 'updt']);
Route::post('/publisher/ins', [PublishersController::class, 'insert']);
Route::get('/publisher/del/{id}', [PublishersController::class, 'dele']);
