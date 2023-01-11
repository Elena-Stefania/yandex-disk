<?php

use App\Http\Controllers\Disk\GetFileController;
use App\Http\Controllers\Disk\GetFolderController;
use App\Http\Controllers\Disk\GetFolderListController;
use App\Http\Controllers\Disk\UploadFileController;
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

Route::get('/', GetFolderController::class)->name('folder');
Route::get('/folder-list', GetFolderListController::class)->name('folder.list');
Route::post('/upload-file', UploadFileController::class)->name('upload.file');
Route::get('/get-file', GetFileController::class)->name('get.file');
