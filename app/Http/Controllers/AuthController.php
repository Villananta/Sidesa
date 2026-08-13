<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class AuthController extends Controller
{
    public function login(Request $request){
        return view("pages.auth.login");
    }
    public function authenticate(request $request){
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userStatus = Auth::user()->status;

            if ($userStatus == 'submitted') {
                return back()->withErrors(['email' => 'Akun anda menunggu persetujuan admin']);
            } else if ($userStatus == 'rejected') {
                return back()->withErrors(['email' => 'Akun anda ditolak oleh admin']);
            }
            
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'Terjadi Kesalahan, Periksa Kembali Email atau Password',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
{
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
}
}
