<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    protected $redirectPath = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Validate incoming request for login
     *
     * @return \Illuminate\Http\Response
     */
    public function loginValidation(Request $request)
    {
        return Validator::make($request->all(), [
            "email" => [
                "bail", "required", "email", "exists:App\Models\User,email"
            ],
            "password" => "bail|required"
        ], [
            "email.required" => __('validation.required', ['attribute' => 'alamat e-mail']),
            "email.email" => __('validation.email.string', ['attribute' => 'alamat e-mail']),
            "email.exists" => __('validation.exists', ['attribute' => 'alamat e-mail']),
            "email.required_without" => __('validation.required_without', ['attribute' => 'alamat e-mail', 'values' => 'nomor telepon']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function login(Request $request)
    {
        $validator = $this->loginValidation($request);

        if ($validator->fails()) {
            return redirect()->back()->with('message', 'Invalid form data')->with('state', 'error')->withErrors($validator)->withInput();
        }

        $remember = $request->has('remember') ? true : false;
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $remember)) {
            
            return redirect()->route('dashboard')->with('message', 'Login Berhasil');            
        }

        return redirect()->back()->with('message', 'Login Failed'); 
    }

    
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function logout(Request $request)
    {
        Auth::logout();
        if (! $request->expectsJson()) {
            return redirect($this->redirectPath);
        }
        return response_json(true, null, 'Login Berhasil.', redirect($this->redirectPath)->getTargetUrl());
    }
}
