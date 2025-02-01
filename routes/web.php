<?php
// PHP/Laravel 09 Routingについて理解する 課題提出
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

use App\Http\Controllers\Admin\NewsController;
Route::controller(NewsController::class)->prefix('admin')->group(function() {
    Route::get('news/create', 'add');
});

//上記Routing設定の別の書き方
//use App\Http\Controllers\Admin\NewsController;
//Route::controller(NewsController::class)->group(function() {
    //Route::get('admin/news/create', 'add');
//});

//http://XXXXXX.jp/XXX というアクセスが来たときに、 AAAControllerのbbbというAction に渡すRoutingの設定

//use App\Http\controllers\xxx\AAAController;
// Route::controller(AAAController::class)->group(function() {
// Route::get('xxx/aaa', 'bbb')
// })

use App\Http\Controllers\Admin\ProfileController;
Route::controller(ProfileController::class)->prefix('admin')->group(function() {

    //admin/profile/create にアクセスしたら ProfileController の add Actionに割り当てる
    Route::get('profile/create', 'add');
    
    //admin/profile/edit にアクセスしたら ProfileController の edit Action に割り当てる
    Route::get('profilee/edit', 'edit');
});