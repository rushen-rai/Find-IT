<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AlertController;

// ---------- AUTH ROUTES ----------
Route::get('/login', function () {
    return redirect('/sign-in');
});

Route::get('/', [AuthController::class, 'showSignUp'])->name('signup');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/sign-in', [AuthController::class, 'showSignIn'])->name('signin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- PROTECTED ROUTES ----------
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ItemController::class, 'dashboard'])->name('dashboard');

    // Components
    Route::get('/report', [PageController::class, 'reportForm'])->name('report.create');
    Route::get('/proof', [PageController::class, 'proofForm'])->name('proof.create');
    Route::get('/admin/approval', [PageController::class, 'adminApproval'])->name('admin.approval');
    Route::post('/reports', [ItemController::class, 'store'])->name('reports.store');
    Route::post('/claims', [ClaimController::class, 'store'])->name('claims.store');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/mark-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
    Route::get('/admin/approval/overlay', function () {
        return view('components.admin_approval');
    });
    Route::get('/items/{id}/details', [ItemController::class, 'showItem'])->middleware('auth');

    // Alerts (using AlertController)
    Route::get('/alerts', [AlertController::class, 'alerts'])->middleware('auth');
    Route::post('/alerts/mark-read/{id}', [AlertController::class, 'markAsRead'])->middleware('auth');

    // Fixed routes for report management (admin only, enforced in controller) - now match JS exactly
    Route::post('/reports/{id}/approved', [ItemController::class, 'approveReport']);  // Changed from /approve
    Route::post('/reports/{id}/rejected', [ItemController::class, 'rejectReport']);  // Changed from /reject
    Route::delete('/reports/{id}', [ItemController::class, 'deleteReport']);
    
    // Fixed routes for claim management (admin only, enforced in controller) - now match JS exactly
    Route::post('/claims/{id}/approved', [ClaimController::class, 'approveClaim']);  // Changed from /approve
    Route::post('/claims/{id}/rejected', [ClaimController::class, 'rejectClaim']);  // Changed from /reject
    Route::get('/claims/{id}/status', [ClaimController::class, 'getClaimStatus']); // For polling
    Route::get('/claims/{id}/details', [ClaimController::class, 'showClaim'])->middleware('auth');
    Route::post('/claims/{id}/claimed', [ClaimController::class, 'claimItem']);

    // New API route for dynamic analytics
    Route::get('/api/analytics', [ItemController::class, 'getAnalyticsData'])->name('api.analytics');
});
