<?php

use Illuminate\Support\Facades\Route;
// controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\PublishersController;

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

// books
Route::get('/books', [BooksController::class, 'index']);
Route::post('/books', [BooksController::class, 'index']);

// books/id
Route::get('/book/{id}', [BooksController::class, 'indexid']);
Route::post('/book/update', [BooksController::class, 'updt']);
Route::get('/book/add', function () { return view('books.add'); });
Route::post('/book/ins', [BooksController::class, 'insert']);
//Route::delete('/book/del/{id}', [BooksController::class, 'dele']);
Route::get('/book/del/{id}', [BooksController::class, 'dele']);

// authors
Route::get('/authors', [AuthorsController::class, 'index']);

// authors/id
Route::get('/author/{id}', [AuthorsController::class, 'indexid']);
Route::post('/author/update', [AuthorsController::class, 'updt']);
Route::get('/author/add', function () { return view('authors.add'); });
Route::post('/author/ins', [AuthorsController::class, 'insert']);
Route::get('/author/del/{id}', [AuthorsController::class, 'dele']);

// publishers
Route::get('/publishers', [PublishersController::class, 'index']);

// publishers/id
Route::get('/publisher/{id}', [PublishersController::class, 'indexid']);
Route::post('/publisher/update', [PublishersController::class, 'updt']);
Route::get('/publisher/add', function () { return view('publishers.add'); });
Route::post('/publisher/ins', [PublishersController::class, 'insert']);
Route::get('/publisher/del/{id}', [PublishersController::class, 'dele']);
