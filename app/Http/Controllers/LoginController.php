<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if(Auth::user()){
            return redirect()->intended('dashboard');
        }

        return view('login.view_login');
    }

    public function proses(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $kredensial = $request->only('username', 'password');

        if(Auth::attempt($kredensial)){
            $request->session()->regenerate();

            $user = Auth::user();

            if($user){
                return redirect()->intended('dashboard')->with([
                    'case' => 'heading',
                    'type' => 'primary',
                    'head' => 'Hello, Welcome back!',
                    'message' => 'Login Successfully.'
                ]);
            }

            return redirect()->intended('/');
        }
        
        return back()->withErrors([
            'username' => 'Username or Password Wrong'
        ])->onlyInput('username');
    }

    public function logout(Request $request){
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/login');
    }
}
