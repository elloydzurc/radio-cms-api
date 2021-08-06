<?php
declare(strict_types=1);

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Notifications\Cms\UserVerificationNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

/**
 * Class EmailVerificationNotificationController
 *
 * @package App\Http\Controllers\Cms
 */
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        /** @var \App\Models\User $user */
        $user = $request->user();
        $user->notify(new UserVerificationNotification());

        return back()->with('status', 'verification-link-sent');
    }
}
