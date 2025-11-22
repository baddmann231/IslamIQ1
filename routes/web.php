<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import semua komponen Livewire
use App\Livewire\User\Dashboard;
use App\Livewire\User\DaftarKuis;
use App\Livewire\User\Materi;
use App\Livewire\User\Tentang;
use App\Livewire\User\TakeQuiz;
use App\Livewire\User\QuizResult;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Admin\Tentang as AdminTentang;
use App\Livewire\Admin\DaftarKuis as AdminDaftarKuis;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Materi as AdminMateri;
use App\Livewire\Admin\CreateQuiz;
use App\Livewire\Admin\EditQuiz;
use App\Livewire\Admin\ManageQuestions;
use App\Livewire\Admin\QuizPreview; // ✅ TAMBAHKAN INI

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
| AUTH ROUTES (harus di atas middleware auth)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/tentang', AdminTentang::class)->name('admin.tentang');
    Route::get('/daftar-kuis', AdminDaftarKuis::class)->name('admin.daftar-kuis');
    Route::get('/create-quiz', CreateQuiz::class)->name('admin.create-quiz');
    Route::get('/edit-quiz/{quiz}', EditQuiz::class)->name('admin.edit-quiz');
    Route::get('/manage-questions/{quiz}', ManageQuestions::class)->name('admin.manage-questions');
    Route::get('/quiz-preview/{quiz}', QuizPreview::class)->name('admin.quiz-preview'); // ✅ TAMBAHKAN ROUTE INI
    Route::get('/materi', AdminMateri::class)->name('admin.materi');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isUser'])->prefix('user')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/daftar-kuis', DaftarKuis::class)->name('daftar-kuis');
    Route::get('/materi', Materi::class)->name('materi');
    Route::get('/tentang', Tentang::class)->name('tentang');
    
    // ✅ Routes baru untuk pengerjaan kuis
    Route::get('/quiz/{quiz}', TakeQuiz::class)->name('user.quiz-attempt');
    Route::get('/quiz-result/{quizAttempt}', QuizResult::class)->name('user.quiz-result');
});