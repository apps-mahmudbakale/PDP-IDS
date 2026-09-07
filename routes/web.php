<?php

use App\Http\Controllers\Apps\Members\DEPsController;
use App\Http\Controllers\Apps\Members\NECController;
use App\Http\Controllers\Apps\Members\NWCController;
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MemberPublicProfileController;
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

// Public member profile (accessible via QR code)
Route::get('/member/{uuid}', [MemberPublicProfileController::class, 'show'])->name('members.public-profile');

// Public attendance scanning (accessible via QR code)
Route::post('/meetings/{uuid}/check-in', [AttendanceController::class, 'checkIn'])->name('meetings.check-in');
Route::get('/meetings/{uuid}/scan', function ($uuid) {
    $meeting = \App\Models\Meeting::where('public_uuid', $uuid)->firstOrFail();
    return view('meetings.attendance-check-in', compact('meeting'));
})->name('meetings.attendance-scan');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::name('members.')->group(function () {
        Route::resource('/members/nwc', NWCController::class)->names('nwc');
        Route::resource('/members/nec', NECController::class)->names('nec');
        Route::resource('/members/deps', DEPsController::class)->names('deps');
    });

    // Meeting routes
    Route::resource('/meetings', MeetingController::class);
    
    // Attendance routes
    Route::name('attendance.')->group(function () {
        Route::post('/meetings/{meeting}/mark-absent', [AttendanceController::class, 'markAbsent'])->name('mark-absent');
        Route::put('/attendance/{attendance}/reassign-seat', [AttendanceController::class, 'reassignSeat'])->name('reassign-seat');
        Route::get('/meetings/{meeting}/export', [AttendanceController::class, 'exportAttendance'])->name('export');
    });

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
