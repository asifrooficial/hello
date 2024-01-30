<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficerController;

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
// Admin routes
Route::get('/admins-only', [AdminController::class, 'administrate'])->middleware('can:visitAdminPages');
Route::get('/admins-only/search', [AdminController::class, 'searchPlayers'])->middleware('can:visitAdminPages');
Route::post('/admins-only/give-role', [AdminController::class, 'giveThemRole'])->name('give-role')->middleware('can:visitAdminPages');

// User related routes
Route::get('/', [UserController::class, "showCorrectHomepage"])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/logout', [UserController::class, 'logout'])->middleware('mustBeLoggedIn');
Route::get('/manage-avatar', [UserController::class, 'showAvatarForm'])->middleware('mustBeLoggedIn');
Route::post('/manage-avatar', [UserController::class, 'storeAvatar'])->middleware('mustBeLoggedIn');


// Posts related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->middleware('mustBeLoggedIn');
Route::post('/create-post', [PostController::class, 'storeNewPost'])->middleware('mustBeLoggedIn');
Route::get('/post/{post}', [PostController::class, 'viewSinglePost']);
Route::delete('/post/{post}', [PostController::class, 'delete'])->middleware('can:delete,post');
Route::get('/post/{post}/edit', [PostController::class, 'showEditForm'])->middleware('can:update,post');
Route::put('/post/{post}', [PostController::class, 'actuallyUpdate'])->middleware('can:update,post');
Route::post('/profile/requestregear', [PostController::class, 'makeRequest'])->name('makeRequest')->middleware('mustBeLoggedIn');
Route::get('/profile/edit-requests', [PostController::class, 'checkRequest'])->name('checkRequest')->middleware('mustBeLoggedIn');
Route::get('/profile/edit-requests/delete', [PostController::class, 'cancelRequest'])->name('cancelRequest')->middleware('mustBeLoggedIn');
Route::get('/profile/edit-requests/change-tag', [PostController::class, 'changeTag'])->name('changeTag')->middleware('mustBeLoggedIn');


// Profile related routes
Route::get('/profile', [UserController::class, 'profile']);

//Officer related routes
Route::get('/approve-request', [OfficerController::class, 'viewRequests'])->middleware('mustBeLoggedIn');
Route::post('/approve-request', [OfficerController::class, 'processRequests'])->name('processRequests')->middleware('mustBeLoggedIn');
Route::get('/approve-request/search', [OfficerController::class, 'searchRequest'])->name('searchRequest')->middleware('mustBeLoggedIn');