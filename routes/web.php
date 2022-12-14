<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/', [Controllers\ListingController::class, 'index'])
    ->name('listings.index');

Route::match(['get', 'post' ], '/new', [Controllers\ListingController::class, 'store'])
    ->name('listings.store');

Route::get('/dashboard', [Controllers\AdminController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/{listing}',  [Controllers\ListingController::class, 'show'])
    ->name('listings.show');

Route::get('/{listing}/apply', [Controllers\ListingController::class, 'apply'])
    ->name('listings.apply');