<?php



use App\Http\Controllers\UserController;
use App\Mail\MyTestEmail;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubmissionController;


Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');


//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Projects routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects')->middleware('auth');
Route::post('/projects', [ProjectController::class, 'storeProject'])->name('projects.store')->middleware('auth');
Route::put('/projects', [ProjectController::class, 'updateProject'])->name('projects.update')->middleware('auth');

Route::get('/projects_detail', [ProjectController::class, 'projectDetail'])->name('projects.detail')->middleware('auth');
Route::get('/projects_artwork', [ProjectController::class, 'projectArtwork'])->name('projects.artwork')->middleware('auth');
Route::get('/projects_design', [ProjectController::class, 'projectDesign'])->name('projects.design')->middleware('auth');
Route::get('/projects_member', [ProjectController::class, 'projectMember'])->name('projects.member')->middleware('auth');

// Submissions routes
Route::get('/artworks', [SubmissionController::class, 'index'])->name('artworks')->middleware('auth');
Route::put('/artworks', [SubmissionController::class, 'updateArtwork'])->name('artworks.update')->middleware('auth');
Route::post('/artworks', [SubmissionController::class, 'storeArtwork'])->name('artworks.store')->middleware('auth');

Route::get('/submission_view', [SubmissionController::class, 'submissionView'])->name('submission.view')->middleware('auth');
Route::post('/submission_approve', [SubmissionController::class, 'approveSubmission'])->name('submission.approve')->middleware('auth');
Route::post('/submission_reject', [SubmissionController::class, 'rejectSubmission'])->name('submission.reject')->middleware('auth');

Route::get('/designs', [SubmissionController::class, 'listDesign'])->name('designs')->middleware('auth');
Route::put('/designs', [SubmissionController::class, 'updateDesign'])->name('designs.update')->middleware('auth');
Route::post('/designs', [SubmissionController::class, 'storeDesign'])->name('designs.store')->middleware('auth');


// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// User routes
Route::post('/user', [UserController::class, 'storeUserInProject'])->name('user.store');
Route::delete('/user', [UserController::class, 'deleteFromProject'])->name('user.delete');

// Show form to request password reset
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Send reset email
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// Show reset form
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Handle actual password reset
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


Route::get('/testroute', function () {
    $name = 'John Doe';

    Mail::to('hikarinrin99@gmail.com')->send(new MyTestEmail($name));
    echo 'Email sent successfully!';
});
