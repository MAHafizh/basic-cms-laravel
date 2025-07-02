<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function indexLogin(Request $request)
    {
        return view('auth.login', ['title' => 'Login']);
    }

    public function indexRegister(Request $request)
    {
        return view('auth.register', ['title' => 'Register']);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $validated['password'] = Hash::make($request->password);
        $user = User::create($validated);
        
        Auth::login($user);
        event(new Registered($user));

        return redirect()->route('verification.notice')->with('success', 'User created successfully!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);
        $remember = $request->filled('remember');
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        Auth::login($user, $remember);
        if ($request->wantsJson()) {
            $token = $user->createToken($request->device_name)->plainTextToken;
            return response()->json([
                'message' => 'Logged in successfully.',
                'token' => $token,
                'user' => $user->only(['id', 'name', 'email']),
            ]);
        }
        session([
            'user' => $user->only(['id', 'name', 'email']),
        ]);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        if ($request->user() && method_exists($request->user(), 'currentAccessToken')) {
            $token = $request->user()->currentAccessToken();
            if ($token) {
                $token->delete();
            }
        }
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        DB::table('sessions')->where('id', session()->getId())->delete();
        Auth::logout();
        return redirect('/')->with('message', 'Logged out successfully.');
    }
}
