<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Dashboard\DashbaordController;
use App\Http\Controllers\Branches\BranchController;
use App\Http\Controllers\Pastors\PastorsController;
use App\Http\Controllers\Members\MembersController;





Route::middleware('api')->group(function () {

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::post('/login', function (Request $request) {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();

        if (!$user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email not verified'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });



});


Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logged out']);
});


Route::middleware('auth:sanctum')->post('/email/verification-notification', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'Already verified']);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification link sent!']);
});

    Route::middleware('auth:sanctum') ->post('/send-reset-link', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');

    Route::middleware('auth:sanctum')->get('/count-dashboard', [DashbaordController::class, 'index']);

    // Branches Routes
    Route::middleware('auth:sanctum')->post('/add-branch', [BranchController::class, 'store'])
    ->name('branches.store');
    Route::middleware('auth:sanctum')->get('/view-branches', [BranchController::class, 'index'])
    ->name('branches.index');
    Route::middleware('auth:sanctum')->get('/fetch-branch/{branch_id}', [BranchController::class, 'show'])
    ->name('branches.show');
    Route::middleware('auth:sanctum')->delete('/delete-branch/{branch_id}', [BranchController::class, 'destroy'])
    ->name('branches.destroy');
    Route::middleware('auth:sanctum')->put('/update-branch/{branch_id}', [BranchController::class, 'update'])
    ->name('branches.update');

     // Pastors Routes
    Route::middleware('auth:sanctum')->get('/pastors', [PastorsController::class, 'index'])
    ->name('pastors.index');
    Route::middleware('auth:sanctum')->post('/add-pastor', [PastorsController::class, 'store'])
    ->name('pastors.store');
    Route::middleware('auth:sanctum')->get('/fetch-pastor/{pastor_code}', [PastorsController::class, 'show'])
    ->name('pastors.show');
     Route::middleware('auth:sanctum')->patch('/update-pastor/{pastor_code}', [PastorsController::class, 'update'])
    ->name('pastors.update');
    Route::middleware('auth:sanctum')->delete('/delete-pastor/{pastor_code}', [PastorsController::class, 'destroy'])
    ->name('pastors.destroy');
    Route::middleware('auth:sanctum')->post('/upload-pastor-photo/{pastor_code}', [PastorsController::class, 'upload'])
    ->name('pastors.upload');
     Route::middleware('auth:sanctum')->put('/transfer-pastor/{pastor_code}', [PastorsController::class, 'transfer'])
    ->name('pastors.transfer');

    // Members Routes
      Route::middleware('auth:sanctum')->get('/members', [MembersController::class, 'index'])
    ->name('members.index');







