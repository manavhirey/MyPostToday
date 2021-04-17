<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostsController;
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
    //return ("Hello World");
});

Route::get('/hello', function () {
    //return view('welcome');
    return ("<H1>Hello World</H1>");
});

/*
Route::get('/about', function () {
    return view('pages.about');
});


Route::get('/user/{id}/{name}', function($id,$name){
   return 'This is User '.$name.' with an id '.$id ; 
});
*/

Route::get('/',[PageController::class,'index']);
Route::get('/about',[PageController::class,'about']);
Route::get('/service',[PageController::class,'services']);

Route::resources([
    'posts' => PostsController::class,
]);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
