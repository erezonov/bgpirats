<?php

use App\Http\Controllers\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KickstarterController as KickstarterController;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => ['guest']], function () {
    /**
     * Register Routes
     */
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', '\App\Http\Controllers\Auth\RegisterController@register')->name('register.perform');
//
    /**
     * Login Routes
     */
    Route::get('/login', '\App\Http\Controllers\Auth\LoginController@show')->name('login.show');
    Route::post('/login', '\App\Http\Controllers\Auth\LoginController@login')->name('login');

});
Route::post('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::group(['prefix' => 'auth', 'as' => 'auth'], function () {
    Auth::routes();

});
Route::group(['prefix' => '/admin', 'as' => 'admin', 'name' => 'admin'], function () {
    Route::group(['prefix' => '/kickstarter', 'as' => 'kickstarter'], function () {
        Route::get('/', [KickstarterController::class, 'showKickstarter'])->name('admin');
        Route::get('/add', [KickstarterController::class, 'addKickstarter'])->name('addKick');
        Route::get('/view/{id}', [KickstarterController::class, 'viewKickstarter'])->name('viewKick');

        Route::post('/save', [KickstarterController::class, 'saveKickstarter'])->name('save');

        Route::group(['prefix' => '/lot', 'as' => 'kickstarter'], function () {
            Route::post('/save', [KickstarterController::class, 'saveLot'])->name('savelot');
            Route::post('/addorder', [KickstarterController::class, 'addToOrder']);
        });
    });

    Route::group(['prefix' => '/orders', 'name' => 'orders.'], function () {
        Route::get('/', [\App\Http\Controllers\OrdersController::class, 'index'])->name('index');
        Route::post('/addtopackage', [\App\Http\Controllers\OrdersController::class, 'addToPackage'])
            ->name('addtopackage');
    });
    Route::group(['prefix' => '/packages', 'name' => 'packages.'], function () {
        Route::get('/', [\App\Http\Controllers\PackageController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\PackageController::class, 'show'])->name('show');
        \Route::post('/save', [PackageController::class, 'save'])->name('savepackages');
    });
    Route::group(['prefix' => '/users', 'name' => 'users.'], function() {
        Route::get('/', [\App\Http\Controllers\UsersController::class, 'showUsers'])->name('index');
    });
});