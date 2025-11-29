<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import semua komponen Livewire
use App\Livewire\User\Dashboard;
use App\Livewire\User\DaftarKuis;
use App\Livewire\User\Tentang;
use App\Livewire\User\TakeQuiz;
use App\Livewire\User\QuizResult;
use App\Livewire\User\Profile;
use App\Livewire\User\AddFriend;
use App\Livewire\User\Chat;
use App\Livewire\User\LearningContents;
use App\Livewire\User\LearningContentDetail;
use App\Livewire\User\Leaderboard;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\Admin\Tentang as AdminTentang;
use App\Livewire\Admin\DaftarKuis as AdminDaftarKuis;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\ManageLearningContents;
use App\Livewire\Admin\CreateLearningContent;
use App\Livewire\Admin\EditLearningContent;
use App\Livewire\Admin\CreateQuiz;
use App\Livewire\Admin\EditQuiz;
use App\Livewire\Admin\ManageQuestions;
use App\Livewire\Admin\QuizPreview;
use App\Livewire\Admin\Profile as AdminProfile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (welcome) - redirect ke login
Route::get('/', function () {
    return redirect('/login');
});

// Logout - perbaiki method ke POST
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Kamu sudah logout.');
})->name('logout');

// Fallback logout GET (untuk compatibility)
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Kamu sudah logout.');
});

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
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/tentang', AdminTentang::class)->name('tentang');
    
    // ✅ TAMBAH: LEARNING CONTENT ROUTES
    Route::get('/learning-contents', ManageLearningContents::class)->name('learning-contents');
    Route::get('/learning-contents/create', CreateLearningContent::class)->name('learning-contents.create');
    Route::get('/learning-contents/edit/{id}', EditLearningContent::class)->name('learning-contents.edit');
    
    // QUIZ ROUTES
    Route::get('/daftar-kuis', AdminDaftarKuis::class)->name('daftar-kuis');
    Route::get('/create-quiz', CreateQuiz::class)->name('create-quiz');
    Route::get('/edit-quiz/{quiz}', EditQuiz::class)->name('edit-quiz');
    Route::get('/manage-questions/{quiz}', ManageQuestions::class)->name('manage-questions');
    Route::get('/quiz-preview/{quiz}', QuizPreview::class)->name('quiz-preview');
    
    
    Route::get('/profile', AdminProfile::class)->name('profile'); 
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isUser'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/daftar-kuis', DaftarKuis::class)->name('daftar-kuis');
    Route::get('/leaderboard', Leaderboard::class)->name('leaderboard');
    
    // ✅ TAMBAH: LEARNING CONTENT ROUTES UNTUK USER
    Route::get('/learning-contents', LearningContents::class)->name('learning-contents');
    Route::get('/learning-contents/{id}', LearningContentDetail::class)->name('learning-contents.detail');
    
    Route::get('/tentang', Tentang::class)->name('tentang');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/add-friend', AddFriend::class)->name('add-friend');
    Route::get('/chat', Chat::class)->name('chat');

    // Routes untuk pengerjaan kuis
    Route::get('/quiz/{quiz}', TakeQuiz::class)->name('quiz-attempt');
    Route::get('/quiz-result/{quizAttempt}', QuizResult::class)->name('quiz-result');
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/about', function () {
    return view('public.about');
})->name('about');

Route::get('/features', function () {
    return view('public.features');
})->name('features');

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (untuk handle 404)
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect('/login');
});