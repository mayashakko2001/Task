<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
Route::resource('users', AuthController::class);
Route::get('users/{user}', [AuthController::class, 'detailsUser'])->name('users.detailsUser');
Route::delete('deleteUser/{user}', [AuthController::class, 'destroy'])->name('users.destroy');
Route::get('create', [AuthController::class, 'create'])->name('users.addUser');
Route::post('/users', [AuthController::class, 'store'])->name('users.store');
Route::get('/download-pdf/{id}', [AuthController::class, 'downloadPdfperonal_card'])->name('downloadperonal_card.pdf');
Route::get('/download_driving_license_image_front/{id}', [AuthController::class, 'download_driving_license_image_front'])->name('download_driving_license_image_front.pdf');
Route::get('/download_driving_license_image_Back/{id}', [AuthController::class, 'download_driving_license_image_Back'])->name('download_driving_license_image_Back.pdf');
Route::get('search', [AuthController::class, 'search'])->name('users.search');
Route::post('/translate', [AuthController::class, 'translate']);

Route::get('/home', [AuthController::class, 'home'])->name('users.home');

Route::post('/locale', [AuthController::class, 'change'])->name('locale.change');

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');