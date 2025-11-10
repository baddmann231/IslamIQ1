<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import semua komponen Livewire
use App\Livewire\Dashboard;
use App\Livewire\Daftarkuis;
use App\Livewire\Materi;
use App\Livewire\Tentang;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\SejarahNabi;
use App\Livewire\RukunIslam;
use App\Livewire\AkhlakEtika;
use App\Livewire\Admin\Tentang as AdminTentang; // 🟢 penting
use App\Livewire\Admin\Daftarkuis as AdminDaftarkuis; // 🟢 penting
use App\Livewire\Admin\Dashboard as AdminDashboard; // 🟢 penting
use App\Livewire\Admin\Materi as AdminMateri; // 🟢 penting

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (welcome)
Route::get('/', function () {
    return view('welcome');
});

// Logout
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Kamu sudah logout.');
})->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class)->name('admin.dashboard');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/tentang', AdminTentang::class)->name('admin.tentang');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/daftar-kuis', AdminDaftarkuis::class)->name('admin.daftar-kuis');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/materi', AdminMateri::class)->name('admin.materi');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/daftar-kuis', Daftarkuis::class)->name('daftar-kuis');
    Route::get('/materi', Materi::class)->name('materi');
    Route::get('/tentang', Tentang::class)->name('tentang');
    Route::get('/sejarah-nabi', SejarahNabi::class)->name('sejarah-nabi');
    Route::get('/rukun-islam', RukunIslam::class)->name('rukun-islam');
    Route::get('/akhlak-etika', AkhlakEtika::class)->name('akhlak-etika');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');
