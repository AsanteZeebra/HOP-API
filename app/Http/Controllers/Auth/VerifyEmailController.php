<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;


class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        // Validate the hash
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        // If already verified
        if ($user->hasVerifiedEmail()) {
            return Redirect::to(env('FRONTEND_URL') . '/login?verified=1');
        }

        // Mark email as verified
        $user->markEmailAsVerified();
        event(new Verified($user));

        // Redirect to frontend login
        return Redirect::to(env('FRONTEND_URL') . '/login?verified=1');
    }
}
