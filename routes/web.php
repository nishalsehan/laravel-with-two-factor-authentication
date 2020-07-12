<?php

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
    return redirect(route('login.index'));
});

Route::get('/logout', function () {
    if(!isset($_SESSION))
    {
        session_start();
    }

    $_SESSION['auth'] = null;

    return redirect(route('login.index'));
})->name('logout');

Route::resource('login', 'LoginController');
Route::resource('home', 'HomeController');



