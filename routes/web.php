<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
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

Route::get('/', [HomeController::class, 'home']);
Route::get('/city/{id}', [CityController::class, 'home']);

Route::get('/page/{id}', [PageController::class, 'home']);

Route::get('/image', [HomeController::class, 'image']);

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');