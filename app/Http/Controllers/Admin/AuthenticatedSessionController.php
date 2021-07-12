<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\AdminRouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // /**
    //  * The guard implementation.
    //  *
    //  * @var \Illuminate\Contracts\Auth\StatefulGuard
    //  */
    // protected $guard;

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @param \Illuminate\Contracts\Auth\StatefulGuard
    //  * @return void
    //  */
    
    // public function __construct(StatefulGuard $guard, Request $request)
    // {
    //     $this->guard = $guard;
    //     dd($guard);
    // }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        dd($request);
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(AdminRouteServiceProvider::HOME);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(AdminRouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
