<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        /*$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);*/
        $request->validate(
            [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'terms_condition' => 'required',
            'g-recaptcha-response' => 'required|recaptcha'
        ],
            [
                'firstname.required'    => 'Firstname is a required field.',
                'firstname.max'         => 'Firstname length should be less than 255 characters',
                'lastname.required'     => 'Lastname is a required field.',
                'lastname.max'          => 'Lastname length should be less than 255 characters',
                'email.required'        => 'Email is a required field.',
                'email.max'             => 'Email length should be less than 255 characters',
                'email.email'           => 'Please enter valid email address',
                'email.unique'          => 'This email already exists and in use please try different one or contact support',
                'password.required'     => 'Password is a required field.',
                'password.min'          => 'Password length should be more than 8 characters',
                'password.regex'        => 'Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.',
                'terms_condition.required'       => 'Terms and Condition is a required field.',
                'g-recaptcha-response.recaptcha' => 'Captcha verification failed',
                'g-recaptcha-response.required'  => 'Please complete the captcha'
            ]
        );

        //Check if google recaptcha is valid under 2 minutes

        $data = $request->All();
        $name = (isset($data['firstname'])) ? $data['firstname'] : '';
        $last_name = (isset($data['lastname'])) ? $data['lastname'] : '';
        $type = (isset($data['type'])) ? $data['type'] : '';
        $client_type = (isset($data['client_type']) && $type != '') ? $data['client_type'] : '';
        $otp = rand(1000, 9999);
        Auth::login($user = User::create([
            'name' => $name,
            'last_name' => $last_name,
            'type' => $type,
            'otp' => $otp,
            'otp_send_at' => date('Y-m-d H:i:s'),
            'client_type' => $client_type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_new' => 1, // Set is_new as 1 for every new user
        ]));

        event(new Registered($user));

        return view('auth.verify-otp');
    }
}
