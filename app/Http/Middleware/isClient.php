<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class isClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->is_block) {
                Auth::logout();
                return redirect('/login')->with('warning', 'Your account has been temporarily suspended. We are looking into this. You can contact us at <a href="mailto:team@kynderway.com">team@kynderway.com</a> regarding your account suspension.');
            }
            if (Auth::user()->type == 'service_seeker') {
                if ($request->verified == "1") {
                    return redirect('/user/client/manage-profile');
                }

                if (Auth::user()->country == '' && strpos($request->url(), 'post-vacancy')) {
                    return redirect('/user/client/manage-profile')->with('warning', 'Please complete your profile first to post jobs.');
                }
                return $next($request);
            } elseif (Auth::user()->type == 'service_provider') {
                return redirect('/provider');
            } elseif (Auth::user()->type == 'admin') {
                return redirect('/admin');
            } else {
                Auth::logout();
                Session::flash('alert-warning', 'Unknown user type');
                return redirect('/login');
            }
        } else {
            Auth::logout();
            Session::flash('alert-warning', 'Not logged-in');
            return redirect('/login');
        }
    }
}
