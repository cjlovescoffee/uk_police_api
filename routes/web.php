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
    return view('home');
})->name('home');

Route::get('/forces', function () {
    return view('forces');
})->name('forces');

Route::get('/forces/{force}', function ($force) {
    return view('force', ['force' => $force]);
});

Route::get('/forces/{force}/{neighbourhood}', function ($force, $neighbourhood) {
    return view('neighbourhood', ['force' => $force, 'neighbourhood' => $neighbourhood]);
});

Route::get('/reset', function () {
  return view('reset');
})->name('reset');
