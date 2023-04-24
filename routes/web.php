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
    //ホーム
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'timeline'])->name('timeline');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'timeline'])->name('timeline');

    //作品一覧
    Route::get('/items', [App\Http\Controllers\ItemController::class, 'items'])->name('items');
    //詳細画面
    Route::get('/detail/{id}', [App\Http\Controllers\ItemController::class, 'detail'])->name('detail');
    //プロフィール編集
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::post('/profileEdit', [App\Http\Controllers\UserController::class, 'profileEdit'])->name('profileEdit');
    Route::get('/profileDelete', [App\Http\Controllers\UserController::class, 'profileDelete'])->name('profileDelete');
    //検索
    Route::get('/itemSearch', [App\Http\Controllers\ItemController::class, 'itemSearch'])->name('itemSearch');
    Route::get('/reviewSearch', [App\Http\Controllers\ItemController::class, 'reviewSearch'])->name('reviewSearch');
    Route::post('/search', [App\Http\Controllers\ItemController::class, 'type'])->name('type');
    //レビュー
    Route::get('/review', [App\Http\Controllers\ItemController::class, 'reviewShow'])->name('review');
    Route::post('/review', [App\Http\Controllers\ItemController::class, 'review'])->name('review');
});

/*管理者以上*/
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    //ユーザー一覧
    Route::get('/users', [App\Http\Controllers\UserController::class, 'users'])->name('users');
    Route::get('/userShow/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('userShow');
    Route::post('/userEdit/{id}', [App\Http\Controllers\UserController::class, 'userEdit'])->name('userEdit');
    Route::post('/userDelete/{id}', [App\Http\Controllers\UserController::class, 'userDelete'])->name('userDelete');
    //検索
    Route::get('/userSearch', [App\Http\Controllers\UserController::class, 'userSearch'])->name('userSearch');
    //作品登録
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'itemAdd'])->name('itemAdd');
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'itemCreate'])->name('itemCreate');
    //作品編集
    Route::get('/itemShow/{id}', [App\Http\Controllers\ItemController::class, 'show'])->name('itemShow');
    Route::get('/itemEdit/{id}', [App\Http\Controllers\ItemController::class, 'itemEdit'])->name('itemEdit');
    Route::post('/itemDelete/{id}', [App\Http\Controllers\ItemController::class, 'itemDelete'])->name('itemDelete');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'pagi']);

});
Route::get('getMovie', [App\Http\Controllers\ItemController::class, 'getMovie']);
Route::get('test', [App\Http\Controllers\ItemController::class, 'test']);
