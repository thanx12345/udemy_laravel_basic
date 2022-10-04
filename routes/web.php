<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\ShopController;

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

Route::get('tests/test', [ TestController::class, 'index' ]);

Route::get('shops', [ ShopController::class,'index']);

// リソースコントローラの記述：7つのルートが追加できる
// Route::resource('contacts', ContactFormController::class)
//     ->middleware(['auth']);

// リソースを1行ずつ書くならこうなる
Route::get('contacts', [ ContactFormController::class, 'index'])->name('contacts.index'); 

// グループ化してまとめるとシンプルに書ける
Route::prefix('contacts') // 頭に contacts をつける
->middleware(['auth']) // 認証
->name('contacts.') // ルート名
->controller(ContactFormController::class) // コントローラ指定(laravel9から)
->group(function(){ // グループ化
    Route::get('/', 'index')->name('index'); // 名前つきルート
    Route::get('/create', 'create')->name('create'); // create
    Route::post('/', 'store')->name('store'); // DBに保存するからpostメソッド、store
    Route::get('/{id}', 'show')->name('show'); // show
    Route::get('/{id}/edit', 'edit')->name('edit'); // edit
    Route::post('/{id}', 'update')->name('update'); //update
    Route::post('/{id}/destroy', 'destroy')->name('destroy'); //削除
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
