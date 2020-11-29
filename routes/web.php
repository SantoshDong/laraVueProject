<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::any( '(.*)', function( $page ){
//     dd($page);
// });
Route::get('/{any}', function ($any) {
    return view('home');
    // any other url, subfolders also
  
  })->where('any', '.*');
// Route::get('{path}', [App\Http\Controllers\HomeController::class, 'index'])->where( 'path', '([A-z\d-\/_.]+)?' );
