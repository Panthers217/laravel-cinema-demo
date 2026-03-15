<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FirebaseAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class AdminAuthController extends Controller
{
    public function __construct(private readonly FirebaseAuthService $firebaseAuthService)
    {
    }

    public function showLoginForm(Request $request): View|RedirectResponse
    {
        if ($request->session()->get('admin_authenticated', false)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $claims = $this->firebaseAuthService->authenticateWithEmailAndPassword(
                $credentials['email'],
                $credentials['password']
            );
        } catch (RuntimeException $exception) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => $exception->getMessage()]);
        }

        $tokenEmail = strtolower((string) ($claims['email'] ?? ''));
        $adminEmail = strtolower((string) config('firebase.admin_email', ''));

        if ($adminEmail !== '' && ! hash_equals($adminEmail, $tokenEmail)) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'You are not allowed to access the admin panel.']);
        }

        if (($claims['email_verified'] ?? false) !== true) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'Your Firebase email is not verified.']);
        }

        $request->session()->regenerate();
        $request->session()->put('admin_authenticated', true);
        $request->session()->put('admin_email', $tokenEmail ?: $credentials['email']);
        $request->session()->put('firebase_uid', $claims['user_id'] ?? null);

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['admin_authenticated', 'admin_email']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }
}
