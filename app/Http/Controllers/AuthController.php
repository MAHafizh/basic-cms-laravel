<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('login', ['title' => 'Login']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Logged in successfully.',
                'token' => $token,
                'user' => $user->only(['id', 'name', 'email']),
            ]);
        }
        session([
            'token' => $token,
            'user' => $user->only(['id', 'name', 'email']),
        ]);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        DB::table('sessions')->where('id', session()->getId())->delete();
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->user()->currentAccessToken()->delete();
        return redirect()->route('login')->with('message', 'Logged out successfully.');
    }
}
