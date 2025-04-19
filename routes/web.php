<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriveController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//middleware('auth')->
Route::prefix('drives/')->name('drives.')->group(function () {
    Route::get('index', [DriveController::class, 'index'])->name("index");
    Route::get('create', [DriveController::class, 'create'])->name("create");
    Route::get('edit/{drive}', [DriveController::class, 'edit'])->name('edit');
    Route::get('destroy/{drive}', [DriveController::class, 'destroy'])->name('destroy');
    Route::post('store', [DriveController::class, 'store'])->name("store");
    Route::post('update/{drive}', [DriveController::class, 'update'])->name("update");
    Route::get('myfiles', [DriveController::class, 'myfiles'])->name('myfiles');
    Route::get('status/{drive}', [DriveController::class, 'statusEdit'])->name('status');
    Route::get('download/{drive}', [DriveController::class, 'download'])->name('download');
    Route::get('allfiles', [DriveController::class, 'allfiles'])->name('allfiles')->middleware('RoleAdmin');
});

Route::prefix('admin/')->name('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'loginPage'])->name('loginPage');
    Route::post('login', [AdminController::class, 'login'])->name('login');
    Route::get('register', [AdminController::class, 'create'])->name('create');
    Route::post('store', [AdminController::class, 'store'])->name('store');
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    });
});
