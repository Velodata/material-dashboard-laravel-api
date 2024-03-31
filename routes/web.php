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
// refer to article by https://medium.com/@mark.tabletpc/implementing-oauth2-single-sign-on-sso-in-a-laravel-step-by-step-guide-ab910e26c22a
// Route::get('auth/google', 'App\Http\Controllers\AuthController@redirectToGoogle');
// Route::get('auth/google/callback', 'App\Http\Controllers\AuthController@handleGoogleCallback');