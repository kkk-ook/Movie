<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ItemController;
use \App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();



/*一般ユーザー*/
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    //home
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/detail/{id}', [App\Http\Controllers\ItemController::class, 'detail'])->name('detail');

    //プロフィール編集
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('/profileEdit', [App\Http\Controllers\UserController::class, 'profileEdit'])->name('profileEdit');
    Route::get('/profileDelete', [App\Http\Controllers\UserController::class, 'profileDelete'])->name('profileDelete');
});

/*管理者以上*/
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    //ユーザー一覧
    Route::get('/users', [App\Http\Controllers\UserController::class, 'users'])->name('users');
    Route::get('/userShow/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('userShow');
    Route::get('/userEdit/{id}', [App\Http\Controllers\UserController::class, 'userdit'])->name('userEdit');
    Route::post('/userDelete/{id}', [App\Http\Controllers\UserController::class, 'userDelete'])->name('userDelete');
    Route::get('/userSearch', [App\Http\Controllers\UserController::class, 'userSearch'])->name('userSearch');

    //item
    Route::get('/items', [App\Http\Controllers\ItemController::class, 'items'])->name('items');
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'itemAdd'])->name('itemAdd');
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'itemCreate'])->name('itemCreate');
    Route::get('/itemSearch', [App\Http\Controllers\ItemController::class, 'itemSearch'])->name('itemSearch');
    Route::get('/itemShow/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('itemShow');
    Route::get('/itemEdit/{id}', [App\Http\Controllers\ItemController::class, 'itemEdit'])->name('itemEdit');
    Route::post('/itemDelete/{id}', [App\Http\Controllers\ItemController::class, 'itemDelete'])->name('itemDelete');

});