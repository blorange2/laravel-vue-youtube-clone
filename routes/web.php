<?php

use App\Http\Controllers\ChannelSettingsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoUploadController;
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
    Route::get('upload', [VideoUploadController::class, 'index'])->name('video-uploads.index');
    Route::post('upload', [VideoUploadController::class, 'store'])->name('video-uploads.store');

    Route::get('videos', [VideoController::class, 'index'])->name('videos.index');
    Route::post('videos', [VideoController::class, 'store'])->name('videos.store');
    Route::get('videos/{video}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('videos/{video}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('videos/{video}', [VideoController::class, 'delete'])->name('videos.delete');

    Route::get('channel/{channel}/edit', [ChannelSettingsController::class, 'edit'])->name('channels.edit');
    Route::patch('channel/{channel}', [ChannelSettingsController::class, 'update'])->name('channels.update');
});
