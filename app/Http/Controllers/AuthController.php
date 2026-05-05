<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if ($user->role && $user->role->name === 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // Step 1: Validate form, save pending user, send OTP
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $customerRole = Roles::firstOrCreate(['name' => 'customer']);

        $user = User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role_id'        => $customerRole->id,
            'otp'            => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        // Pass email to OTP page via session
        session(['otp_email' => $user->email]);

        return redirect()->route('otp.show')->with('success', 'OTP sent to your email!');
    }

    // Step 2: Show OTP input page
    public function showOtp()
    {
        if (!session('otp_email')) {
            return redirect()->route('register');
        }
        return view('auth.otp');
    }

    // Step 3: Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $email = session('otp_email');
        $user  = User::where('email', $email)->first();

        // Trim the OTP to remove any extra spaces
        $enteredOtp = trim($request->otp);
        $storedOtp = trim($user->otp ?? '');

        if (!$user || $storedOtp !== $enteredOtp) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (now()->isAfter($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired. Please register again.']);
        }

        // Clear OTP and log in
        $user->update(['otp' => null, 'otp_expires_at' => null]);
        Auth::login($user);
        session()->forget('otp_email');

        return redirect('/')->with('success', 'Registration successful!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}