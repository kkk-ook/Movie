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
    //item
    Route::prefix('items')->group(function () {
        Route::get('/', [App\Http\Controllers\ItemController::class, 'index']);
        Route::get('/add', [App\Http\Controllers\ItemController::class, 'add']);
        Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    
        Route::get('/detail/{id}', [App\Http\Controllers\ItemController::class, 'detail'])->name('detail');
    });
    
  });
  
/*管理者以上*/
  Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
      //ユーザー一覧
      Route::get('/users', [App\Http\Controllers\UserController::class, 'users'])->name('users');
      Route::get('/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('edit');
      Route::post('/userEdit', [App\Http\Controllers\UserController::class, 'userEdit'])->name('userEdit');
      Route::get('/userDelete/{id}', [App\Http\Controllers\UserController::class, 'userDelete'])->name('userDelete');

  });