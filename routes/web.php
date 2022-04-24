<?php

use App\Http\Controllers\ChannelSettingsController;
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

Auth::routes();

// Default home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('channel/{channel}/edit', [ChannelSettingsController::class, 'edit'])->name('channels.edit');
    Route::patch('channel/{channel}', [ChannelSettingsController::class, 'update'])->name('channels.update');
});
