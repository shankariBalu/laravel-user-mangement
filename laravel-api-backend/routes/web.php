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
Route::get('/captcha', function () {
    $a = rand(1, 10);
    $b = rand(1, 10);
    session(['captcha_result' => $a + $b]);
    return response()->json(['question' => "$a + $b = ?"]);
});

