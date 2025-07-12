<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormQuestionController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\KonselingMahasiswaController;
use App\Http\Controllers\KonselingKonselorController;
use App\Http\Controllers\FormAnswerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KonselingHistoryController;
use App\Http\Controllers\RescheduleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KonselorManagementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/symlink', function () {
    Artisan::call('storage:link');
    return 'Symlink created successfully';
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::resource('form-questions', FormQuestionController::class);
// });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // // Mahasiswa Routes
    Route::resource('konseling-mahasiswa', KonselingMahasiswaController::class)
        ->parameters([
            'konseling-mahasiswa' => 'konseling'
        ]);
    Route::resource('/form-answers', FormAnswerController::class);
    Route::get('/feedback/create/{sesi_id}', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    Route::put('konseling-mahasiswa/{konseling}/reschedule', [KonselingMahasiswaController::class, 'updateReschedule'])
    ->name('konseling-mahasiswa.reschedule');
    Route::get('/check-slots', [KonselingMahasiswaController::class, 'checkSlots'])
    ->name('konseling.check-slots')
    ->middleware('auth');

    // Konselor Routes
    Route::resource('form-questions', FormQuestionController::class);
    Route::post('/form-questions/update-order', [FormQuestionController::class, 'updateOrder'])
    ->name('form-questions.update-order')
    ->middleware(['auth']);
    Route::resource('sessions', SessionController::class);
    // Route::group(['middleware' => 'role:konselor'], function () {
    Route::resource('konseling-konselor', KonselingKonselorController::class)
        ->parameters(['konseling-konselor' => 'konseling'])
        ->only(['index', 'edit', 'update', 'show']);
    Route::put('konseling-konselor/{konseling}/status', [KonselingKonselorController::class, 'updateStatus'])
        ->name('konseling-konselor.status');
    

    Route::resource('konseling-history', KonselingHistoryController::class)
        ->only(['index', 'show', 'update']);
        Route::get('/reschedule/{konseling}', [RescheduleController::class, 'create'])->name('reschedule.create');
        Route::post('/reschedule/{konseling}', [RescheduleController::class, 'store'])->name('reschedule.store');

        Route::put('konseling-konselor/{konseling}/toggle-chat', [KonselingKonselorController::class, 'toggleChat'])
    ->name('konseling-konselor.toggle-chat');
    Route::resource('konselor-management', KonselorManagementController::class)
    ->parameters(['konselor-management' => 'konselor']);    
    Route::put('konselor-management/{konselor}/toggle-status', [KonselorManagementController::class, 'toggleStatus'])
    ->name('konselor-management.toggle-status');
    Route::get('/check-reschedule-slots', [RescheduleController::class, 'checkRescheduleSlots'])
    ->name('reschedule.check-slots')
    ->middleware('auth');


});

require __DIR__ . '/auth.php';
