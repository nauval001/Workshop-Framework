<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OtpMail;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'id_google' => $googleUser->getId(),
                    'password' => null,
                ]);
            } else {
                $user->update(['id_google' => $googleUser->getId()]);
            }

            $otp = strtoupper(Str::random(6));
            $user->update(['otp' => $otp]);
            Mail::to($user->email)->send(new OtpMail($otp));

            session(['otp_email' => $user->email]);
            return redirect()->route('otp.form');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login menggunakan Google. Pastikan konfigurasi .env sudah benar.');
        }
    }
    
    public function otpForm()
    {
        if (!session('otp_email')) {
            return redirect('/login');
        }
        return view('auth.otp'); 
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $email = session('otp_email');
        $user = User::where('email', $email)->where('otp', $request->otp)->first();

        if ($user) {
            $user->update(['otp' => null]);
            session()->forget('otp_email');
            Auth::login($user);
            return redirect()->route('home');
        }

        return back()->with('error', 'Kode OTP salah.');
    }
}