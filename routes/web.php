<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiddingController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

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

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
	Route::resource('user', UserController::class);
	Route::resource('organization', OrganizationController::class);
	Route::resource('organization.person', PersonController::class);
	Route::get('/', function () {
		$page = new \stdClass;
		$page->menu = '';
		$page->breadcrumbs = [];
	    return view('welcome', ['page' => $page]);
	})->name('dashboard');

});

