<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $user_type = $request->user()->type;
        $client_type = $request->user()->client_type;
        $redirection_url = RouteServiceProvider::INDIVIDUAL_MANAGE_PROFILE;

        if ($user_type == "service_provider") {
            $redirection_url = RouteServiceProvider::PROVIDER_MANAGE_PROFILE;
        } else {
            if ($client_type == "Private") {
                $redirection_url = RouteServiceProvider::INDIVIDUAL_MANAGE_PROFILE;
            } else {
                $redirection_url = RouteServiceProvider::BUSINESS_MANAGE_PROFILE;
            }
        }

        if ($request->user()->hasVerifiedEmail()) {
            // return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            return redirect($redirection_url.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        // return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        return redirect($redirection_url.'?verified=1');
    }
}
