<?php

declare(strict_types=1);

namespace XMultibyte\BlatAdmin\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        /** @var string $guard */
        $guard = Config::get('blat-admin.guard', 'blat-admin');

        if (Auth::guard($guard)->check()) {
            return new RedirectResponse(route('blat-admin.dashboard'));
        }

        /** @var View $view */
        $view = view('blat-admin::pages.login');

        return $view;
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var string $guard */
        $guard = Config::get('blat-admin.guard', 'blat-admin');

        $remember = $request->boolean('remember');

        if (Auth::guard($guard)->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var string $dashboardUrl */
            $dashboardUrl = route('blat-admin.dashboard');

            return redirect()->intended($dashboardUrl);
        }

        return back()->withErrors([
            'email' => __('The provided credentials do not match our records or the account is inactive.'),
        ])->onlyInput('email');
    }

    /**
     * Log the admin user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        /** @var string $guard */
        $guard = Config::get('blat-admin.guard', 'blat-admin');

        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new RedirectResponse(route('blat-admin.login'));
    }
}
