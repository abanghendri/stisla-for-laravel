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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user',\App\Http\Livewire\User::class)->name('user');
    Route::get('/user/roles',\App\Http\Livewire\User\Roles::class)->name('roles');
    Route::get('/permissions',\App\Http\Livewire\Permissions::class)->name('permissions');
});
