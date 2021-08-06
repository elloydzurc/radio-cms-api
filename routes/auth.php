<?php
declare(strict_types=1);

use App\Http\Controllers\Api\AppUserVerifyEmailController;
use App\Http\Controllers\Cms\EmailVerificationNotificationController;
use App\Http\Controllers\Cms\EmailVerificationPromptController;
use App\Http\Controllers\Cms\VerifyEmailController;
use Illuminate\Support\Facades\Route;

$adminUrl = env('APP_ADMIN_URL');

Route::get($adminUrl . '/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->middleware('auth')
                ->name('verification.notice');

Route::get($adminUrl . '/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

Route::post($adminUrl . '/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');

Route::get('/app-user-verify-email/{id}/{hash}', [AppUserVerifyEmailController::class, '__invoke'])
                ->name('app.user.verification.verify');
