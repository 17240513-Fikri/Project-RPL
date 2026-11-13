<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password tidak sesuai.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nik' => ['required', 'string', 'max:20'],
            'family_card_number' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:pengguna,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $resident = Resident::with('household')
            ->where('nik', $data['nik'])
            ->whereHas('household', function ($query) use ($data) {
                $query->where('nomor_kk', $data['family_card_number']);
            })
            ->first();

        if (! $resident) {
            throw ValidationException::withMessages([
                'nik' => 'NIK dan nomor KK tidak ditemukan atau tidak cocok dengan data warga.',
            ]);
        }

        if (User::where('warga_id', $resident->id)->exists()) {
            throw ValidationException::withMessages([
                'nik' => 'Data warga ini sudah memiliki akun. Silakan login atau hubungi admin.',
            ]);
        }

        $user = User::create([
            'resident_id' => $resident->id,
            'name' => $resident->name,
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'warga',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil. Akun warga sudah aktif.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
