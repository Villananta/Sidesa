<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;



class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::check()){
            return back();
        }

        return view("pages.auth.login");
    }
    public function authenticate(Request $request){

        if(Auth::check()){
            return back();
        }
        
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'password.required'=> 'Password harus diisi',
            'email.required'=> 'Email harus diisi',
            'email.email'=> 'Email tidak valid',
        ]);
 
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $userStatus = Auth::user()->status;

            if ($userStatus == 'submitted') {
                $this->_logout($request);
                return back()->withErrors(['email' => 'Akun anda menunggu persetujuan admin']);
            } else if ($userStatus == 'rejected') {
                $this->_logout($request);
                return back()->withErrors(['email' => 'Akun anda ditolak oleh admin']);
            }
            
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'Terjadi Kesalahan, Periksa Kembali Email atau Password',
        ])->onlyInput('email');
    }

    public function registerView(){
        if(Auth::check()){
            return back();
        }
    return view('pages.auth.register');
    }

    public function register(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'max:100'],
            'email'=> ['required', 'email', 'unique:users,email'],
            'password'=> ['required'],
            
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = bcrypt($validated['password']);
        $user->role_id = 2;
        $user->saveOrFail();

        return redirect('/')->with('success', 'Berhasil mendaftarkan akun,menunggu persetujuan admin');
    }

public function _logout(Request $request): RedirectResponse
{
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
}

public function logout(Request $request): RedirectResponse
{
    if (!Auth::check()) {
        return redirect('/');
    }

    return $this->_logout($request);
}


    
}
