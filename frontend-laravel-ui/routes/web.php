<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendAuthController;
use App\Http\Controllers\DashboardController;




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

// Route::get('/', function () {
//     return view('mmmmm');
// });
Route::get('/', fn () => redirect('/login'));

Route::get('/login', [FrontendAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [FrontendAuthController::class, 'login']);

Route::get('/register', [FrontendAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [FrontendAuthController::class, 'register']);

Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [FrontendAuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [FrontendAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [FrontendAuthController::class, 'login']);

Route::get('/register', [FrontendAuthController::class, 'showRegister'])->name('register');
// Route::get('/register', function () {
//     return view('This route works!');
// });
// Route::get('/test', function () {
//     return 'web.php is working!';
// });

Route::post('/register', [FrontendAuthController::class, 'register']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/logout', [FrontendAuthController::class, 'logout'])->name('logout');
Route::get('/admin/users', [DashboardController::class, 'adminUsers'])->middleware('web');
Route::post('/admin/users/create', [DashboardController::class, 'createUser']);
Route::delete('/admin/users/delete/{id}', [DashboardController::class, 'deleteUser']);
Route::post('/admin/users/create', [DashboardController::class, 'createUser']);
Route::post('/admin/users/edit/{id}', [DashboardController::class, 'editUser']);
Route::post('/admin/users/delete/{id}', [DashboardController::class, 'deleteUser']);