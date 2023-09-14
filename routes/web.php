<?php

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

Route::get('/',  [App\Http\Controllers\IndexController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\BlogController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {

Route::get('/blogs/create',[App\Http\Controllers\BlogController::class,'create'])->name('blog.create');
Route::post('/blogs/post',[App\Http\Controllers\BlogController::class,'store'])->name('blogs.store');
Route::get('/blogs/{id}/edit',  [App\Http\Controllers\BlogController::class,'edit'])->name('blogs.edit');
Route::put('/blogs/{id}',  [App\Http\Controllers\BlogController::class,'update'])->name('blogs.update');
Route::delete('/blogs/{blog}', [App\Http\Controllers\BlogController::class,'destroy'])->name('blogs.destroy');
Route::get('/blogs/{id}/activate', [App\Http\Controllers\BlogController::class, 'activate'])->name('blogs.activate');
Route::get('/blogs/{id}/deactivate', [App\Http\Controllers\BlogController::class, 'deactivate'])->name('blogs.deactivate');

});